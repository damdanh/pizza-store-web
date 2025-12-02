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

    <link rel="stylesheet" href="<?php echo $base_url_path; ?>public/user/css/datban.css"> 

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"> 
</head>
<body>
    
    <?php 

    include __DIR__ . '/header.php'; 
    ?>
       <section class="booking-container">
        <div class="booking-image"></div>
        
        <div class="booking-form-section">
            <h2>ĐẶT BÀN</h2>
            <div class="booking-date">
                <span>📅 Mon 12, 2025</span>
                <span>👤 7052</span>
                <span>📝</span>
            </div>
            
            <form id="bookingForm">
                <div class="form-section">
                    <h3>Điền thông tin đặt bàn</h3>
                    <p style="font-size: 13px; color: #999; margin-bottom: 20px;">Nhập</p>
                    
                    <div class="form-group">
                        <label>Số lượng người *</label>
                        <input type="number" value="1" min="1">
                    </div>
                    
                    <div class="form-group">
                        <label>Thời gian</label>
                        <select>
                            <option>10:00:00</option>
                            <option>12:00:00</option>
                            <option>13:00:00</option>
                            <option>15:00:00</option>
                            <option>17:00:00</option>
                            <option>19:00:00</option>
                        </select>
                    </div>
                </div>
                
                <div class="form-section">
                    <h3>Chọn vùng</h3>
                    <div class="location-select">
                        <select style="width: 100%; padding: 10px; border: none; background: white; border-radius: 5px;">
                            <option>Pizza & Pasta - 24 Nguyễn Thị Nghĩa -</option>
                        </select>
                    </div>
                </div>
                </form>
            
                <form action="/WD20302-PRO1014_N5/nhahang/public/process_booking.php" method="POST">
    <div class="form-group">
        <label>Họ và tên *</label>
        <input type="text" name="name" required placeholder="Nhập họ và tên">
    </div>
    <div class="form-group">
        <label>Số điện thoại *</label>
        <input type="tel" name="phone" required placeholder="Ví dụ: 0901234567">
    </div>
    <div class="form-group">
        <label>Email (không bắt buộc)</label>
        <input type="email" name="email" placeholder="email@example.com">
    </div>
    <input type="hidden" name="people" value="2">
    <input type="hidden" name="date" value="2025-12-15">
    <input type="hidden" name="time" value="19:00">
    <input type="hidden" name="branch" value="Pizza & Pasta - 24 Nguyễn Thị Nghĩa">

    <button type="submit" class="submit-btn">Tiếp tục</button>
</form>
        </div>
    </section>

    <section class="community-section">
        <h2>THAM GIA CỘNG ĐỒNG CỦA CHÚNG TÔI</h2>
        <p style="color: #666; margin-bottom: 30px;">Đăng ký để nhận thông tin mới nhất về Thực Đơn, Ưu Đãi, Tin Tức và Sự Kiện</p>
        <form class="subscribe-form">
            <input type="text" placeholder="Tên">
            <input type="text" placeholder="Họ">
            <input type="email" placeholder="Địa chỉ Email">
            <button type="submit">ĐĂNG KÝ</button>
        </form>
        <p style="font-size: 12px; color: #666; margin-top: 15px;">Mọi thông tin được bảo mật. Bạn có thể hủy đăng ký bất cứ lúc nào.</p>
    </section>
    <?php 
include __DIR__ . '/footer.php'; ?>

    
</body>
</html>