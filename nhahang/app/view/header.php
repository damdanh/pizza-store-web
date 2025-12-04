

<?php require_once __DIR__ . '/../config/constants.php'; ?>


<!-- view/header.php – bản fix đẹp 100% -->
<?php
$isLoggedIn = isset($_SESSION['user_id']);
$userName   = $_SESSION['user_name'] ?? '';
$firstLetter = $userName ? strtoupper(mb_substr($userName, 0, 1)) : 'U';
?>

<?php require_once __DIR__ . '/../config/constants.php'; ?>

<div class="top-banner">
    <span>NẾU BẠN KHÔNG CÓ SỐ ĐIỆN THOẠI VIỆT NAM, BẠN CÓ THỂ ĐẶT BẠN QUA</span>
    <a href="#">FANPAGE</a>
</div>

<header class="header">
    <div class="header-left">
    <a href="<?= VIEW_URL ?>main.php" style="text-decoration: none; display: flex; align-items: center;">
            <div class="logo">
                <div class="logo-circle"><img src="<?php echo $base_url_path; ?>public/user/img/logo.jpg" alt="Logo Pizza Pasta"></div>
            </div>
            <div class="brand-name">PIZZA &<br>PASTA</div>
        </a>

        <ul class="nav-menu">
                <li><a href="<?= VIEW_URL ?>chungtoi.php">Về Chúng Tôi</a></li>
                <li><a href="<?= VIEW_URL ?>public/index.php">Thực Đơn</a></li>
                <li><a href="<?= VIEW_URL ?>sukien.php">Sự Kiện</a></li>
                <li><a href="<?= VIEW_URL ?>baochi.php">Báo Chí</a></li>
                <li><a href="<?= VIEW_URL ?>datban.php">Đặt Bàn</a></li>
                <li><a href="<?= VIEW_URL ?>contact.php">Liên Hệ</a></li>
    </div>
    
    <!-- <div class="header-right">

        <div class="auth-buttons">
        <a href="<?= VIEW_URL ?>login.php" class="auth-btn">Đăng Nhập</a>
        <a href="<?= VIEW_URL ?>register.php" class="auth-btn">Đăng Ký</a>
        </div> -->

        <?php if ($isLoggedIn): ?>
            <!-- ĐÃ ĐĂNG NHẬP -->
            <div class="user-login-area">
                <div class="user-avatar">
                    <?= htmlspecialchars($firstLetter) ?>
                </div>
                <div class="user-text">
                    <div class="greeting">Xin chào,</div>
                    <div class="username"><?= htmlspecialchars($userName) ?></div>
                </div>
                <a href="<?php echo $base_url_path; ?>public/logout" class="logout-button">
                    Đăng xuất
                </a>
            </div>

        <?php else: ?>
            <!-- CHƯA ĐĂNG NHẬP -->
            <div class="auth-buttons">
                <a href="<?php echo $base_url_path; ?>public/login" class="auth-btn">Đăng Nhập</a>
                <a href="<?php echo $base_url_path; ?>public/signin" class="auth-btn">Đăng Ký</a>
            </div>
        <?php endif; ?>



        <div class="auth-buttons">
        <a href="<?= VIEW_URL ?>login.php" class="auth-btn">Đăng Nhập</a>
        <a href="<?= VIEW_URL ?>register.php" class="auth-btn">Đăng Ký</a>
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
