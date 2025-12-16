<?php
$cart = $_SESSION['cart'] ?? [];
$total = 0;
?>

<section class="booking-container">
    <div class="booking-image"></div>

    <div class="booking-form-section">
        <h2>ĐẶT BÀN</h2>
        
        <div class="form-section" style="border: 1px solid #ddd; padding: 15px; border-radius: 8px; margin-bottom: 25px;">
            <h3 style="margin-top: 0; color: #3498db;">Tra Cứu Đơn Hàng</h3>
            <form action="<?= $base_url_path ?>public/dang-cho-xu-ly" method="GET" style="display: flex; gap: 10px;">
                <input type="text" name="id" required 
                       placeholder="Nhập Mã Đơn Hàng (ID)" 
                       pattern="[0-9]+" title="Chỉ được nhập số"
                       style="flex-grow: 1; padding: 10px; border: 1px solid #ccc; border-radius: 4px;">
                
                <button type="submit" style="
                    padding: 10px 15px; 
                    background: #3498db; 
                    color: white; 
                    border: none; 
                    border-radius: 4px; 
                    cursor: pointer;
                    white-space: nowrap;">
                    Xem Chi Tiết
                </button>
            </form>
            <p style="margin: 10px 0 0 0; font-size: 13px; color: #7f8c8d;">
                Đã đặt hàng và muốn kiểm tra trạng thái Admin xử lý?
            </p>
        </div>
        <form action="<?= $base_url_path ?>public/process_booking.php" method="POST" id="bookingForm">
            <div class="form-section">
                <h3>Điền thông tin đặt bàn</h3>
                
                <div class="form-group">
                    <label>Số lượng bàn *</label>
                    <input type="number" name="tables" min="1" value="1" required>
                    <small style="color: #7f8c8d; display: block; margin-top: 5px;">
                        💰 Giá mỗi bàn: 50,000đ
                    </small>
                </div>
                                
                <div class="form-group">
                    <label>Ngày đặt *</label>
                    <input type="date" name="date" value="<?= date('Y-m-d') ?>" min="<?= date('Y-m-d') ?>" required>
                </div>

                <div class="form-group">
                    <label>Thời gian *</label>
                    <select name="time" required>
                        <option>10:00:00</option>
                        <option>12:00:00</option>
                        <option>13:00:00</option>
                        <option>15:00:00</option>
                        <option>17:00:00</option>
                        <option selected>19:00:00</option>
                    </select>
                </div>
            </div>

            <div class="form-section">
                <h3>Chọn chi nhánh</h3>
                <select name="branch" required style="width: 100%; padding: 10px;">
                    <option value="">Chọn chi nhánh</option>
                    <option>Pizza & Pasta - 24 Nguyễn Thị Nghĩa</option>
                    <option>Pizza & Pasta - Saigon Centre</option>
                    <option>Pizza & Pasta - Bến Thành</option>
                </select>
            </div>

            <div class="form-group">
                <label>Họ và tên *</label>
                <input type="text" name="name" required placeholder="Nhập họ và tên">
            </div>

            <div class="form-group">
                <label>Số điện thoại *</label>
                <input type="tel" name="phone" required placeholder="0901234567" pattern="[0-9]{10,11}">
            </div>

            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" placeholder="email@example.com">
            </div>

            <div class="form-group">
                <label>Ghi chú</label>
                <textarea name="notes" rows="3" placeholder="Yêu cầu đặc biệt..."></textarea>
            </div>

            <div class="form-section">
                <h3>Món đã chọn</h3>
                
                <?php if (empty($cart)): ?>
                    <p style="color: #999; text-align: center;">Chưa có món nào được chọn</p>
                <?php else: ?>
                    <?php foreach ($cart as $item): 
                        $itemTotal = $item['gia'] * $item['so_luong'];
                        $total += $itemTotal;
                    ?>
                    <div class="cart-item" style="display: flex; gap: 15px; margin-bottom: 15px; padding: 10px; background: #f9f9f9; border-radius: 8px; position: relative;">
                        <img src="<?= htmlspecialchars($item['hinh_anh']) ?>" 
                             alt="<?= htmlspecialchars($item['ten_mon']) ?>" 
                             style="width: 70px; height: 70px; object-fit: cover; border-radius: 5px;">

                        <div style="flex: 1;">
                            <p style="margin: 0; font-weight: 600;">
                                <?= htmlspecialchars($item['ten_mon']) ?>
                            </p>

                            <p style="margin: 5px 0; color: #666;">
                                Số lượng: <?= $item['so_luong'] ?> × 
                                <?= number_format($item['gia'], 0, ',', '.') ?>đ
                            </p>

                            <p style="margin: 0; color: #e74c3c; font-weight: 600;">
                                <?= number_format($itemTotal, 0, ',', '.') ?>đ
                            </p>
                        </div>
                    </div>
                    <?php endforeach; ?>
                    
                    <div style="margin-top: 20px; padding-top: 15px; border-top: 2px solid #ddd;">
                        <div style="background: #e8f5e9; padding: 15px; border-radius: 8px; margin-bottom: 15px;">
                            <div style="text-align: right; margin-bottom: 8px;">
                                <span style="color: #2c3e50;">Giá trị món đã chọn:</span>
                                <span style="font-weight: 600; font-size: 18px;"><?= number_format($total, 0, ',', '.') ?>đ</span>
                            </div>
                            <p style="margin: 0; text-align: right; color: #27ae60; font-size: 13px;">
                                ✓ Thanh toán tại nhà hàng
                            </p>
                        </div>
                        
                        <div style="background: #fff3cd; padding: 15px; border-radius: 8px;">
                            <p style="margin: 0 0 10px 0; font-weight: 600; color: #856404;">
                                📝 Cần thanh toán trước:
                            </p>
                            <div style="text-align: right; margin-bottom: 5px;">
                                <span style="color: #7f8c8d;">• Phí đặt bàn (số bàn × 50k)</span>
                            </div>
                            <div style="text-align: right;">
                                <span style="color: #7f8c8d;">• Phí dịch vụ (20% giá món)</span>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <button type="submit" class="submit-btn" style="margin-top: 15px; width: 100%; padding: 15px; background: #e74c3c; color: white; border: none; border-radius: 8px; font-size: 16px; font-weight: 600; cursor: pointer;">
                <?= empty($cart) ? 'Đặt bàn (không gọi món)' : 'Xác nhận đặt bàn' ?>
            </button>
        </form>
    </div>
