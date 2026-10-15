
<?php

require_once __DIR__ . "/model/user.php";

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Nếu đã đăng nhập thì chuyển đến danh sách
if (isset($_SESSION["user_id"])) {
    header("Location: product_list.php");
    exit;
}

$username = "";
$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST["username"] ?? "");
    $password = $_POST["password"] ?? "";

    if ($username === "" || trim($password) === "") {
        $error = "Vui lòng nhập đầy đủ tên đăng nhập và mật khẩu.";
    } else {
        $user = getUserByUsername($username);

        if (
            $user &&
            password_verify($password, $user["password"])
        ) {
            // Tạo session mới sau khi đăng nhập
            session_regenerate_id(true);

            $_SESSION["user_id"] = $user["id"];
            $_SESSION["username"] = $user["username"];

            header("Location: product_list.php");
            exit;
        } else {
            $error = "Tên đăng nhập hoặc mật khẩu không chính xác.";
        }
    }
}

require_once __DIR__ . "/view/header.php";
?>

<h2>Đăng nhập</h2>

<?php if (isset($_GET["registered"])): ?>
    <p>Đăng ký thành công. Hãy đăng nhập.</p>
<?php endif; ?>

<?php if ($error !== ""): ?>
    <p><?= htmlspecialchars($error) ?></p>
<?php endif; ?>

<form method="POST" action="login.php">
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

    <button type="submit">Đăng nhập</button>
</form>

<p>
    Chưa có tài khoản?
    <a href="register.php">Đăng ký</a>
</p>

<?php require_once __DIR__ . "/view/footer.php"; ?>
