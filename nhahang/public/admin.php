<?php
define('BASE_URL', 'http://localhost/nhahang');
$ROOT = dirname(__DIR__); 

$pageTitle = "Quản lý Admin"; 
$activePage = "admin"; 

// SỬ DỤNG ĐƯỜNG DẪN TUYỆT ĐỐI BẰNG CÁCH NỐI CHUỖI
require_once $ROOT . '/app/view/admin/views/layouts/header.php'; 
require_once $ROOT . '/app/view/admin/views/layouts/sidebar.php';
?>

<main class="main-content">
    </main>

<?php 
require_once $ROOT . '/app/view/admin/views/layouts/footer.php'; 
?>