<?php

$servername = "localhost";
$username = "root";
$password = "";
$database = "shopping_cart";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Kết nối database thất bại: " . $conn->connect_error);
}

$conn->set_charset("utf8mb4");