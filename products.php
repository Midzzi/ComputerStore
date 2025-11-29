<?php include 'includes/header.php'; ?>
<?php
// === CẤU HÌNH PHÂN TRANG ===
$products_per_page = 20; // 5 hàng sản phẩm * 4 cột = 20 sản phẩm/trang
$current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($current_page < 1) $current_page = 1;

$offset = ($current_page - 1) * $products_per_page;


// Lấy Category ID từ URL
$cat_id = isset($_GET['cat_id']) ? (int)$_GET['cat_id'] : 0;
$category_name = "Tất cả sản phẩm";
$products_sql_display = "SELECT SQL_CALC_FOUND_ROWS * FROM products";
$where_clauses = [];
$order_clause = "";

// 1. LẤY THAM SỐ LỌC VÀ SẮP XẾP MỚI (FIX LỖI Undefined Variable)
// --- Đảm bảo các biến được định nghĩa ngay từ đầu ---
$price_min_filter = isset($_GET['price_min']) ? (int)$_GET['price_min'] : 0;
$price_max_filter = isset($_GET['price_max']) ? (int)$_GET['price_max'] : 100; // FIX LỖI WARNING Ở ĐÂY
$filter_stock = isset($_GET['stock']) ? $_GET['stock'] : null;
$sort_by = isset($_GET['sort']) ? $_GET['sort'] : null;
$search_query = isset($_GET['search_query']) ? $conn->real_escape_string($_GET['search_query']) : null;
$brand_filter = isset($_GET['brand']) ? $conn->real_escape_string($_GET['brand']) : null;


// === ĐỊNH NGHĨA CÁC HÀM TIỆN ÍCH (FIX LỖI FATAL/SCOPE) ===
/**
 * Hàm lấy chuỗi tham số URL hiện tại (dùng cho các nút lọc và phân trang).
 * CHÚ Ý: Hàm này được định nghĩa ở đây để đảm bảo nó tồn tại trong scope trước khi được gọi.
 */
$get_current_params = function($exclude = []) use ($cat_id, $search_query, $brand_filter, $filter_stock, $sort_by, $price_min_filter, $price_max_filter) {
    $params = [];
    if ($cat_id > 0 && !in_array('cat_id', $exclude)) $params[] = 'cat_id=' . $cat_id;
    if (!empty($search_query) && !in_array('search_query', $exclude)) $params[] = 'search_query=' . urlencode($search_query);
    if (!empty($brand_filter) && !in_array('brand', $exclude)) $params[] = 'brand=' . urlencode($brand_filter);
    if (!empty($filter_stock) && !in_array('stock', $exclude)) $params[] = 'stock=' . $filter_stock;
    if (!empty($sort_by) && !in_array('sort', $exclude)) $params[] = 'sort=' . $sort_by;
    if ($price_min_filter > 0 && !in_array('price_min', $exclude)) $params[] = 'price_min=' . $price_min_filter;
    if ($price_max_filter < 100 && !in_array('price_max', $exclude)) $params[] = 'price_max=' . $price_max_filter;
    return implode('&', $params) . (empty($params) ? '' : '&');
};


// === LOGIC XỬ LÝ TRUY VẤN SQL ===

// XỬ LÝ LỌC THEO CATEGORY
if ($cat_id > 0) {
    // Lấy tên Category để hiển thị trên Breadcrumb
    $cat_result = $conn->query("SELECT name FROM categories WHERE id = $cat_id");
    if ($cat_result && $cat_result->num_rows > 0) {
        $category_name = htmlspecialchars($cat_result->fetch_assoc()['name']);
    }
    $where_clauses[] = "category_id = $cat_id";
}

// XỬ LÝ TÌM KIẾM TỪ THANH HEADER
if (!empty($search_query)) {
    $where_clauses[] = "name LIKE '%$search_query%' OR description LIKE '%$search_query%'";
    $category_name = "Kết quả tìm kiếm cho: " . htmlspecialchars($search_query);
}

// XỬ LÝ LỌC THEO BRAND (Lọc theo tên sản phẩm)
if (!empty($brand_filter)) {
    $where_clauses[] = "name LIKE '%" . $brand_filter . "%'";
}

// XỬ LỌC THEO SẴN HÀNG
if ($filter_stock === 'available') {
    $where_clauses[] = "stock > 0";
}

// 2. XỬ LÝ LỌC THEO KHOẢNG GIÁ MỚI (Từ Thanh trượt)
// Giá trị trong DB là VND (đơn vị 1), nên nhân với 1,000,000
$min_price_db = $price_min_filter * 1000000;
$max_price_db = $price_max_filter * 1000000;

if ($price_min_filter > 0 || $price_max_filter < 100) {
    $where_clauses[] = "price >= $min_price_db AND price <= $max_price_db";
}


