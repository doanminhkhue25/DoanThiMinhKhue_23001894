-- =====================================================
-- BÀI 2 – QUẢN LÝ VÉ XEM PHIM (MySQL)
-- =====================================================

-- 0. CREATE: tạo database và bảng movies
CREATE DATABASE IF NOT EXISTS movie_tickets
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE movie_tickets;

DROP TABLE IF EXISTS movies;

CREATE TABLE movies (
    id              INT PRIMARY KEY AUTO_INCREMENT,
    title           VARCHAR(100) NOT NULL,
    price           DECIMAL(10,2) NOT NULL,
    total_seats     INT NOT NULL,
    available_seats INT NOT NULL
);

-- 1. INSERT: thêm 6 bộ phim (title, price, total_seats, available_seats)
INSERT INTO movies (title, price, total_seats, available_seats) VALUES
    ('Avengers',   100000, 100, 40),
    ('Avatar',     120000,  80, 30),
    ('Batman',      90000, 120, 100),
    ('Spider-Man', 110000,  90, 70),
    ('Frozen',      80000,  60, 55),
    ('Titanic',    130000, 150, 120);

-- 2. Hiển thị toàn bộ danh sách phim
SELECT * FROM movies;

-- 3. Hiển thị phim có giá vé lớn hơn 100000
SELECT * FROM movies
WHERE price > 100000;

-- 4. Hiển thị phim còn nhiều hơn 50 ghế
SELECT * FROM movies
WHERE available_seats > 50;

-- 5. Sắp xếp phim theo giá vé giảm dần
SELECT * FROM movies
ORDER BY price DESC;

-- 6. Cập nhật số ghế còn lại của một phim (Batman: 100 -> 90)
UPDATE movies
SET available_seats = 90
WHERE title = 'Batman';

-- 7. Xóa một phim (Frozen)
DELETE FROM movies
WHERE title = 'Frozen';

-- 8. Hiển thị số vé đã bán của từng phim
SELECT id,
       title,
       total_seats - available_seats AS sold_seats
FROM movies;

-- 9. Tính doanh thu của từng phim
SELECT id,
       title,
       (total_seats - available_seats) * price AS revenue
FROM movies;

-- 10. Tính tổng doanh thu của tất cả các phim
SELECT SUM((total_seats - available_seats) * price) AS total_revenue
FROM movies;

-- 11. Tìm phim có số vé bán ra nhiều nhất (dùng MAX)
SELECT id,
       title,
       total_seats - available_seats AS sold_seats
FROM movies
WHERE (total_seats - available_seats) = (
    SELECT MAX(total_seats - available_seats)
    FROM movies
);