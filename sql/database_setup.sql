-- Tạo Database
CREATE DATABASE IF NOT EXISTS computer_store_db;
USE computer_store_db;

-- Bảng Danh mục sản phẩm
CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL UNIQUE
);

-- Bảng Sản phẩm
CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category_id INT NOT NULL,
    name VARCHAR(255) NOT NULL,
    price DECIMAL(10, 0) NOT NULL,
    stock INT NOT NULL DEFAULT 0,
    description TEXT,
    image_path VARCHAR(255),
    FOREIGN KEY (category_id) REFERENCES categories(id)
);

-- Dữ liệu mẫu
INSERT INTO categories (name) VALUES 
('PC'), ('Laptop'), ('Linh kiện PC'), ('Phụ kiện Laptop'), ('Gear');

INSERT INTO products (category_id, name, price, stock, image_path) VALUES
(2, 'Laptop Gaming ASUS ROG', 29990000, 15, 'product/laptop/asus_rog.jpg'),
(1, 'PC Văn Phòng Core i5', 12500000, 20, 'product/pc/pc_office.jpg'),
(2, 'Macbook Pro M1', 40199000, 10, 'product/laptop/macbook_pro.jpg');