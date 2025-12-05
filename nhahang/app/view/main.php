<?php
// app/view/main.php

$base_url_path = '/WD20302-PRO1014_N5/nhahang/'; 
$title = $title ?? 'PIZZA & PASTA - Nhà Hàng Online';

$current_page = 'home';

// Logic lấy tên trang hiện tại từ biến Controller truyền vào
if (isset($content_view)) {
    $current_page = basename($content_view, '.php');
} elseif (isset($_GET['page'])) {
    $current_page = $_GET['page'];
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <title><?php echo htmlspecialchars($title); ?></title>

    <!-- CSS chung -->
    <link rel="stylesheet" href="<?php echo $base_url_path; ?>public/user/css/contact.css"> 
    <link rel="stylesheet" href="<?php echo $base_url_path; ?>public/user/css/home.css"> 
    <link rel="stylesheet" href="<?php echo $base_url_path; ?>public/user/css/products.css"> 
    <link rel="stylesheet" href="<?php echo $base_url_path; ?>public/user/css/products_detail.css"> 

    <!-- CSS cho trang đăng nhập/đăng ký -->
    <?php if (in_array($current_page, ['login', 'register', 'signin', 'forgot_password_email', 'verify_email', 'reset_password'])): ?>
        <link rel="stylesheet" href="<?php echo $base_url_path; ?>public/user/css/signin.css"> 
        <link rel="stylesheet" href="<?php echo $base_url_path; ?>public/user/css/login.css">
    <?php endif; ?>
   
    <!-- CSS cho trang Chúng tôi -->
    <?php if ($current_page === 'chungtoi'): ?>
        <link rel="stylesheet" href="<?php echo $base_url_path; ?>public/user/css/chungtoi.css">
    <?php endif; ?> 
    
    <!-- CSS cho trang Profile -->
    <?php if ($current_page === 'profile'): ?>
        <link rel="stylesheet" href="<?php echo $base_url_path; ?>public/user/css/profile.css">
    <?php endif; ?> 

    <!-- CSS cho trang Báo chí -->
    <?php if ($current_page === 'baochi'): ?>
        <link rel="stylesheet" href="<?php echo $base_url_path; ?>public/user/css/baochi.css">
    <?php endif; ?>

    <!-- CSS cho trang Sự kiện -->
    <?php if ($current_page === 'sukien'): ?>
        <link rel="stylesheet" href="<?php echo $base_url_path; ?>public/user/css/sukien.css">
    <?php endif; ?>

    <!-- CSS cho trang Đặt bàn -->
    <?php if (in_array($current_page, ['datban', 'chitietdatban', 'xacnhandatban'])): ?>
        <link rel="stylesheet" href="<?php echo $base_url_path; ?>public/user/css/datban.css">
        <link rel="stylesheet" href="<?php echo $base_url_path; ?>public/user/css/chitietdatban.css">
        <link rel="stylesheet" href="<?php echo $base_url_path; ?>public/user/css/xacnhandatban.css">
    <?php endif; ?>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

<?php 
// Include header
include __DIR__ . '/header.php'; 
?>

<main>
    <?php 
    if (isset($content_view) && file_exists($content_view)) {
        include $content_view;
    } else {
        echo '<h1 style="text-align:center; padding:100px;">404 - Trang không tồn tại</h1>';
    }
    ?>
</main>

<?php 
// Include footer
include __DIR__ . '/footer.php'; 
?>

<script src="<?php echo $base_url_path; ?>public/cart.js"></script>

</body>
</html>