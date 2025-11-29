<?php include 'includes/header.php'; ?>
<?php 
// MOCK DATA cho Thanh toán
$checkout_item = ['name' => 'Macbook Pro M1', 'price' => 40199000, 'qty' => 1];
$total_amount = $checkout_item['price'] * $checkout_item['qty'];
?>
<style>
/* CSS cho Trang Thanh toán */
.checkout-grid { display: grid; grid-template-columns: 1fr 300px; gap: 30px; margin-top: 20px; }
.order-summary-box { background-color: white; padding: 20px; border: 1px solid var(--border-color); border-radius: 8px; }
.item-checkout { display: flex; align-items: center; margin-bottom: 15px; padding-bottom: 10px; border-bottom: 1px dashed var(--border-color); }
.item-checkout-image { width: 60px; height: 60px; background-color: var(--background-color); border-radius: 5px; margin-right: 15px; }
.customer-info-box { background-color: white; padding: 20px; border: 1px solid var(--border-color); border-radius: 8px; margin-bottom: 20px; }
.customer-info-box input[type="text"] { width: 100%; padding: 10px; margin-bottom: 10px; border: 1px solid var(--border-color); border-radius: 5px; }
.input-group-half { display: flex; gap: 10px; }
.input-group-half input { flex-grow: 1; }
.invoice-option { display: flex; justify-content: space-between; align-items: center; padding-top: 10px; }
.vat-info { font-size: 12px; color: var(--success-color); }
</style>

<div class="cart-header"><a href="cart.php" style="text-decoration: none; color: var(--text-color);">&lt; quay về giỏ hàng</a></div>

<div class="checkout-grid">
    <div class="checkout-main">
        <!-- Sản phẩm trong đơn -->
        <div class="order-summary-box">
            <h3>Sản phẩm trong đơn (<?php echo $checkout_item['qty']; ?>)</h3>
            <div class="item-checkout">
                <div class="item-checkout-image">ảnh sản phẩm</div>
                <div style="flex-grow: 1;">
                    <h4><?php echo htmlspecialchars($checkout_item['name']); ?></h4>
                    <span class="price"><?php echo number_format($checkout_item['price'], 0, ',', '.'); ?> đ</span>
                </div>
                <div>x<?php echo $checkout_item['qty']; ?></div>
            </div>
        </div>
        
        <!-- Thông tin người đặt hàng -->
        <div class="customer-info-box">
            <h3>Thông tin người đặt hàng</h3>
            <div class="input-group-half">
                <input type="text" placeholder="Họ và tên">
                <input type="text" placeholder="Số điện thoại">
            </div>
            <input type="text" placeholder="Địa chỉ">
            
            <div class="invoice-option">
                <span>Xuất hóa đơn công ty</span>
                <input type="checkbox">
            </div>
        </div>
    </div>
    
    <!-- Tóm tắt thanh toán -->
    <div class="checkout-summary">
        <h3>Tổng tiền đơn hàng</h3>
        <div class="summary-line">
            <span>Tổng tiền sản phẩm</span>
            <span><?php echo number_format($total_amount, 0, ',', '.'); ?> đ</span>
        </div>
        <div class="summary-total">
            <span>Cần thanh toán</span>
            <span><?php echo number_format($total_amount, 0, ',', '.'); ?> đ</span>
        </div>
        <div class="vat-info">(Đã bao gồm VAT)</div>
        <button class="proceed-btn" style="text-transform: uppercase;">Tiến hành đặt hàng</button>
    </div>
</div>

<?php include 'includes/footer.php'; ?>