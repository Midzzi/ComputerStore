<?php 
// Giả định $conn đã được include từ db_connect.php
if (file_exists('config/db_connect.php')) { include_once 'config/db_connect.php'; }

// THÊM LOGIC LẤY 1 BANNER TỪ DATABASE
$banner_data = null;
if (isset($conn) && !$conn->connect_error) {
    // Lấy banner có display_order thấp nhất hoặc ID nhỏ nhất
    $banner_result = $conn->query("SELECT image_path, link, title FROM banners WHERE is_active = TRUE ORDER BY display_order ASC, id ASC LIMIT 1");
    if ($banner_result && $banner_result->num_rows > 0) {
        $banner_data = $banner_result->fetch_assoc();
    }
}

// Xác định đường dẫn ảnh để hiển thị (Sử dụng placeholder nếu không có)
$main_image_path = 'https://placehold.co/900x300/CCCCCC/333333?text=Chưa+có+Banner'; 
$banner_link = '#';
$banner_title = 'Banner Quảng Cáo Tĩnh';

if ($banner_data) {
    $temp_path = htmlspecialchars($banner_data['image_path']);
    $banner_link = htmlspecialchars($banner_data['link']);
    $banner_title = htmlspecialchars($banner_data['title']);
    
    // Kiểm tra tệp vật lý. Nếu không tồn tại, dùng placeholder.
    if (file_exists($temp_path) && !is_dir($temp_path)) {
        $main_image_path = $temp_path;
    } else {
        $main_image_path = 'https://placehold.co/900x300/FF5733/FFFFFF?text=Lỗi+Ảnh+Banner';
    }
}

// CSS cho Banner Tĩnh
$banner_css = "
    .ad-banner {
        height: 300px; 
        background-color: #ecf0f1; 
        border-radius: 8px;
        overflow: hidden; 
        display: flex; 
        align-items: center; 
        justify-content: center;
    }
    .ad-banner img {
        width: 100%;
        height: 100%;
        object-fit: contain; /* Đảm bảo hình ảnh thu nhỏ vừa vặn */
    }
    .sidebar-nav { height: 300px; }
