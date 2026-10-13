<?php

$servername = "localhost";
$username = "root";
$password = "";
$database = "shopping_cart";

try {
    $conn = new PDO(
        "mysql:host=$servername;dbname=$database;charset=utf8mb4",
        $username,
        $password
    );

    // Báo lỗi khi có lỗi truy vấn
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Trả về dữ liệu dưới dạng mảng kết hợp
    $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Kết nối database thất bại: " . $e->getMessage());
}