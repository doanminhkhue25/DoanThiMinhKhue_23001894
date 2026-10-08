CREATE DATABASE IF NOT EXISTS shopping_cart
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE shopping_cart;

DROP TABLE IF EXISTS products;

CREATE TABLE products (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    quantity INT NOT NULL
);

INSERT INTO products (name, price, quantity) VALUES
    ('Laptop', 15000000, 10),
    ('Chuột máy tính', 250000, 20),
    ('Bàn phím', 500000, 15),
    ('Tai nghe', 750000, 8),
    ('Màn hình', 5000000, 5);