</section>

<script>
(function() {
    const form = document.getElementById('bookingForm');
    const submitBtn = form.querySelector('button[type="submit"]');
    let isSubmitting = false;

    form.addEventListener('submit', function(e) {
        // ====== CHỐNG DOUBLE SUBMIT ======
        if (isSubmitting) {
            e.preventDefault();
            alert("Đang xử lý, vui lòng đợi...");
            return false;
        }

        // ====== VALIDATE DỮ LIỆU ======
        const name = document.querySelector('input[name="name"]').value.trim();
        const phone = document.querySelector('input[name="phone"]').value.trim();
        const branch = document.querySelector('select[name="branch"]').value;

        if (!name || name.length < 2) {
            e.preventDefault();
            alert("Vui lòng nhập họ và tên (ít nhất 2 ký tự)!");
            return false;
        }

        if (!phone || phone.length < 10) {
            e.preventDefault();
            alert("Vui lòng nhập số điện thoại hợp lệ (10-11 số)!");
            return false;
        }

        if (!branch) {
            e.preventDefault();
            alert("Vui lòng chọn chi nhánh!");
            return false;
        }

        // ====== DISABLE BUTTON & HIỂN THỊ LOADING ======
        isSubmitting = true;
        submitBtn.disabled = true;
        submitBtn.style.opacity = '0.6';
        submitBtn.style.cursor = 'not-allowed';
        
        const originalText = submitBtn.textContent;
        submitBtn.textContent = '⏳ Đang xử lý...';

        // Timeout để reset nếu có lỗi
        setTimeout(() => {
            isSubmitting = false;
            submitBtn.disabled = false;
            submitBtn.style.opacity = '1';
            submitBtn.style.cursor = 'pointer';
            submitBtn.textContent = originalText;
        }, 5000);

        return true;
    });

    // ====== VALIDATE PHONE NUMBER REALTIME ======
    const phoneInput = document.querySelector('input[name="phone"]');
    phoneInput.addEventListener('input', function(e) {
        this.value = this.value.replace(/[^0-9]/g, '');
        if (this.value.length > 11) {
            this.value = this.value.slice(0, 11);
        }
    });

    // ====== VALIDATE DATE ======
    const dateInput = document.querySelector('input[name="date"]');
    dateInput.addEventListener('change', function() {
        const selectedDate = new Date(this.value);
        const today = new Date();
        today.setHours(0, 0, 0, 0);

        if (selectedDate < today) {
            alert("Không thể đặt bàn cho ngày đã qua!");
            this.value = today.toISOString().split('T')[0];
        }
    });
})();
</script>