<?php
declare(strict_types=1);

// Chỉ xuất JSON; lỗi kỹ thuật được ghi vào nhật ký PHP.
ini_set('display_errors', '0');
header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: no-store');

function respond(int $status, array $body): void
{
    http_response_code($status);
    echo json_encode($body, JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR);
    exit;
}

function readProduct(): array
{
    try {
        $body = json_decode(file_get_contents('php://input'), false, 512, JSON_THROW_ON_ERROR);
    } catch (JsonException $e) {
        respond(400, ['success' => false, 'message' => 'JSON không hợp lệ.']);
    }
    if (!is_object($body)) {
        respond(400, ['success' => false, 'message' => 'Dữ liệu phải là một đối tượng JSON.']);
    }

    if (!isset($body->name) || !is_string($body->name)) {
        respond(422, ['success' => false, 'message' => 'Tên sản phẩm phải là chuỗi.']);
    }
    // Bỏ cả khoảng trắng Unicode ở hai đầu; đếm ký tự tiếng Việt, không đếm byte.
    $name = preg_replace('/^\s+|\s+$/u', '', $body->name);
    $length = preg_match_all('/./us', $name);
    if ($length < 1 || $length > 100) {
        respond(422, ['success' => false, 'message' => 'Tên sản phẩm phải có từ 1 đến 100 ký tự.']);
    }
    // Giới hạn trên tương ứng với cột INT có dấu của MySQL.
    if (!isset($body->price) || !is_int($body->price) || $body->price <= 0 || $body->price > 2147483647) {
        respond(422, ['success' => false, 'message' => 'Đơn giá phải là số nguyên từ 1 đến 2147483647.']);
    }
    if (!isset($body->stock) || !is_int($body->stock) || $body->stock < 0 || $body->stock > 2147483647) {
        respond(422, ['success' => false, 'message' => 'Tồn kho phải là số nguyên từ 0 đến 2147483647.']);
    }
    return ['name' => $name, 'price' => $body->price, 'stock' => $body->stock];
}

try {
    $method = $_SERVER['REQUEST_METHOD'];
    if (!in_array($method, ['GET', 'POST', 'PUT', 'DELETE'], true)) {
        header('Allow: GET, POST, PUT, DELETE');
        respond(405, ['success' => false, 'message' => 'Phương thức không được hỗ trợ.']);
    }

    $id = null;
    if ($method === 'PUT' || $method === 'DELETE') {
        $id = filter_var($_GET['id'] ?? null, FILTER_VALIDATE_INT, [
            'options' => ['min_range' => 1, 'max_range' => 2147483647]
        ]);
        if ($id === false) {
            respond(400, ['success' => false, 'message' => 'id phải là số nguyên dương.']);
        }
    }
    // Kiểm tra dữ liệu trước khi kết nối và ghi vào cơ sở dữ liệu.
    $product = ($method === 'POST' || $method === 'PUT') ? readProduct() : null;

    // Sửa ba giá trị này nếu cấu hình MySQL của bạn khác.
    $host = '127.0.0.1';
    $database = 'vue_products';
    $username = 'root';
    $password = '';
    $pdo = new PDO("mysql:host=$host;dbname=$database;charset=utf8mb4", $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]);

    if ($method === 'GET') {
        $rows = $pdo->query('SELECT id, name, price, stock FROM products ORDER BY id DESC')->fetchAll();
        foreach ($rows as &$row) {
            $row['id'] = (int) $row['id'];
            $row['price'] = (int) $row['price'];
            $row['stock'] = (int) $row['stock'];
        }
        unset($row);
        respond(200, ['success' => true, 'data' => $rows]);
    }

    if ($method === 'POST') {
        $stmt = $pdo->prepare('INSERT INTO products (name, price, stock) VALUES (:name, :price, :stock)');
        $stmt->execute($product);
        respond(201, ['success' => true, 'message' => 'Đã thêm sản phẩm.', 'id' => (int) $pdo->lastInsertId()]);
    }

    // Khóa dòng đến khi cập nhật/xóa xong, tránh dòng biến mất giữa hai truy vấn.
    $pdo->beginTransaction();
    $stmt = $pdo->prepare('SELECT id FROM products WHERE id = :id FOR UPDATE');
    $stmt->execute(['id' => $id]);
    if ($stmt->fetch() === false) {
        $pdo->rollBack();
        respond(404, ['success' => false, 'message' => 'Sản phẩm không tồn tại.']);
    }

    if ($method === 'PUT') {
        $stmt = $pdo->prepare('UPDATE products SET name = :name, price = :price, stock = :stock WHERE id = :id');
        $stmt->execute($product + ['id' => $id]);
        $message = 'Đã cập nhật sản phẩm.';
    } else {
        $stmt = $pdo->prepare('DELETE FROM products WHERE id = :id');
        $stmt->execute(['id' => $id]);
        $message = 'Đã xóa sản phẩm.';
    }
    $pdo->commit();
    respond(200, ['success' => true, 'message' => $message]);
} catch (Throwable $e) {
    if (isset($pdo) && $pdo->inTransaction()) {
        $pdo->rollBack();
    }
    error_log((string) $e);
    respond(500, ['success' => false, 'message' => 'Lỗi máy chủ. Hãy kiểm tra MySQL và cấu hình kết nối.']);
}
