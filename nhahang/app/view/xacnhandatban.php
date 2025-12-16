<section class="booking-container">
    <div class="booking-image">
        <img src="<?= $base_url_path ?>public/user/img/Screenshot.png" alt="">
    </div>

    <div class="booking-info-section" id="bookingContent">

        <?php if (isset($_SESSION['pending_booking'])): ?>
            <?php $pb = $_SESSION['pending_booking']; // ?>
            
            <h2 style="color: #e67e22; text-align:center;">Vui lòng thanh toán để hoàn tất đặt bàn</h2>
            
            <div style="background: #f8f9fa; padding: 20px; border-radius: 10px; margin: 20px 0;">
                <div style="padding: 15px; background: #fff3cd; border-radius: 8px; margin-bottom: 15px;">
                    <p style="margin: 0; font-size: 14px; color: #856404;">
                        ℹ️ <strong>Lưu ý:</strong> Bạn chỉ cần thanh toán tiền đặt bàn và phí dịch vụ.
                        <br>
                        Phần còn lại của tiền món ăn sẽ thanh toán trực tiếp tại nhà hàng.
                    </p>
                </div>
                
                <div style="display: flex; justify-content: space-between; margin-bottom: 10px;">
                    <span style="color: #7f8c8d;">Tổng món (chưa VAT):</span>
                    <span style="font-weight: 600;"><?= number_format($pb['tien_mon_chua_vat'], 0, ',', '.') ?>đ</span>
                </div>
                
                <div style="display: flex; justify-content: space-between; margin-bottom: 10px;">
                    <span style="color: #7f8c8d;">VAT (8%):</span>
                    <span style="font-weight: 600;"><?= number_format($pb['vat'], 0, ',', '.') ?>đ</span>
                </div>
                
                <div style="display: flex; justify-content: space-between; margin-bottom: 15px; padding-bottom: 10px; border-bottom: 1px dashed #ddd;">
                    <span style="color: #2c3e50; font-weight: 600;">Tổng món (có VAT):</span>
                    <span style="font-weight: 600; text-decoration: line-through; color: #95a5a6;">
                        <?= number_format($pb['tien_mon_co_vat'], 0, ',', '.') ?>đ
                    </span>
                    <span style="color: #27ae60; font-size: 12px; margin-left: 10px;">
                        (Tổng giá trị đơn hàng)
                    </span>
                </div>
                
                <div style="display: flex; justify-content: space-between; margin-bottom: 10px;">
                    <span style="color: #2c3e50;">Phí đặt bàn (<?= $pb['tables'] ?> bàn × 50,000đ):</span>
                    <span style="font-weight: 600;"><?= number_format($pb['phi_ban'], 0, ',', '.') ?>đ</span>
                </div>
                
                <div style="display: flex; justify-content: space-between; margin-bottom: 10px;">
                    <span style="color: #2c3e50;">Phí dịch vụ (20% tổng món có VAT):</span>
                    <span style="font-weight: 600; color: #e67e22;"><?= number_format($pb['phi_dich_vu'], 0, ',', '.') ?>đ</span>
                </div>
                
                <hr style="border: none; border-top: 2px solid #ddd; margin: 15px 0;">
                
                <div style="display: flex; justify-content: space-between;">
                    <span style="font-size: 20px; font-weight: bold;">CẦN THANH TOÁN NGAY:</span>
                    <span style="font-size: 24px; font-weight: bold; color: #e74c3c;">
                        <?= number_format($pb['amount'], 0, ',', '.') ?>đ
                    </span>
                </div>
                
                <div style="background: #e8f5e9; padding: 10px; border-radius: 5px; margin-top: 20px; text-align: center;">
                    <p style="margin: 0; color: #155724; font-size: 16px;">
                        👉 Số tiền còn lại phải thanh toán tại quầy:
                    </p>
                    <p style="margin: 5px 0 0 0; color: #27ae60; font-size: 24px; font-weight: bold;">
                        <?= number_format($pb['tien_thanh_toan_sau_db'] ?? 0, 0, ',', '.') ?>đ
                    </p>
                </div>
                
                <p style="color:#2c3e50; font-weight:bold; background:#f8f9fa; padding:12px; border-radius:8px; text-align:center; margin-top:15px;">
                    Nội dung chuyển khoản: 
                    <span style="color:#e74c3c; font-size:20px;">
                        <?= $pb['order_code'] ?>
                    </span>
                </p>
            </div>

            <div style="text-align:center; margin:30px 0;">
                <img src="<?= $_SESSION['qr_code'] ?>" alt="QR Code" 
                     style="width:300px; height:300px; border:3px solid #ddd; border-radius:12px; box-shadow:0 4px 20px rgba(0,0,0,0.1);">
                <p style="margin-top:15px; color:#7f8c8d;">
                    Quét bằng app ngân hàng (MB Bank, Vietcombank, ACB, BIDV, v.v.)
                </p>
            </div>

            <div style="text-align: center; margin-top: 30px; padding: 20px; background: #fff3cd; border-radius: 10px; border: 2px dashed #ffc107;">
                <p style="margin: 0 0 15px 0; color: #e67e22; font-size: 16px;">
                    <strong>Đã chuyển khoản xong?</strong><br>
                    (Thường mất 30 giây - 2 phút để cập nhật)
                </p>
                
                <div style="display: flex; justify-content: center; align-items: center; gap: 15px;">
                    
                    <a href="<?= $base_url_path ?>public/dat-ban" style="
                        padding: 14px 40px; 
                        background: #95a5a6; 
                        color: white; 
                        border: none; 
                        border-radius: 8px; 
                        font-size: 18px; 
                        font-weight: bold; 
                        cursor: pointer;
                        display: inline-flex;
                        align-items: center;
                        text-decoration: none;
                        box-shadow: 0 4px 15px rgba(149,165,166,0.4);">
                        <span class="material-icons-outlined" style="margin-right: 8px; font-size: 20px;"></span> TRỞ LẠI
                    </a>

                    <form action="<?= $base_url_path ?>public/force_confirm.php" method="POST" style="margin: 0;">
                        <button type="submit" style="
                            padding: 14px 40px; 
                            background: #27ae60; 
                            color: white; 
                            border: none; 
                            border-radius: 8px; 
                            font-size: 18px; 
                            font-weight: bold; 
                            cursor: pointer;
                            box-shadow: 0 4px 15px rgba(39,174,96,0.4);">
                            XÁC NHẬN ĐÃ THANH TOÁN
                        </button>
                    </form>
                </div>
            </div>

            <div style="text-align:center; margin-top:20px; color:#95a5a6; font-size:14px;">
                Sau khi bấm nút, hệ thống sẽ lưu đặt bàn ngay lập tức (Chờ Admin xác nhận)
            </div>

        <?php elseif (isset($_SESSION['booking']) && !empty($_SESSION['booking']['id'])): ?>
            <?php $bookingInfo = $_SESSION['booking']; // ?>

            <h2 style="color: #27ae60; text-align: center;">ĐẶT BÀN & THANH TOÁN THÀNH CÔNG!</h2>

            <p style="font-size:20px; text-align:center; margin:20px 0;">
                Mã đặt bàn: <strong style="color:#e74c3c;">#<?= $bookingInfo['id'] ?></strong><br>
                Mã giao dịch: <strong style="color:#3498db;"><?= $bookingInfo['order_code'] ?? 'N/A' ?></strong>
            </p>

            <p style="text-align:center; color:#27ae60; font-size:18px; font-weight:bold;">
                Cảm ơn quý khách! Chúng tôi đã nhận được tiền cọc và sẽ liên hệ sớm. (Đang chờ Admin xác nhận)
            </p>

            <div class="info-item"><span class="info-label">Tên:</span> <span><?= htmlspecialchars($bookingInfo['name']) ?></span></div>
            <div class="info-item"><span class="info-label">Số điện thoại:</span> <span><?= htmlspecialchars($bookingInfo['phone']) ?></span></div>
            <div class="info-item"><span class="info-label">Email:</span> <span><?= htmlspecialchars($bookingInfo['email'] ?: 'Không có') ?></span></div>
            <div class="info-item">
                <span class="info-label">Số bàn:</span> 
                <span><?= $bookingInfo['tables'] ?> bàn (<?= number_format($bookingInfo['phi_ban'] ?? 0, 0, ',', '.') ?>đ)</span>
            </div>
            <div class="info-item"><span class="info-label">Ngày giờ:</span> <span><?= date('d/m/Y', strtotime($bookingInfo['date'])) ?> - <?= substr($bookingInfo['time'], 0, 5) ?></span></div>
            <div class="info-item"><span class="info-label">Chi nhánh:</span> <span><?= htmlspecialchars($bookingInfo['branch']) ?></span></div>
            <div class="info-item"><span class="info-label">Ghi chú:</span> <span><?= htmlspecialchars($bookingInfo['notes'] ?: 'Không có') ?></span></div>

            <?php if (!empty($bookingInfo['cart'])): ?>
                <h3 style="margin-top:25px; color:#2c3e50;">Món đã đặt:</h3>
                <ul style="margin-left:15px; background:#f9f9f9; padding:15px; border-radius:8px;">
                    <?php foreach ($bookingInfo['cart'] as $item): ?>
                        <li style="margin:8px 0;">
                            <strong><?= htmlspecialchars($item['ten_mon'] ?? 'Món ăn') ?></strong> 
                            × <?= $item['so_luong'] ?> 
                            = <?= number_format($item['gia'] * $item['so_luong'], 0, ',', '.') ?>đ
                        </li>
                    <?php endforeach; ?>
                </ul>
                
                <div style="background: #f8f9fa; padding: 15px; border-radius: 8px; margin-top: 15px;">
                    <div style="background: #d4edda; padding: 10px; border-radius: 5px; margin-bottom: 10px;">
                        <p style="margin: 0; color: #155724; font-size: 14px;">
                            ✅ Tổng tiền món: <strong style="text-decoration: line-through;"><?= number_format($bookingInfo['tien_mon_co_vat'] ?? 0, 0, ',', '.') ?>đ</strong> 
                            (Bao gồm VAT 8%: <?= number_format($bookingInfo['vat'] ?? 0, 0, ',', '.') ?>đ)
                        </p>
                        <p style="margin: 5px 0 0 0; color: #155724; font-size: 12px;">
                            (Giá trị gốc chưa VAT: <?= number_format($bookingInfo['tien_mon_chua_vat'] ?? 0, 0, ',', '.') ?>đ)
                        </p>
                    </div>
                    
                    <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                        <span>Phí đặt bàn:</span>
                        <span style="font-weight: 600;"><?= number_format($bookingInfo['phi_ban'] ?? 0, 0, ',', '.') ?>đ</span>
                    </div>
                    
                    <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                        <span>Phí dịch vụ (20%):</span>
                        <span style="font-weight: 600; color: #e67e22;"><?= number_format($bookingInfo['phi_dich_vu'] ?? 0, 0, ',', '.') ?>đ</span>
                    </div>
                    
                    <hr style="border: none; border-top: 2px solid #ddd; margin: 10px 0;">
                    
                    <div style="display: flex; justify-content: space-between;">
                        <span style="font-size: 18px; font-weight: bold;">ĐÃ THANH TOÁN (CỌC):</span>
                        <span style="font-size: 20px; font-weight: bold; color: #27ae60;">
                            <?= number_format($bookingInfo['total'], 0, ',', '.') ?>đ
                        </span>
                    </div>
                    
                    <div style="background: #fff3cd; padding: 10px; border-radius: 5px; margin-top: 10px;">
                        <p style="margin: 0; color: #856404; font-size: 13px;">
                            💰 <strong>Vui lòng thanh toán tại nhà hàng khi nhận bàn:</strong>
                        </p>
                        <p style="margin: 5px 0 0 0; color: #e74c3c; font-size: 20px; font-weight: bold; text-align: center;">
                            <?= number_format($bookingInfo['tien_thanh_toan_sau_db'] ?? 0, 0, ',', '.') ?>đ
                        </p>
                    </div>
                </div>
            <?php endif; ?>

            <div class="button-group" style="text-align:center; margin-top:30px;">
                <button class="back-btn" onclick="window.print()" style="
                    padding: 12px 30px;
                    background: #95a5a6;
                    color: white;
                    border: none;
                    border-radius: 8px;
                    font-size: 16px;
                    font-weight: 600;
                    cursor: pointer;
                    margin-right: 10px;">
                    🖨️ In hóa đơn
                </button>
                
                <a href="<?= $base_url_path ?>public" class="submit-btn" style="
                    display: inline-block; 
                    padding: 12px 30px; 
                    background: #3498db; 
                    color: white; 
                    text-decoration: none; 
                    border-radius: 8px;
                    font-size: 16px;
                    font-weight: 600;">
                    🏠 Về trang chủ
                </a>
            </div>

        <?php else: ?>
            <div style="text-align:center; padding:40px; background:#ffe6e6; border-radius:10px; margin:30px 0;">
                <p style="color:#e74c3c; font-size:18px; margin-bottom:20px;">
                    ⚠️ Không tìm thấy thông tin đặt bàn hoặc đặt bàn không thành công. Vui lòng đặt lại.
                </p>
                <a href="<?= $base_url_path ?>public/dat-ban" style="
                    display: inline-block;
                    padding: 12px 30px;
                    background: #e74c3c;
                    color: white;
                    text-decoration: none;
                    border-radius: 8px;
                    font-weight: 600;">
                    📅 Đặt bàn ngay
                </a>
            </div>
        <?php endif; ?>

    </div>
</section>

<?php
// XÓA FLAG force_confirm sau khi hiển thị thành công
if (isset($_SESSION['booking']) && isset($_SESSION['force_confirm_processed'])) {
    unset($_SESSION['force_confirm_processed']);
}

// Clear session nếu có yêu cầu
if (isset($_GET['clear_session'])) {
    session_destroy();
    header("Location: /WD20302-PRO1014_N5/nhahang/public/");
    exit;
}
?>