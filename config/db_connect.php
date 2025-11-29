<?php
// Cài đặt thông tin kết nối Database XAMPP
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', ''); // Mật khẩu mặc định của XAMPP thường là rỗng
define('DB_NAME', 'computer_store_db');

// Kết nối đến MySQL
$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Lỗi kết nối database: " . $conn->connect_error);
}

// Thiết lập mã hóa UTF-8
$conn->set_charset("utf8");
?>