</main>
    <footer>
        © Computer store
    </footer>
    <?php 
    // Đóng kết nối DB (nếu có)
    if (isset($conn)) {
        $conn->close();
    }
    ?>
    <script>
        // JS cơ bản cho giỏ hàng (ví dụ: tăng giảm số lượng)
        function updateQuantity(itemId, change) {
            const input = document.getElementById('qty-' + itemId);
            let currentQty = parseInt(input.value);
            if (!isNaN(currentQty) && currentQty + change >= 1) {
                input.value = currentQty + change;
                // TODO: Gửi yêu cầu AJAX lên PHP để cập nhật giỏ hàng
                console.log('Updated item ' + itemId + ' to ' + input.value);
            }
        }
    </script>
</body>
</html>