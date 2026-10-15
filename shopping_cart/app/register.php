
<?php

require_once __DIR__ . "/model/user.php";

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Đã đăng nhập thì không cần đăng ký lại
if (isset($_SESSION["user_id"])) {
    header("Location: product_list.php");
    exit;
}

$username = "";
$errors = [];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST["username"] ?? "");
    $password = $_POST["password"] ?? "";

    // Kiểm tra dữ liệu
    if ($username === "") {
        $errors[] = "Tên đăng nhập không được để trống.";
    } elseif (strlen($username) > 50) {
        $errors[] = "Tên đăng nhập không được dài quá 50 ký tự.";
    }

    if (trim($password) === "") {
        $errors[] = "Mật khẩu không được để trống.";
    }

    // Kiểm tra tên đăng nhập
    if (empty($errors) && usernameExists($username)) {
        $errors[] = "Tên đăng nhập đã tồn tại.";
    }

    // Đăng ký nếu dữ liệu hợp lệ
    if (empty($errors)) {
        $hashedPassword = password_hash(
            $password,
            PASSWORD_DEFAULT
        );

        try {
            if (registerUser($username, $hashedPassword)) {
                header("Location: login.php?registered=1");
                exit;
            }

            $errors[] = "Đăng ký thất bại.";
        } catch (PDOException $e) {
            // Xử lý trường hợp hai yêu cầu đăng ký
            // cùng sử dụng một username
            if ($e->getCode() === "23000") {
                $errors[] = "Tên đăng nhập đã tồn tại.";
            } else {
                $errors[] = "Đã xảy ra lỗi khi đăng ký.";
            }
        }
    }
}

require_once __DIR__ . "/view/header.php";
?>

<h2>Đăng ký tài khoản</h2>

<?php if (!empty($errors)): ?>
    <ul>
        <?php foreach ($errors as $error): ?>
            <li><?= htmlspecialchars($error) ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<form method="POST" action="register.php">
    <p>
        <label>Tên đăng nhập:</label><br>
        <input
            type="text"
            name="username"
            maxlength="50"
            required
            value="<?= htmlspecialchars($username) ?>"
        >
    </p>

    <p>
        <label>Mật khẩu:</label><br>
        <input
            type="password"
            name="password"
            required
        >
    </p>

    <button type="submit">Đăng ký</button>
</form>

<p>
    Đã có tài khoản?
    <a href="login.php">Đăng nhập</a>
</p>

<?php require_once __DIR__ . "/view/footer.php"; ?>