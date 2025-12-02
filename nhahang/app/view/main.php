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
    
    <link rel="stylesheet" href="<?php echo $base_url_path; ?>public/user/css/home.css"> 
    <link rel="stylesheet" href="<?php echo $base_url_path; ?>public/user/css/products.css"> 
    <link rel="stylesheet" href="<?php echo $base_url_path; ?>public/user/css/products_detail.css"> 
    <link rel="stylesheet" href="<?php echo $base_url_path; ?>public/user/css/signin.css"> 
    <link rel="stylesheet" href="<?php echo $base_url_path; ?>public/user/css/login.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"> 
</head>
<body>
    
    <?php 

    include __DIR__ . '/header.php'; 
    ?>

    <main>
        <?php 
        
        if (isset($content_view) && file_exists($content_view)) {
    
            include $content_view; 
        } else {
          
            echo '<div style="padding: 50px; text-align: center;"><h1>Lỗi tải trang!</h1><p>Không tìm thấy nội dung chính để hiển thị.</p></div>';
        }
        ?>
    </main>

    <?php 
  
    include __DIR__ . '/footer.php'; 
    ?>
    <script src="<?php echo $base_url_path; ?>public/cart.js"></script>
    
    </body>
</html>