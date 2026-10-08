<?php

require_once __DIR__ . "/../common/dbConnect.php";

function getAllProducts()
{
    global $conn;

    $sql = "SELECT * FROM products ORDER BY id DESC";

    $result = $conn->query($sql);

    $products = [];

    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }

    return $products;
}

function getProductById($id)
{
    global $conn;

    $sql = "SELECT * FROM products WHERE id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    $stmt->execute();

    $result = $stmt->get_result();

    return $result->fetch_assoc();
}

function addProduct($name, $price, $quantity)
{
    global $conn;

    $sql = "INSERT INTO products (name, price, quantity)
            VALUES (?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sdi", $name, $price, $quantity);

    return $stmt->execute();
}

function updateProduct($id, $name, $price, $quantity)
{
    global $conn;

    $sql = "UPDATE products
            SET name = ?, price = ?, quantity = ?
            WHERE id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sdii", $name, $price, $quantity, $id);

    return $stmt->execute();
}

function deleteProduct($id)
{
    global $conn;

    $sql = "DELETE FROM products WHERE id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    return $stmt->execute();
}