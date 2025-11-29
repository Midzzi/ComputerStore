<?php include 'includes/header.php'; ?>
<style>
/* CSS cho Trang Chủ */
.category-section {
    margin-top: 30px;
    padding-top: 10px;
    border-top: 1px solid var(--border-color);
}
.section-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 15px;
}
.section-header h2 {
    font-size: 20px;
    color: var(--text-color);
}
.view-all {
    font-size: 14px;
    color: var(--primary-color);
    text-decoration: none;
}
</style>

<?php
// Sử dụng $conn từ header.php
$categories_result = $conn->query("SELECT id, name FROM categories");

if ($categories_result && $categories_result->num_rows > 0) {
    while($category = $categories_result->fetch_assoc()) {
        $cat_id = $category['id'];
        $cat_name = htmlspecialchars($category['name']);
        
        // Lấy 4 sản phẩm mới nhất của mỗi danh mục
        // Sử dụng ORDER BY id DESC để lấy sản phẩm mới nhất
        $products_result = $conn->query("SELECT * FROM products WHERE category_id = $cat_id ORDER BY id DESC LIMIT 4");
?>

<section class="category-section">
    <div class="section-header">
        <h2><?php echo $cat_name; ?></h2>
        <a href="products.php?cat_id=<?php echo $cat_id; ?>" class="view-all">xem tất cả -></a>
    </div>
    
    <div class="product-grid">
        <?php 
        if ($products_result && $products_result->num_rows > 0) {
            while($product = $products_result->fetch_assoc()) {
                $stock_status = $product['stock'] > 0 ? '('.$product['stock'].') còn hàng' : '(x) đang đặt hàng';
                
                // === LOGIC XỬ LÝ ẢNH ===
                $db_image_path = $product['image_path'] ?? 'placeholder.png'; 
                $full_image_path = 'images/' . $db_image_path; 

                $image_source = '';
                
                // Kiểm tra sự tồn tại của file ảnh vật lý
                // Điều này cực kỳ quan trọng để debug lỗi 404/sai đường dẫn
                if (file_exists($full_image_path) && !is_dir($full_image_path)) {
                    $image_source = $full_image_path; 
                } else {
                    // Dùng placeholder URL nếu ảnh không tồn tại
                    // Nếu bạn thấy 'Ảnh SP Lỗi', hãy kiểm tra lại database và folder images
                    $image_source = 'https://placehold.co/220x150/e0e0e0/333333?text=Ảnh SP Lỗi';
                }
        ?>
        <a href="detail.php?id=<?php echo $product['id']; ?>" class="product-card">
            <!-- Thay thế placeholder DIV bằng thẻ IMG thực tế -->
            <div class="product-image" style="height: 150px; display: flex; align-items: center; justify-content: center; overflow: hidden; background-color: white;">
                 <img src="<?php echo $image_source; ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" style="max-width: 100%; max-height: 100%; object-fit: contain;">
            </div>
            <div class="product-info">
                <h4><?php echo htmlspecialchars($product['name']); ?></h4>
                <div class="price"><?php echo number_format($product['price'], 0, ',', '.'); ?> đ</div>
                <div class="action-row">
                    <span class="stock-status"><?php echo $stock_status; ?></span>
                </div>
            </div>
        </a>
        <?php
            }
        } else {
            echo "<p>Chưa có sản phẩm nào trong danh mục này.</p>";
        }
        ?>
    </div>
</section>

<?php
    }
} else {
    // Trường hợp không có danh mục nào được tải (lỗi kết nối DB)
    echo "<p style='color: red; text-align: center;'>Lỗi: Không tải được danh mục sản phẩm từ Database.</p>";
}
?>

<?php include 'includes/footer.php'; ?>