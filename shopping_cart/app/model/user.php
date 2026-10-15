<?php

require_once __DIR__ . "/../common/dbConnect.php";

// Tìm tài khoản theo username
function getUserByUsername($username)
{
    global $conn;

    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$username]);

    return $stmt->fetch();
}

// Kiểm tra username đã tồn tại chưa
function usernameExists($username)
{
    global $conn;

    $sql = "SELECT id FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$username]);

    return $stmt->fetch() !== false;
}

// Đăng ký tài khoản
function registerUser($username, $hashedPassword)
{
    global $conn;

    $sql = "INSERT INTO users (username, password)
            VALUES (?, ?)";

    $stmt = $conn->prepare($sql);

    return $stmt->execute([$username, $hashedPassword]);
}
