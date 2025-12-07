<?php
ob_start();

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include "../app/controller/AdminController.php";
$controller = new AdminController();

// --- BƯỚC 1: Xử lý Đăng xuất (Logout) ---
if (isset($_GET['action']) && $_GET['action'] == 'logout') {
    $controller->logout();
    // Chuyển hướng về router chính để hiển thị form login
    header('location: admin.php'); 
    exit();
}

// --- BƯỚC 2: Kiểm tra Đăng nhập & Hiển thị Form ---
if (!isset($_SESSION['admin'])) {
    if (isset($_GET['action']) && $_GET['action'] == 'login_process') {
       $controller->login_process(); 
        
    } else {
        // Tránh lỗi 404: INCLUDE form login
        include '../app/view/admin/login.php'; 
        exit();
    }
}

// Nếu đã đăng nhập, tiếp tục xử lý các trang quản trị bên dưới
// --- BƯỚC 3: Hiển thị Trang Admin (Chỉ khi đã đăng nhập) ---
include "../app/view/admin/views/layouts/header.php";
include "../app/view/admin/views/layouts/sidebar.php";

if (!isset($_GET['page']) || $_GET['page'] == 'dashboard'){
        $controller->dashboard(); 
} else {
    $page = $_GET['page'];
    if (method_exists($controller, $page)) {
        $controller->$page();
    } else {
        $controller->dashboard();
    }
}

include "../app/view/admin/views/layouts/footer.php";
?>