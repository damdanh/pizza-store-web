<?php
// Biến $base_url_path được truyền từ main.php
$baseURL = '/'; 
?>

<div class="top-banner">
    <span>NẾU BẠN KHÔNG CÓ SỐ ĐIỆN THOẠI VIỆT NAM, BẠN CÓ THỂ ĐẶT BẠN QUA</span>
    <a href="#">FANPAGE</a>
</div>

<header class="header">
    <div class="header-left">
        <a href="<?php echo $base_url_path; ?>public/" style="text-decoration: none;">
            <div class="logo">
                <div class="logo-circle"><img src="<?php echo $base_url_path; ?>public/user/img/logo.jpg" alt="Logo Pizza Pasta"></div>
            </div>
            <div class="brand-name">PIZZA &<br>PASTA</div>
        </a>

        <ul class="nav-menu">
            <li><a href="#about">Về Chúng Tôi</a></li>
            <li><a href="<?php echo $base_url_path; ?>public/">Thực Đơn</a></li>
            <li><a href="#events">Sự Kiện</a></li>
            <li><a href="#news">Báo Chí</a></li>
            <li><a href="#booking">Đặt Bàn</a></li>
            <li><a href="#contact">Liên Hệ</a></li>
        </ul>
    </div>
    
    <div class="header-right">
        <div class="auth-buttons">
            <button class="auth-btn">Đăng Nhập</button>
            <button class="auth-btn">Đăng Ký</button>
        </div>
        <div class="social-icons">
            <a href="#" class="social-icon facebook"><i class="fab fa-facebook-f"></i></a>
            <a href="#" class="social-icon zalo">Z</a>
            <a href="#" class="social-icon phone"><i class="fas fa-phone-alt"></i></a>
        </div>
    </div>
</header>

<div class="sub-header">
    <div class="sub-header-item">Chính sách giao hàng</div>
    <div class="sub-header-item">Chính sách đổi trả hoàn tiền</div>
    <div class="sub-header-item">
        Đường dây nóng: <span class="hotline">19001000</span>
    </div>
</div>