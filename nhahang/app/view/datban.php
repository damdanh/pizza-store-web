<?php
$cart = $_SESSION['cart'] ?? [];
$total = 0;
?>

<section class="booking-container">
    <div class="booking-image"></div>


    <div class="booking-form-section">
        <h2>ĐẶT BÀN</h2>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"> 
</head>
<body>
    
   
       <section class="booking-container">
        <div class="booking-image"></div>

        
        <form action="/WD20302-PRO1014_N5/nhahang/public/process_booking.php" method="POST">

            <div class="form-section">
                <h3>Điền thông tin đặt bàn</h3>

                <div class="form-group">
                    <label>Số lượng người *</label>
                    <input type="number" name="people" min="1" value="2" required>
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

            <!-- HIỂN THỊ GIỎ HÀNG -->
            <!-- HIỂN THỊ GIỎ HÀNG -->
            <div class="form-section">
                <h3>Món đã chọn</h3>
                
                <?php if (empty($cart)): ?>
                    <p style="color: #999; text-align: center;">Chưa có món nào được chọn</p>

                <?php else: ?>
                    <?php foreach ($cart as $item): 
                        $itemTotal = $item['gia'] * $item['so_luong'];
                        $total += $itemTotal;
                    ?>
                    <div class="cart-item" style="
                        display: flex;
                        gap: 15px;
                        margin-bottom: 15px;
                        padding: 10px;
                        background: #f9f9f9;
                        border-radius: 8px;
                        position: relative;
                    ">
                        <!-- Nút Xoá -->
                        <a href="../public/remove_item.php?id=<?= $item['id_mon'] ?>"
                           style="
                                position: absolute;
                                top: 8px;
                                right: 8px;
                                color: red;
                                font-size: 18px;
                                text-decoration: none;
                                font-weight: bold;
                           ">x</a>

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
                    
                    <!-- Tổng tiền -->
                    <div style="margin-top: 20px; padding-top: 15px; border-top: 2px solid #ddd;">
                        <p style="
                        font-size: 18px;  font-weight: bold; text-align: right;">
                            Tổng cộng: 
                            <span style="color: #e74c3c;">
                                <?= number_format($total, 0, ',', '.') ?>đ
                            </span>
                        </p>
                    </div>

                <?php endif; ?>

            <button type="submit" class="submit-btn" style=" margin-top: 15px; width: 100%; padding: 15px; background: #e74c3c; color: white; border: none; border-radius: 8px; font-size: 16px; font-weight: 600; cursor: pointer;">
                <?= empty($cart) ? 'Đặt bàn (không gọi món)' : 'Xác nhận đặt bàn' ?>
            </button>
        </form>

    </div>
</section>

        <p style="font-size: 12px; color: #666; margin-top: 15px;">Mọi thông tin được bảo mật. Bạn có thể hủy đăng ký bất cứ lúc nào.</p>
    </section>


    
</body>
</html>

