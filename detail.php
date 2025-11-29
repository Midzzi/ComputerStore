<?php include 'includes/header.php'; ?>
<?php
$product_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$product = null;

if ($product_id > 0) {
    // Truy vấn sản phẩm
    $product_result = $conn->query("SELECT p.*, c.name as category_name FROM products p JOIN categories c ON p.category_id = c.id WHERE p.id = $product_id LIMIT 1");
    if ($product_result->num_rows > 0) {
        $product = $product_result->fetch_assoc();
    }
}

if (!$product) {
    echo "<h1 style='color: red;'>Sản phẩm không tồn tại!</h1>";
    include 'includes/footer.php';
    exit;
}

// === LOGIC XỬ LÝ ẢNH SẢN PHẨM ===
$db_image_path = $product['image_path'] ?? 'placeholder.png'; 
$full_image_path = 'images/' . $db_image_path; 
$image_source = '';

// Kiểm tra sự tồn tại của file ảnh vật lý
if (file_exists($full_image_path) && !is_dir($full_image_path)) {
    $image_source = $full_image_path; 
} else {
    // Dùng placeholder URL nếu ảnh không tồn tại
    $image_source = 'https://placehold.co/400x400/e0e0e0/333333?text=Ảnh+SP+Lỗi';
}

// === LOGIC XỬ LÝ SẢN PHẨM TƯƠNG TỰ (MOCKUP) ===
// Lấy 4 sản phẩm tương tự (cùng category, khác ID)
$related_products_result = $conn->query("SELECT * FROM products WHERE category_id = {$product['category_id']} AND id != {$product['id']} ORDER BY RAND() LIMIT 4");
?>
<style>
/* CSS cho Trang Chi tiết */
.detail-layout { display: flex; gap: 30px; margin-top: 20px; }
.detail-image-box { 
    flex-basis: 40%; 
    max-width: 40%; 
    height: 400px; 
    background-color: white; 
    border: 1px solid var(--border-color); 
    border-radius: 8px; 
    display: flex; 
    align-items: center; 
    justify-content: center; 
    overflow: hidden; /* Quan trọng để giữ ảnh trong khung */
}
.detail-image-box img {
    max-width: 100%;
    max-height: 100%;
    object-fit: contain;
}
.detail-info { flex-basis: 60%; }
.detail-info h1 { font-size: 32px; margin-bottom: 10px; }
.info-box { border: 1px solid var(--border-color); padding: 15px; border-radius: 5px; margin-bottom: 10px; }
.quantity-control { display: flex; align-items: center; gap: 10px; }
.qty-button { width: 30px; height: 30px; border: 1px solid var(--border-color); background-color: white; cursor: pointer; }
.buy-actions button { padding: 10px 20px; margin-top: 10px; border: none; border-radius: 5px; cursor: pointer; font-size: 16px; }
.add-to-cart { background-color: var(--secondary-color); color: white; }
.buy-now { background-color: var(--price-color); color: white; margin-left: 10px; }
.tech-spec { margin-top: 40px; padding: 30px; background-color: white; border: 1px solid var(--border-color); border-radius: 8px; }
</style>

<div class="breadcrumb">Trang chủ > <?php echo htmlspecialchars($product['category_name']); ?> > <?php echo htmlspecialchars($product['name']); ?></div>

<div class="detail-layout">
    <!-- SỬA ĐỔI TẠI ĐÂY: Thay thế div placeholder bằng thẻ img -->
    <div class="detail-image-box">
        <img src="<?php echo $image_source; ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
    </div>
    <div class="detail-info">
        <h1><?php echo htmlspecialchars($product['name']); ?></h1>
        <p>Mã sản phẩm : abc<?php echo $product['id']; ?></p>
        <div class="info-box">Thông số sơ bộ sản phẩm</div>
        <div class="info-box">Giá sản phẩm: <span class="price"><?php echo number_format($product['price'], 0, ',', '.'); ?> đ</span></div>
        
        <div class="quantity-control">
            <span>Số lượng:</span>
            <button class="qty-button" onclick="updateQuantity(<?php echo $product_id; ?>, -1)">-</button>
            <input type="text" id="qty-<?php echo $product['id']; ?>" value="1" style="width: 40px; text-align: center; border: 1px solid var(--border-color);" readonly>
            <button class="qty-button" onclick="updateQuantity(<?php echo $product_id; ?>, 1)">+</button>
        </div>
        
        <div class="buy-actions">
            <button class="add-to-cart">Thêm vào giỏ hàng</button>
            <button class="buy-now">Mua ngay</button>
        </div>
    </div>
</div>

<div class="tech-spec">Thông số kĩ thuật (Chi tiết về <?php echo htmlspecialchars($product['description']); ?>)</div>

<h3 style="margin-top: 30px;">Sản phẩm tương tự:</h3>
<div class="product-grid">
    <?php 
    if ($related_products_result && $related_products_result->num_rows > 0) {
        while($related_product = $related_products_result->fetch_assoc()) {
            $related_stock_status = $related_product['stock'] > 0 ? '(v) còn hàng' : '(x) đặt hàng';
            
            // LOGIC ẢNH SẢN PHẨM TƯƠNG TỰ
            $related_image_path = 'images/' . ($related_product['image_path'] ?? 'placeholder.png'); 
            $related_image_source = file_exists($related_image_path) ? $related_image_path : 'https://placehold.co/220x150/e0e0e0/333333?text=Ảnh SP Lỗi';
    ?>
    <a href="detail.php?id=<?php echo $related_product['id']; ?>" class="product-card">
        <div class="product-image" style="height: 150px; display: flex; align-items: center; justify-content: center; overflow: hidden; background-color: white;">
             <img src="<?php echo $related_image_source; ?>" alt="<?php echo htmlspecialchars($related_product['name']); ?>" style="max-width: 100%; max-height: 100%; object-fit: contain;">
        </div>
        <div class="product-info">
            <h4><?php echo htmlspecialchars($related_product['name']); ?></h4>
            <div class="price"><?php echo number_format($related_product['price'], 0, ',', '.'); ?> đ</div>
            <div class="action-row">
                <span class="stock-status"><?php echo $related_stock_status; ?></span>
                <span class="buy-icon">icon</span>
            </div>
        </div>
    </a>
    <?php
        }
    } else {
        echo "<p>Không tìm thấy sản phẩm tương tự.</p>";
    }
    ?>
</div>

<?php include 'includes/footer.php'; ?>