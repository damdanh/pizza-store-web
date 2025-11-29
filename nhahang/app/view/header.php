<?php
// File: /app/view/layout/header.php (Phần đầu trang)
$baseURL = '/'; // Đường dẫn gốc của website (cần thiết lập qua Router)
?>
 <!-- Header -->
    <header class="header">
        <div class="top-banner">
            NẾU BẠN KHÔNG CÓ SỐ ĐIỆN THOẠI VIỆT NAM, BẠN CÓ THỂ ĐẶT BẠN QUA <a href="#">FANPAGE</a>
        </div>
        <nav class="nav-bar">
            <div class="logo">
                <div class="logo-circle"><img src="<?php echo $base_url_path; ?>public/user/img/logo.jpg" alt="Logo Pizza Pasta"></div>
                <div class="logo-text">
                    <h2>PIZZA &<br>PASTA</h2>
                </div>
            </div>
            <ul class="nav-menu">
                <li><a href="#home">Về Chúng Tôi</a></li>
                <li><a href="#menu">Thực Đơn</a></li>
                <li><a href="#events">Sự Kiện</a></li>
                <li><a href="#news">Báo Chí</a></li>
                <li><a href="#booking">Đặt Bàn</a></li>
                <li><a href="#contact">Liên Hệ</a></li>
            </ul>
            <div class="nav-right">
                <div class="auth-links">
                   <button class="auth-btn">Đăng Nhập</button>
                    <button class="auth-btn">Đăng Ký</button>
                </div>
                <div class="social-icons">
                    <a href="#" class="social-icon facebook">f</a>
                    <a href="#" class="social-icon zalo">Z</a>
                    <a href="#" class="social-icon phone">📞</a>
                </div>
                
            </div>
        </nav>
        <div class="submenu">
            <div class="policy-item">Chính sách giao hàng</div>
            <div class="policy-item">Chính sách đổi trả hoàn tiền</div>
            <div class="hotline">Đường dây nóng: 19001000</div>
        </div>
    </header>