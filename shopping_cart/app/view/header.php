
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản lý sản phẩm</title>
</head>
<body>

<h1>Quản lý sản phẩm</h1>

<?php if (isset($_SESSION["user_id"])): ?>
    <p>
        Xin chào,
        <strong><?= htmlspecialchars($_SESSION["username"]) ?></strong>
        |
        <a href="product_list.php">Danh sách sản phẩm</a>
        |
        <a href="product_add.php">Thêm sản phẩm</a>
        |
        <a href="logout.php">Đăng xuất</a>
    </p>
<?php endif; ?>

<hr>