// 3. XỬ LÝ SẮP XẾP (SORT)
if ($sort_by === 'price_asc') {
    $order_clause = "ORDER BY price ASC";
} elseif ($sort_by === 'price_desc') {
    $order_clause = "ORDER BY price DESC";
}

// TỔNG HỢP CÂU TRUY VẤN
$where_sql = !empty($where_clauses) ? " WHERE " . implode(" AND ", $where_clauses) : "";

$products_sql_display .= $where_sql;
$products_sql_display .= " " . $order_clause;

// Thêm OFFSET và LIMIT cho phân trang
$products_sql_display .= " LIMIT $products_per_page OFFSET $offset";

// Chạy truy vấn (LẤY DỮ LIỆU HIỂN THỊ TRÊN TRANG HIỆN TẠI)
$products_result = $conn->query($products_sql_display);

// LẤY TỔNG SỐ SẢN PHẨM (Dùng FOUND_ROWS())
$total_products_result = $conn->query("SELECT FOUND_ROWS() as total");
$total_products = $total_products_result->fetch_assoc()['total'];
$total_pages = ceil($total_products / $products_per_page);
?>
<style>
/* CSS cho trang danh sách */
.breadcrumb { font-size: 14px; margin-top: 10px; margin-bottom: 20px; }
/* Thiết lập breadcrumb thành các liên kết */
.breadcrumb a { text-decoration: none; color: var(--text-color); margin-right: 5px; }
.breadcrumb span { color: var(--primary-color); font-weight: bold; }

/* FIX: Thêm lớp cho bố cục chính */
.product-page-layout {
    display: flex;
    gap: 30px; /* Khoảng cách giữa bộ lọc và lưới sản phẩm */
    margin-top: 20px;
}
.filter-sidebar {
    width: 300px; /* Giới hạn chiều rộng của bộ lọc */
    flex-shrink: 0;
}
.product-list-content {
    flex-grow: 1;
}

.filter-options { display: flex; flex-wrap: wrap; gap: 10px; margin-bottom: 20px; }
/* Thay đổi style cho link lọc */
.filter-options a { 
    padding: 10px 15px; 
    border: 1px solid var(--border-color); 
    background-color: white; 
    border-radius: 5px; 
    cursor: pointer; 
    text-decoration: none;
    color: var(--text-color);
    transition: background-color 0.2s;
    font-size: 14px;
    white-space: nowrap; /* Ngăn nút bị xuống dòng */
}
.filter-options a:hover, .filter-options .active-filter {
    background-color: var(--primary-color);
    color: white;
    border-color: var(--primary-color);
}
.price-range-control {
    background-color: white;
    border: 1px solid var(--border-color);
    padding: 15px;
    border-radius: 5px;
    width: 100%; /* FIX: Sử dụng 100% của filter-sidebar */
    margin-bottom: 20px; 
}

/* FIX LỖI DÍNH SÁT VÀ KÉO DÀI */
.product-grid {
    display: grid;
    /* Sử dụng grid-template-columns để xác định số cột dựa trên chiều rộng cố định */
    grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); 
    
    /* FIX: Dùng column-gap và row-gap để tạo khoảng cách */
    column-gap: 20px; 
    row-gap: 20px; 
    margin-top: 20px;
    
    /* Center các sản phẩm còn lại */
    justify-content: start; /* Sửa lại thành start để căn trái */
}

/* Đảm bảo product-card không chiếm hết chiều rộng (Grid sẽ lo việc này) */
.product-card {
    display: block; 
    text-decoration: none;
    width: 100%; 
}


/* FIX: Đảm bảo Pagination và Footer không bị dính sát */
.pagination { 
    text-align: center; 
    margin-top: 50px; 
    margin-bottom: 50px; 
}
.pagination a, .pagination span { display: inline-block; padding: 8px 12px; margin: 0 5px; border: 1px solid var(--border-color); text-decoration: none; border-radius: 5px; background-color: white; }
.pagination .active-page {
    background-color: var(--primary-color); 
    color: white;
}
</style>

<div class="breadcrumb">
    <a href="index.php">Trang chủ</a> 
    > 
    <a href="products.php">Tất cả sản phẩm</a>
    <?php 
    // Nếu có lọc theo Category, thêm tên Category vào breadcrumb
    if ($cat_id > 0) {
        echo " > <span>" . $category_name . "</span>";
    } elseif (!empty($search_query)) {
        echo " > <span>" . $category_name . "</span>";
    }
    ?>
</div>

<!-- Nút RESET ALL FILTERS (Xem tất cả sản phẩm) -->
<div style="margin-bottom: 10px;">
    <a href="products.php" style="padding: 5px 10px; background-color: #f0f0f0; border: 1px solid #ccc; border-radius: 5px; text-decoration: none; font-size: 14px;">Xóa tất cả bộ lọc (Xem <?php echo $total_products; ?> sản phẩm)</a>
