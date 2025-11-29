<?php include 'includes/header.php'; ?>
<?php 
// MOCK DATA cho Giỏ hàng
$cart_items = [
    ['id' => 1, 'name' => 'Macbook Pro M1', 'price' => 20199000, 'qty' => 1, 'selected' => true],
    ['id' => 2, 'name' => 'Tai nghe Sony WH', 'price' => 40199000, 'qty' => 1, 'selected' => false]
];
$subtotal = 0;
foreach($cart_items as $item) {
    if ($item['selected']) {
        $subtotal += $item['price'] * $item['qty'];
    }
}
?>
<style>
/* CSS cho Trang Giỏ hàng */
.cart-header { margin-top: 10px; margin-bottom: 20px; font-size: 14px; }
.cart-item-row { display: flex; align-items: center; padding: 15px; }
.cart-item-row input[type="checkbox"] { margin-right: 15px; }
.item-info { display: flex; align-items: center; flex-grow: 1; }
.item-image { width: 80px; height: 80px; background-color: var(--background-color); border-radius: 5px; margin-right: 15px; flex-shrink: 0; }
.item-details { width: 250px; }
.cart-price, .cart-subtotal { width: 100px; text-align: right; font-weight: bold; }
.cart-qty { display: flex; align-items: center; width: 100px; }
.cart-qty input { width: 40px; text-align: center; border: 1px solid var(--border-color); margin: 0 5px; }
.cart-delete { margin-left: 20px; color: var(--price-color); cursor: pointer; }

/* Summary */
.checkout-summary h3 { margin-bottom: 10px; font-size: 18px; }
.summary-line { display: flex; justify-content: space-between; margin-bottom: 8px; }
.summary-total { font-size: 20px; font-weight: bold; color: var(--price-color); border-top: 1px solid var(--border-color); padding-top: 10px; margin-top: 10px; }
.proceed-btn { display: block; width: 100%; padding: 10px; background-color: var(--primary-color); color: white; text-align: center; border: none; border-radius: 5px; margin-top: 15px; text-decoration: none; }
</style>

<div class="cart-header">Trang chủ > giỏ hàng của bạn</div>

<div class="cart-grid">
    <div class="cart-details">
        <!-- Header Row -->
        <div class="cart-item-row" style="background-color: white; font-weight: bold; border-bottom: 2px solid var(--primary-color);">
            <input type="checkbox" style="visibility: hidden;">
            <div style="width: 250px;">Tất cả (<?php echo count($cart_items); ?>) sản phẩm</div>
            <div class="cart-price">Đơn giá</div>
            <div class="cart-qty">Số lượng</div>
            <div class="cart-subtotal">Thành tiền</div>
            <div class="cart-delete">Xóa</div>
        </div>

        <?php foreach ($cart_items as $item): ?>
        <div class="cart-item-row">
            <input type="checkbox" <?php echo $item['selected'] ? 'checked' : ''; ?>>
            <div class="item-info">
                <div class="item-image">ảnh sản phẩm</div>
                <div class="item-details"><?php echo htmlspecialchars($item['name']); ?></div>
            </div>
            <div class="cart-price"><?php echo number_format($item['price'], 0, ',', '.'); ?> đ</div>
            <div class="cart-qty">
                <button onclick="updateQuantity(<?php echo $item['id']; ?>, -1)">-</button>
                <input type="text" id="qty-<?php echo $item['id']; ?>" value="<?php echo $item['qty']; ?>" readonly>
                <button onclick="updateQuantity(<?php echo $item['id']; ?>, 1)">+</button>
            </div>
            <div class="cart-subtotal"><?php echo number_format($item['price'] * $item['qty'], 0, ',', '.'); ?> đ</div>
            <div class="cart-delete">Xóa</div>
        </div>
        <?php endforeach; ?>
    </div>
    
    <div class="checkout-summary">
        <h3>Thông tin đơn hàng</h3>
        <div class="summary-line">
            <span>Tổng tiền sản phẩm</span>
            <span><?php echo number_format($subtotal, 0, ',', '.'); ?> đ</span>
        </div>
        <div class="summary-total">
            <span>Cần thanh toán</span>
            <span><?php echo number_format($subtotal, 0, ',', '.'); ?> đ</span>
        </div>
        <a href="checkout.php" class="proceed-btn">Tiến hành đặt hàng</a>
    </div>
</div>

<?php include 'includes/footer.php'; ?>