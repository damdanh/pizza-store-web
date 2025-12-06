<?php


$base_url_path = '/WD20302-PRO1014_N5/nhahang/'; 
$title = $title ?? 'PIZZA & PASTA - Nhà Hàng Online';
// Xác định trang hiện tại đang ở trang nào để load đúng CSS
$current_page = 'home'; // mặc định

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
    <link rel="stylesheet" href="<?php echo $base_url_path; ?>public/user/css/xacnhandatban.css"> 
    <link rel="stylesheet" href="<?php echo $base_url_path; ?>public/user/css/home.css"> 
    <link rel="stylesheet" href="<?php echo $base_url_path; ?>public/user/css/products.css"> 
    <link rel="stylesheet" href="<?php echo $base_url_path; ?>public/user/css/products_detail.css"> 
    <link rel="stylesheet" href="<?php echo $base_url_path; ?>public/user/css/signin.css"> 
    <link rel="stylesheet" href="<?php echo $base_url_path; ?>public/user/css/login.css">
    <link rel="stylesheet" href="<?php echo $base_url_path; ?>public/user/css/datban.css">
    <link rel="stylesheet" href="<?php echo $base_url_path; ?>public/user/css/sukien.css">
    <link rel="stylesheet" href="<?php echo $base_url_path; ?>public/user/css/baochi.css">
    <link rel="stylesheet" href="<?php echo $base_url_path; ?>public/user/css/chitietdatban.css">
    <link rel="stylesheet" href="<?php echo $base_url_path; ?>public/user/css/contact.css">
    <link rel="stylesheet" href="<?php echo $base_url_path; ?>public/user/css/mondachon.css">








    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <?php if ($current_page === 'chungtoi'): ?>
        <link rel="stylesheet" href="<?php echo $base_url_path; ?>public/user/css/chungtoi.css">
    <?php endif; ?> 
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

</body>
</html> 
    <?php 
  
    include __DIR__ . '/footer.php'; 
    ?>
    <script src="<?php echo $base_url_path; ?>public/cart.js"></script>
    
    </body>
</html>

</body>
</html> 