</div>

<!-- BỐ CỤC CHÍNH (SIDEBAR VÀ LIST) -->
<div class="product-page-layout">
    
    <div class="filter-sidebar">
        <!-- Thanh Lọc theo Brand -->
        <div class="filter-options">
            <?php 
            // Dữ liệu Brands MOCK
            $brands = ['Apple', 'Asus', 'Dell', 'Lenovo', 'Msi'];
            
            // Hàm tiện ích để tạo các tham số URL hiện có
            $create_url_params = function($exclude = []) use ($cat_id, $search_query, $filter_stock, $sort_by, $price_min_filter, $price_max_filter) {
                $params = [];
                if ($cat_id > 0 && !in_array('cat_id', $exclude)) $params[] = 'cat_id=' . $cat_id;
                if (!empty($search_query) && !in_array('search_query', $exclude)) $params[] = 'search_query=' . urlencode($search_query);
                if (!empty($filter_stock) && !in_array('stock', $exclude)) $params[] = 'stock=' . $filter_stock;
                if (!empty($sort_by) && !in_array('sort', $exclude)) $params[] = 'sort=' . $sort_by;
                if ($price_min_filter > 0 && !in_array('price_min', $exclude)) $params[] = 'price_min=' . $price_min_filter;
                if ($price_max_filter < 100 && !in_array('price_max', $exclude)) $params[] = 'price_max=' . $price_max_filter;
                return implode('&', $params);
            };

            foreach ($brands as $brand) {
                // Loại bỏ brand filter cũ và thêm brand mới
                $base_params = $create_url_params(['brand', 'page']);
                $brand_url = 'products.php?' . $base_params . (empty($base_params) ? '' : '&') . 'brand=' . strtolower($brand);
                $active_class = (strtolower($brand_filter) === strtolower($brand)) ? 'active-filter' : '';
                echo '<a href="' . $brand_url . '" class="' . $active_class . '">' . ucfirst($brand) . '</a>';
            }
            ?>
        </div>
        
        <!-- KHỐI LỌC THEO THANH TRƯỢT GIÁ -->
        <div class="price-range-control">
            <h4>Khoảng giá (Triệu VND)</h4>
            <form action="products.php" method="GET" id="price-filter-form">
                <!-- Giữ lại các bộ lọc hiện có -->
                <?php 
                $current_params_for_form = $get_current_params(['price_min', 'price_max', 'page']);
                if (!empty($current_params_for_form)) {
                    parse_str(rtrim($current_params_for_form, '&'), $hidden_params);
                    foreach($hidden_params as $key => $value) {
                        echo '<input type="hidden" name="' . htmlspecialchars($key) . '" value="' . htmlspecialchars($value) . '">';
                    }
                }
                ?>

                <div style="display: flex; justify-content: space-between; margin-bottom: 10px;">
                    <span id="price-min-display">Min: <?php echo number_format($price_min_filter, 0); ?> Tr</span>
                    <span id="price-max-display">Max: <?php echo number_format($price_max_filter, 0); ?> Tr</span>
                </div>
                
                <input type="range" min="0" max="100" value="<?php echo $price_min_filter; ?>" name="price_min" id="price-min-slider" style="width: 100%;" oninput="updateRangeDisplay(this.value, 'min')">
                <input type="range" min="0" max="100" value="<?php echo $price_max_filter; ?>" name="price_max" id="price-max-slider" style="width: 100%;" oninput="updateRangeDisplay(this.value, 'max')">
                
                <button type="submit" style="margin-top: 10px; padding: 8px 15px; background-color: var(--primary-color); color: white; border: none; border-radius: 5px;">Áp dụng</button>
            </form>
        </div>
    </div>


    <div class="product-list-content">
        <h3>Chọn theo tiêu chí</h3>
        <div class="filter-options">
            <?php 
            // Hàm tiện ích để tạo các tham số URL hiện có
            $get_current_params = function($exclude = []) use ($cat_id, $search_query, $brand_filter, $filter_stock, $sort_by, $price_min_filter, $price_max_filter) {
                $params = [];
                if ($cat_id > 0 && !in_array('cat_id', $exclude)) $params[] = 'cat_id=' . $cat_id;
                if (!empty($search_query) && !in_array('search_query', $exclude)) $params[] = 'search_query=' . urlencode($search_query);
                if (!empty($brand_filter) && !in_array('brand', $exclude)) $params[] = 'brand=' . urlencode($brand_filter);
                if (!empty($filter_stock) && !in_array('stock', $exclude)) $params[] = 'stock=' . $filter_stock;
                if (!empty($sort_by) && !in_array('sort', $exclude)) $params[] = 'sort=' . $sort_by;
                if ($price_min_filter > 0 && !in_array('price_min', $exclude)) $params[] = 'price_min=' . $price_min_filter;
                if ($price_max_filter < 100 && !in_array('price_max', $exclude)) $params[] = 'price_max=' . $price_max_filter;
                return implode('&', $params) . (empty($params) ? '' : '&');
            };
            
            // Đánh dấu bộ lọc đang hoạt động
            $isActive = function($param) use ($filter_stock, $sort_by) {
                return ($param == $filter_stock || $param == $sort_by) ? 'active-filter' : '';
            };

            $base_url = 'products.php?' . $get_current_params(['sort', 'stock', 'price_min', 'price_max', 'page']);
            ?>
            
            <!-- LỌC SẴNG HÀNG -->
            <a href="<?php echo $base_url; ?>stock=available" class="<?php echo $isActive('available'); ?>">sẵn hàng</a>
            
            <!-- SẮP XẾP GIÁ -->
            <a href="<?php echo $base_url; ?>sort=price_asc" class="<?php echo $isActive('price_asc'); ?>">giá thấp đến cao</a>
            <a href="<?php echo $base_url; ?>sort=price_desc" class="<?php echo $isActive('price_desc'); ?>">giá cao đến thấp</a>
        </div>

        <div class="product-grid">
            <?php
            if ($products_result && $products_result->num_rows > 0) {
                while($product = $products_result->fetch_assoc()) {
                    $stock_status = $product['stock'] > 0 ? '('.$product['stock'].') còn hàng' : '(x) đặt hàng';
                    
                    // LOGIC XỬ LÝ ẢNH
                    $db_image_path = $product['image_path'] ?? 'placeholder.png'; 
                    $full_image_path = 'images/' . $db_image_path; 
                    $image_source = file_exists($full_image_path) && !is_dir($full_image_path) ? $full_image_path : 'https://placehold.co/220x150/e0e0e0/333333?text=Ảnh SP Lỗi';
            ?>
            <a href="detail.php?id=<?php echo $product['id']; ?>" class="product-card">
                <div class="product-image" style="height: 150px; display: flex; align-items: center; justify-content: center; overflow: hidden; background-color: white;">
                     <img src="<?php echo $image_source; ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" style="max-width: 100%; max-height: 100%; object-fit: contain;">
                </div>
                <div class="product-info">
                    <h4><?php echo htmlspecialchars($product['name']); ?></h4>
                    <div class="price"><?php echo number_format($product['price'], 0, ',', '.'); ?> đ</div>
                    <div class="action-row">
                        <span class="stock-status"><?php echo $stock_status; ?></span>
                        <span class="buy-icon">icon</span>
                    </div>
                </div>
            </a>
            <?php
                }
            } else {
                echo "<p>Không tìm thấy sản phẩm nào phù hợp với tiêu chí lọc.</p>";
            }
            ?>
        </div>

        <div class="pagination">
            <?php
            $base_url_for_pagination = 'products.php?' . $get_current_params(['page']);
            
            // Điều chỉnh hiển thị nút phân trang (Chỉ hiển thị nếu tổng số trang > 1)
            if ($total_pages > 1) {
                // Nút Trang trước
                if ($current_page > 1) {
                    echo '<a href="' . $base_url_for_pagination . 'page=' . ($current_page - 1) . '"><</a>';
                } else {
                    echo '<span><</span>';
                }

                // --- Logic hiển thị số trang ---
                $start_page = max(1, $current_page - 2);
                $end_page = min($total_pages, $current_page + 2);

                if ($start_page > 1) {
                    echo '<a href="' . $base_url_for_pagination . 'page=1">1</a>';
                    if ($start_page > 2) {
                        echo '<span>...</span>';
                    }
                }

                for ($i = $start_page; $i <= $end_page; $i++) {
                    if ($i == $current_page) {
                        echo '<span class="active-page">' . $i . '</span>';
                    } else {
                        echo '<a href="' . $base_url_for_pagination . 'page=' . $i . '">' . $i . '</a>';
                    }
                }

                if ($end_page < $total_pages) {
                    if ($end_page < $total_pages - 1) {
                        echo '<span>...</span>';
                    }
                    echo '<a href="' . $base_url_for_pagination . 'page=' . $total_pages . '">' . $total_pages . '</a>';
                }
                // --- Kết thúc Logic hiển thị số trang ---


                // Nút Trang sau
                if ($current_page < $total_pages) {
                    echo '<a href="' . $base_url_for_pagination . 'page=' . ($current_page + 1) . '">></a>';
                } else {
                    echo '<span>></span>';
                }
            }
            ?>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>