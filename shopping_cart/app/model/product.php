<?php

require_once __DIR__ . "/../common/dbConnect.php";

// 1. Lấy danh sách sản phẩm
function getAllProducts()
{
    global $conn;

    $sql = "SELECT * FROM products ORDER BY id DESC";

    $stmt = $conn->prepare($sql);
    $stmt->execute();

    return $stmt->fetchAll();
}


// 2. Lấy sản phẩm theo ID
function getProductById($id)
{
    global $conn;

    $sql = "SELECT * FROM products WHERE id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->execute([$id]);

    return $stmt->fetch();
}


// 3. Thêm sản phẩm
function addProduct($name, $price, $quantity)
{
    global $conn;

    $sql = "INSERT INTO products (name, price, quantity)
            VALUES (?, ?, ?)";

    $stmt = $conn->prepare($sql);

    return $stmt->execute([$name, $price, $quantity]);
}


// 4. Cập nhật sản phẩm
function updateProduct($id, $name, $price, $quantity)
{
    global $conn;

    $sql = "UPDATE products
            SET name = ?, price = ?, quantity = ?
            WHERE id = ?";

    $stmt = $conn->prepare($sql);

    return $stmt->execute([$name, $price, $quantity, $id]);
}


// 5. Xóa sản phẩm
function deleteProduct($id)
{
    global $conn;

    $sql = "DELETE FROM products WHERE id = ?";

    $stmt = $conn->prepare($sql);

    return $stmt->execute([$id]);
}