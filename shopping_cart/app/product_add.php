<?php

require_once "model/product.php";

$name = "";
$price = "";
$quantity = "";
$errors = [];

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $name = trim($_POST["name"] ?? "");
    $price = trim($_POST["price"] ?? "");
    $quantity = trim($_POST["quantity"] ?? "");

    // Kiểm tra tên
    if ($name === "") {
        $errors[] = "Tên sản phẩm không được rỗng.";
    }

    // Kiểm tra giá
    if ($price === "" || !is_numeric($price) || $price <= 0) {
        $errors[] = "Giá sản phẩm phải lớn hơn 0.";
    }

    // Kiểm tra số lượng
    if (
        $quantity === "" ||
        filter_var($quantity, FILTER_VALIDATE_INT) === false ||
        $quantity < 0
    ) {
        $errors[] = "Số lượng phải là số nguyên lớn hơn hoặc bằng 0.";
    }

    // Nếu không có lỗi thì thêm sản phẩm
    if (empty($errors)) {

        addProduct(
            $name,
            (float)$price,
            (int)$quantity
        );

        header("Location: product_list.php");
        exit;
    }
}

require_once "view/header.php";
?>

<h2>Thêm sản phẩm</h2>

<?php if (!empty($errors)): ?>

    <ul>
        <?php foreach ($errors as $error): ?>
            <li><?= htmlspecialchars($error) ?></li>
        <?php endforeach; ?>
    </ul>

<?php endif; ?>

<form method="POST">

    <p>
        <label>Tên sản phẩm:</label><br>
        <input
            type="text"
            name="name"
            value="<?= htmlspecialchars($name) ?>"
        >
    </p>

    <p>
        <label>Giá:</label><br>
        <input
            type="number"
            name="price"
            step="0.01"
            value="<?= htmlspecialchars($price) ?>"
        >
    </p>

    <p>
        <label>Số lượng:</label><br>
        <input
            type="number"
            name="quantity"
            min="0"
            value="<?= htmlspecialchars($quantity) ?>"
        >
    </p>

    <button type="submit">Thêm sản phẩm</button>

</form>

<p>
    <a href="product_list.php">Quay lại danh sách</a>
</p>

<?php require_once "view/footer.php"; ?>