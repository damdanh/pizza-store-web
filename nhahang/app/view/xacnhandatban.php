<?php
session_start();

// ĐÚNG 100% – cùng vị trí với process_booking.php
require_once __DIR__ . '/../config/database.php';   // ← DÒNG NÀY PHẢI ĐÚNG

$booking = $_SESSION['booking'] ?? null;
if (!$booking) {
    header('Location: datban.php');
    exit;
}
?>
<?php
$base_url_path = '/WD20302-PRO1014_N5/nhahang/'; 

$title = $title ?? 'PIZZA & PASTA - Nhà Hàng Online'; 
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <title><?php echo htmlspecialchars($title); ?></title>

    <link rel="stylesheet" href="<?php echo $base_url_path; ?>public/user/css/xacnhandatban.css"> 

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"> 
</head>
<body>
    
    <?php 

    include __DIR__ . '/header.php'; 
    ?>
    <section class="booking-container">
        <div class="booking-image"> <img src="img/Screenshot 2025-11-29 at 00.38.02.png" alt=""></div>
        
        <div class="booking-info-section">
        <h2>ĐẶT BÀN THÀNH CÔNG!</h2>
<p style="font-size:18px; margin:20px 0;">Mã đặt bàn của quý khách: <strong>#<?= $booking['id'] ?></strong></p>

<div class="info-item">
    <span class="info-label">Tên:</span>
    <span><?= htmlspecialchars($booking['name']) ?></span>
</div>
<div class="info-item">
    <span class="info-label">Số điện thoại:</span>
    <span><?= htmlspecialchars($booking['phone']) ?></span>
</div>
<div class="info-item">
    <span class="info-label">Email:</span>
    <span><?= htmlspecialchars($booking['email'] ?: 'Không có') ?></span>
</div>
<div class="info-item">
    <span class="info-label">Số lượng người:</span>
    <span><?= $booking['people'] ?> người</span>
</div>
<div class="info-item">
    <span class="info-label">Ngày giờ:</span>
    <span><?= $booking['date'] ?> <?= $booking['time'] ?></span>
</div>
<div class="info-item">
    <span class="info-label">Chi nhánh:</span>
    <span><?= htmlspecialchars($booking['branch']) ?></span>
</div>
            
            <div class="button-group">
                <button class="back-btn" onclick="history.back()">Quay lại</button>
                <button class="submit-btn">Xác nhận</button>
            </div>
        </div>
    </section>

    <section class="community-section">
        <h2>THAM GIA CỘNG ĐỒNG CỦA CHÚNG TÔI</h2>
        <p style="color: #666; margin-bottom: 30px;">Đăng ký để nhận thông tin mới nhất</p>
        <form class="subscribe-form">
            <input type="text" placeholder="Tên">
            <input type="text" placeholder="Họ">
            <input type="email" placeholder="Email">
            <button>ĐĂNG KÝ</button>
        </form>
    </section>
    
<?php include __DIR__ . '/footer.php'; ?>
    </body>
</html> 
    