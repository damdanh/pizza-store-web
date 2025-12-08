
    <section class="booking-container">

        <div class="booking-image">
            <img src="<?= $base_url_path ?>public/user/img/Screenshot.png" alt="">
        </div>

        <div class="booking-info-section">
            <h2>ĐẶT BÀN THÀNH CÔNG!</h2>

            <p style="font-size:18px; margin:20px 0;">
                Mã đặt bàn của quý khách: 
                <strong>#<?= $bookingInfo['id'] ?></strong>
            </p>

            <div class="info-item">
                <span class="info-label">Tên:</span>
                <span><?= htmlspecialchars($bookingInfo['name']) ?></span>
            </div>

            <div class="info-item">
                <span class="info-label">Số điện thoại:</span>
                <span><?= htmlspecialchars($bookingInfo['phone']) ?></span>
            </div>

            <div class="info-item">
                <span class="info-label">Email:</span>
                <span><?= htmlspecialchars($bookingInfo['email'] ?: 'Không có') ?></span>
            </div>

            <div class="info-item">
                <span class="info-label">Số lượng người:</span>
                <span><?= $bookingInfo['people'] ?> người</span>
            </div>

            <div class="info-item">
                <span class="info-label">Ngày giờ:</span>
                <span><?= $bookingInfo['date'] ?> <?= $bookingInfo['time'] ?></span>
            </div>

            <div class="info-item">
                <span class="info-label">Chi nhánh:</span>
                <span><?= htmlspecialchars($bookingInfo['branch']) ?></span>
            </div>

            <div class="info-item">
            <span class="info-label">Ghi chú:</span>
            <span><?= htmlspecialchars($bookingInfo['notes'] ?: 'Không có') ?></span>
        </div>

        <h3 style="margin-top:20px;">🍕 Món đã đặt:</h3>

        <?php if (empty($items)): ?>
            <p>Không chọn món nào.</p>
        <?php else: ?>
            <ul style="margin-left:15px;">
                <?php foreach ($items as $it): ?>
                    <li>
                        <strong><?= htmlspecialchars($item['ten_mon']) ?></strong> —
                        SL: <?= $it['so_luong'] ?> —
                        Giá: <?= number_format($it['gia']) ?>đ
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>

            <div class="button-group">
                <button class="back-btn" onclick="history.back()">Quay lại</button>
                <button class="submit-btn">Xác nhận</button>
            </div>
        </div>
    </section>
