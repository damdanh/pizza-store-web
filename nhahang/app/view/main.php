<?php

$base_url_path = '/WD20302-PRO1014_N5/nhahang/'; 
$title = $title ?? 'PIZZA & PASTA - Nhà Hàng Online';

$current_page = 'home';

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

    <link rel="stylesheet" href="<?php echo $base_url_path; ?>public/user/css/contact.css"> 
    <link rel="stylesheet" href="<?php echo $base_url_path; ?>public/user/css/home.css"> 
    <link rel="stylesheet" href="<?php echo $base_url_path; ?>public/user/css/products.css"> 
    <link rel="stylesheet" href="<?php echo $base_url_path; ?>public/user/css/products_detail.css"> 
    <link rel="stylesheet" href="<?php echo $base_url_path; ?>public/user/css/signin.css"> 
    <link rel="stylesheet" href="<?php echo $base_url_path; ?>public/user/css/login.css">
   

    <?php if ($current_page === 'chungtoi'): ?>
        <link rel="stylesheet" href="<?php echo $base_url_path; ?>public/user/css/chungtoi.css">
    <?php endif; ?> 

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

<?php include __DIR__ . '/header.php'; ?>

<main>
    <?php 
    if (isset($content_view) && file_exists($content_view)) {
        include $content_view;
    } else {
        echo '<h1 style="text-align:center; padding:100px;">404 - Trang không tồn tại</h1>';
    }
    ?>
</main>

<?php include __DIR__ . '/footer.php'; ?>

<script src="<?php echo $base_url_path; ?>public/cart.js"></script>

</body>
</html>
