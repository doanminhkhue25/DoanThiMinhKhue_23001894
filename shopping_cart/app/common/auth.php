<?php

// Bắt đầu session nếu chưa bắt đầu
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Kiểm tra đăng nhập
function requireLogin()
{
    if (!isset($_SESSION["user_id"])) {
        header("Location: login.php");
        exit;
    }
}