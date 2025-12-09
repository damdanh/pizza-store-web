
<!-- view/header.php – bản fix đẹp 100% -->
<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
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
                <li><a href="<?php echo $base_url_path; ?>public/">Trang chủ</a></li>
                <li><a href="<?= $base_url_path ?>public/chung-toi">Về Chúng Tôi</a></li>
                <li><a href="<?= $base_url_path ?>public/su-kien">Sự Kiện</a></li>
                <li><a href="<?= $base_url_path ?>public/bao-chi">Báo Chí</a></li>
                <li><a href="<?php echo $base_url_path; ?>public/category.php?id=1">Thực Đơn</a></li>
                <li><a href="<?= $base_url_path ?>public/lien-he">Liên Hệ</a></li>
                <li><a href="<?php echo $base_url_path; ?>public/dat-ban">Đặt Bàn</a></li>
              
        </ul>
    </div>
    
    <div class="header-right">

        <?php if ($isLoggedIn): ?>
            <!-- ĐÃ ĐĂNG NHẬP -->
            <div class="user-login-area">
              <div class="user-avatar open-profile">
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
                <a href="<?php echo $base_url_path; ?>public/signin" class="auth-btn signup">Đăng Ký</a>
            </div>
        <?php endif; ?>


   

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
<div class="profile-popup" id="profilePopup">
    <div class="popup-content">

        <span class="close-popup" id="closeProfile">&times;</span>

        <div class="profile-header" style="background:#8B6F47;">
            <div class="profile-avatar-big">
                <?= htmlspecialchars($firstLetter) ?>
            </div>
            <h2 style="margin-top:10px;"><?= htmlspecialchars($userName) ?></h2>
        </div>

        <div class="profile-body" style="padding:25px;">
            <p><strong>Tên tài khoản:</strong> <?= htmlspecialchars($userName) ?></p>
            <p><strong>Email:</strong> <?= $_SESSION['email'] ?? 'Chưa cập nhật' ?></p>
            <p><strong>Số điện thoại:</strong> <?= $_SESSION['phone'] ?? 'Chưa cập nhật' ?></p>

        <a href="<?php echo $base_url_path; ?>public/account"
        style="display:block; margin-top:20px; background:#8B6F47; padding:12px; 
        text-align:center; color:white; text-decoration:none; border-radius:10px;">
        Xem hồ sơ chi tiết
          </a>
        </div>
    </div>
</div>
<script>
document.addEventListener("DOMContentLoaded", function () {
    const popup = document.getElementById("profilePopup");
    const openBtn = document.querySelector(".open-profile");
    const closeBtn = document.getElementById("closeProfile");

    if (openBtn) {
        openBtn.addEventListener("click", () => {
            popup.style.display = "block";
        });
    }

    if (closeBtn) {
        closeBtn.addEventListener("click", () => {
            popup.style.display = "none";
        });
    }

    // Click bên ngoài để đóng
    window.addEventListener("click", (e) => {
        if (e.target === popup) popup.style.display = "none";
    });
});
</script>

