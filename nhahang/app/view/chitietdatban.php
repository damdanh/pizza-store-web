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
    
    <link rel="stylesheet" href="<?php echo $base_url_path; ?>public/user/css/chitietdatban.css">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"> 
</head>
<body>

<section class="booking-container">
        <div class="booking-image"></div>
        
        <div class="booking-form-section">
            <h2>ĐẶT BÀN</h2>
            <div class="booking-date">
                <span>📅 Mon 12, 2025</span>
                <span>👤 7052</span>
                <span>📝</span>
            </div>
            
            <form>
                <div class="form-section">
                    <h3>Chi tiết liên hệ</h3>
                    <p style="font-size: 13px; color: #999; margin-bottom: 20px;">Sở điếm thực</p>
                    
                    <div class="form-group">
                        <label>Tên</label>
                        <input type="text" placeholder="">
                    </div>
                    
                    <div class="form-group">
                        <label>Họ</label>
                        <input type="text" placeholder="">
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" placeholder="">
                        </div>
                        
                        <div class="form-group">
                            <label>Địa chỉ</label>
                            <input type="text" value="+84 (0)">
                        </div>
                    </div>
                </div>
                
                <div class="button-group">
                    <a href="datban.html" class="back-btn">Quay lại</a>
                    <a href="xacnhandatban.html" class="submit-btn">Tiếp tục</a>
                </div>
            </form>
        </div>
    </section>
    <section class="community-section">
    <div class="container">
        <h2>THAM GIA CỘNG ĐỒNG CỦA CHÚNG TÔI</h2>
        <p>Đăng ký để nhận thông tin khuyến mại mới nhất của các Thực Đơn, Ưu Đãi, Tin Tức và các Câu Nhật ký mới nhất của chúng tôi</p>
        <form class="subscribe-form">
            <input type="text" placeholder="Tên">
            <input type="text" placeholder="Họ">
            <input type="email" placeholder="Địa chỉ Email của bạn">
            <button type="submit">ĐĂNG KÝ</button>
        </form>
        <p class="subscribe-note">Mọi thông tin cần tương thành trong Hộp thư sẽ có thông qua đó cho các biên nhân<br>Bạn có thể hủy đăng ký vào bất cứ lúc nào.</p>
    </div>
</section>

</body>
</html>