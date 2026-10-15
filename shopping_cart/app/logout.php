
<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Xóa toàn bộ dữ liệu session
$_SESSION = [];

// Hủy session hiện tại
session_destroy();

// Chuyển về trang đăng nhập
header("Location: login.php");
exit;
