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

    <link rel="stylesheet" href="<?php echo $base_url_path; ?>public/user/css/mondachon.css"> 

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"> 
</head>
<body>
    
    <section class="booking-container">
        <div class="menu-selection">
            <div class="menu-section">
                <h3>Đã chọn</h3>
                <div class="menu-items-grid">
                    <div class="menu-card">
                        <div class="menu-card-image" style="background-image: url('https://images.unsplash.com/photo-1572695157366-5e585ab2b69f?w=300')"></div>
                        <div class="menu-card-info">
                            <h4>Truffle Pesto</h4>
                        </div>
                    </div>
                    <div class="menu-card">
                        <div class="menu-card-image" style="background-image: url('https://images.unsplash.com/photo-1565299624946-b28f40a0ae38?w=300')"></div>
                        <div class="menu-card-info">
                            <h4>Crispy Family</h4>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="menu-section">
                <h3>Đã chọn</h3>
                <div class="menu-items-grid">
                    <div class="menu-card">
                        <div class="menu-card-image" style="background-image: url('https://images.unsplash.com/photo-1565299624946-b28f40a0ae38?w=300')"></div>
                        <div class="menu-card-info">
                            <h4>Crispy Family</h4>
                        </div>
                    </div>
                    <div class="menu-card">
                        <div class="menu-card-image" style="background-image: url('https://images.unsplash.com/photo-1623428187969-5da2dcea5ebf?w=300')"></div>
                        <div class="menu-card-info">
                            <h4>Stone Pizza</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="booking-info-section">
            <h2>ĐẶT BÀN</h2>
            
            <div class="info-item">
                <span class="info-label">Xác nhận thông tin chi tiết của bạn</span>
            </div>
            
            <div class="info-item">
                <span class="info-label">Cho bằng: BOM - Kitchen & Wine Bar</span>
            </div>
            
            <div class="info-item">
                <span class="info-label">Số lượng người: 2</span>
            </div>
            
            <div class="info-item">
                <span class="info-label">Ngày: Nov. 14, 2025 10:00 PM</span>
            </div>
            
            <div class="info-item">
                <span class="info-label">Số điện thoại: +84235054800</span>
            </div>
            
            <div class="info-item">
                <span class="info-label">Tên: Sở Tài Mặc</span>
            </div>
            
            <div class="info-item">
                <span class="info-label">Email: tientiet19@gmail.com</span>
            </div>
            
            <div class="info-item" style="border: none;">
                <span class="info-label">Notes:</span>
            </div>
            
            <div class="button-group">
                <button class="back-btn">Quay lại</button>
                <button class="submit-btn">Xác nhận</button>
            </div>
        </div>
    </section>

    <section class="community-section">
        <h2>THAM GIA CỘNG ĐỒNG CỦA CHÚNG TÔI</h2>
        <p style="color: #666; margin-bottom: 30px;">Đăng ký để nhận thông tin mới nhất về Thực Đơn, Ưu Đãi và Sự Kiện</p>
        <form class="subscribe-form">
            <input type="text" placeholder="Tên">
            <input type="text" placeholder="Họ">
            <input type="email" placeholder="Địa chỉ Email">
            <button>ĐĂNG KÝ</button>
        </form>
        <p style="font-size: 12px; color: #666; margin-top: 15px;">Mọi thông tin được bảo mật. Hủy đăng ký bất cứ lúc nào.</p>
    </section>
