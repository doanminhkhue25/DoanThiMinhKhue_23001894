-- =====================================================
-- BÀI 1 – QUẢN LÝ GIỎ HÀNG (MySQL)
-- =====================================================

-- 0. CREATE: tạo database và bảng cart_items
CREATE DATABASE IF NOT EXISTS shopping_cart
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE shopping_cart;

DROP TABLE IF EXISTS cart_items;

CREATE TABLE cart_items (
    id       INT PRIMARY KEY AUTO_INCREMENT,
    name     VARCHAR(100) NOT NULL,
    price    DECIMAL(10,2) NOT NULL,
    quantity INT NOT NULL
);

-- 1. INSERT: thêm 6 sản phẩm
INSERT INTO cart_items (name, price, quantity) VALUES
    ('Laptop Dell',        15000000, 1),
    ('Chuột không dây',      250000, 2),
    ('Bàn phím cơ',         1200000, 1),
    ('Tai nghe Bluetooth',   800000, 3),
    ('Cáp sạc USB-C',         90000, 10),
    ('Sổ tay A5',             35000, 8);

-- 2. Hiển thị toàn bộ sản phẩm
SELECT * FROM cart_items;

-- 3. Hiển thị sản phẩm có giá lớn hơn 100000
SELECT * FROM cart_items
WHERE price > 100000;

-- 4. Hiển thị sản phẩm có số lượng lớn hơn 5
SELECT * FROM cart_items
WHERE quantity > 5;

-- 5. Sắp xếp sản phẩm theo giá giảm dần
SELECT * FROM cart_items
ORDER BY price DESC;

-- 6. Cập nhật giá của một sản phẩm (Chuột không dây: 250000 -> 270000)
UPDATE cart_items
SET price = 270000
WHERE name = 'Chuột không dây';

-- 7. Cập nhật số lượng của một sản phẩm (Tai nghe Bluetooth: 3 -> 6)
UPDATE cart_items
SET quantity = 6
WHERE name = 'Tai nghe Bluetooth';

-- 8. Xóa một sản phẩm (Sổ tay A5)
DELETE FROM cart_items
WHERE name = 'Sổ tay A5';

-- 9. Hiển thị tên, giá, số lượng và thành tiền (price × quantity)
SELECT name,
       price,
       quantity,
       price * quantity AS total
FROM cart_items;

-- 10. Tính tổng tiền của toàn bộ giỏ hàng
SELECT SUM(price * quantity) AS cart_total
FROM cart_items;