";
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Computer Store - Trang Bán Hàng</title>
    
    <style>
        /* =============================================== */
        /* CSS CHUNG VÀ CẤU HÌNH STICKY */
        /* =============================================== */
        :root {
            --primary-color: #5D9CEC; 
            --secondary-color: #2ecc71; 
            --price-color: #e74c3c; 
            --text-color: #34495e;
            --background-color: #f7f9fc;
            --border-color: #bdc3c7;
        }

        body {
            font-family: 'Arial', sans-serif;
            background-color: var(--background-color);
            margin: 0;
            padding: 0;
            color: var(--text-color);
        }
        
        .container {
            max-width: 1200px;
            padding: 0; 
            margin: 0 auto;
        }

        /* HEADER (Trải dài hết trang) */
        header {
            width: 100%;
            background-color: white; 
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); 
            margin-bottom: 20px;
        }

        /* Thanh Sticky (Ẩn ban đầu) */
        #sticky-search-bar {
            position: fixed; /* Cố định vị trí */
            top: 0;
            left: 0;
            width: 100%;
            background-color: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
            z-index: 1000; /* Đảm bảo nó nằm trên tất cả các nội dung khác */
            padding: 10px 0;
            /* Cần thiết để ẩn/hiện bằng JS */
            transform: translateY(-100%); 
            transition: transform 0.3s ease-in-out;
        }
        
        #sticky-search-bar.visible {
            transform: translateY(0);
        }
        
        /* Product Grid (Các style khác giữ nguyên) */
        .product-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 20px; margin-top: 20px; }
        .product-card { background-color: white; border: 1px solid #ddd; border-radius: 8px; padding: 15px; text-align: center; text-decoration: none; color: var(--text-color); transition: box-shadow 0.2s; }
        .product-card:hover { box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); }
        .product-image { height: 150px; display: flex; align-items: center; justify-content: center; overflow: hidden; margin-bottom: 10px; }
        .product-image img { max-width: 100%; max-height: 100%; object-fit: contain; }
        .product-info h4 { font-size: 16px; margin: 5px 0; }
        .price { font-weight: bold; color: var(--price-color); font-size: 18px; }
        .action-row { display: flex; justify-content: space-between; align-items: center; margin-top: 10px; }
        .stock-status { font-size: 12px; color: var(--secondary-color); }
        
        /* =============================================== */
        /* CSS CHO THANH HEADER */
        /* =============================================== */
        .logo-img { max-height: 80px; width: auto; display: block; }
        .logo { text-decoration: none; padding: 0; border: none; line-height: 0; }
        .cart-icon { display: flex; align-items: center; padding: 10px 15px; background-color: var(--primary-color); color: white; border-radius: 5px; text-decoration: none; font-weight: bold; white-space: nowrap; }
        .cart-icon:hover { background-color: #4A89DC; }
        .cart-icon svg { width: 24px; height: 24px; vertical-align: middle; margin-right: 5px; fill: none; }
        .search-form { display: flex; flex-grow: 1; border: 1px solid var(--border-color); border-radius: 5px; overflow: hidden; max-width: 600px; }
        .search-form input[type="text"] { flex-grow: 1; padding: 10px 15px; border: none; outline: none; font-size: 16px; }
        .search-button { background-color: var(--primary-color); border: none; padding: 10px 15px; cursor: pointer; transition: background-color 0.2s; }
        .search-button:hover { background-color: #4A89DC; }
        .search-button svg { stroke: white; width: 20px; height: 20px; }
        .header-top { display: flex; justify-content: space-between; align-items: center; padding: 15px 30px; gap: 20px; }
        
        /* Banner Tĩnh */
        <?php echo $banner_css; ?>
    </style>
</head>
<body>
    
    <!-- KHỐI STICKY HEADER (Ban đầu ẩn, chỉ chứa tìm kiếm và giỏ hàng) -->
    <div id="sticky-search-bar">
        <div class="container header-top" style="padding: 10px 30px;">
            <!-- Logo (Giữ lại logo hoặc chỉ dùng tìm kiếm) -->
            <a href="index.php" class="logo">
                <img src="images/brands/2.jpg" alt="Logo Công ty" class="logo-img" style="max-height: 40px;">
            </a>
            
            <!-- Thanh tìm kiếm (Lớn) -->
            <form action="products.php" method="GET" class="search-form">
                <input type="text" name="search_query" placeholder="tìm kiếm...">
                <button type="submit" class="search-button">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="white" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="11" cy="11" r="8"></circle>
                        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                    </svg>
                </button>
            </form>
            
            <!-- NÚT GIỎ HÀNG -->
            <a href="cart.php" class="cart-icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="white" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="9" cy="21" r="1"></circle>
                    <circle cx="20" cy="21" r="1"></circle>
                    <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                </svg>
                Giỏ hàng
            </a>
        </div>
    </div>
    
    <!-- KHỐI HEADER GỐC -->
    <header id="original-header">
        <div class="container header-top">
            <!-- Logo (images/brands/2.jpg) -->
            <a href="index.php" class="logo">
                <img src="images/brands/2.jpg" alt="Logo Công ty" class="logo-img">
            </a>
            
            <!-- Thanh tìm kiếm -->
            <form action="products.php" method="GET" class="search-form">
                <input type="text" name="search_query" placeholder="tìm kiếm...">
                <button type="submit" class="search-button">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="white" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="11" cy="11" r="8"></circle>
                        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                    </svg>
                </button>
            </form>
            
            <!-- NÚT GIỎ HÀNG -->
            <a href="cart.php" class="cart-icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="white" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="9" cy="21" r="1"></circle>
                    <circle cx="20" cy="21" r="1"></circle>
                    <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                </svg>
                Giỏ hàng
            </a>
        </div>
        
        <!-- Phần này chỉ dành cho trang chủ: Sidebar và Banner Tĩnh -->
        <?php if (basename($_SERVER['PHP_SELF']) == 'index.php'): ?>
        <div class="container" style="display: flex; margin-top: 15px;">
            <!-- SIDEBAR NAV -->
            <nav class="sidebar-nav" style="width: 200px; background-color: white; padding: 10px; border-radius: 5px; border: 1px solid var(--border-color);">
                <?php
                if (isset($conn) && !$conn->connect_error) {
                    $result = $conn->query("SELECT id, name FROM categories");
                    if ($result && $result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "<a href='products.php?cat_id=" . $row['id'] . "' style='display: block; padding: 8px 0; border-bottom: 1px dashed #eee; text-decoration: none;'>" . htmlspecialchars($row['name']) . "</a>";
                        }
                    }
                } else {
                    echo "<p style='color: red;'>Lỗi: Không kết nối được DB.</p>";
                }
                ?>
            </nav>
            <!-- KHU VỰC QUẢNG CÁO TĨNH -->
            <div class="main-content" style="flex-grow: 1; padding-left: 20px; overflow: hidden;">
                <!-- CHỈ HIỂN THỊ BANNER TĨNH -->
                <div class="ad-banner">
                    <a href="<?php echo $banner_link; ?>" style="display: block; width: 100%; height: 100%;">
                        <img src="<?php echo $main_image_path; ?>" alt="<?php echo $banner_title; ?>">
                    </a>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </header>
    <main class="container">

<script>
    // MÃ JAVASCRIPT CHO HIỆU ỨNG STICKY HEADER
    document.addEventListener('DOMContentLoaded', function() {
        const stickyHeader = document.getElementById('sticky-search-bar');
        const originalHeader = document.getElementById('original-header');
        
        // Lấy chiều cao của header gốc để biết khi nào cần kích hoạt sticky
        const headerHeight = originalHeader.offsetHeight;

        window.addEventListener('scroll', function() {
            // Kiểm tra nếu cuộn xuống nhiều hơn chiều cao của header gốc
            if (window.scrollY > headerHeight) {
                stickyHeader.classList.add('visible');
            } else {
                stickyHeader.classList.remove('visible');
            }
        });
    });
</script>