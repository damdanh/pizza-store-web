<?php
// Bắt đầu session ở đầu file (Quan trọng)
session_start(); 
include "../app/controller/AdminController.php";
$controller = new AdminController();
// Controller và View cho trang Login không cần header/sidebar/footer admin
$page = $_GET['page'] ?? null;
$action = $_GET['action'] ?? null;

// ==========================================================
// 1A. Xử lý logic ĐĂNG XUẤT (NEW)
// ==========================================================
if ($action === 'logout') {
    $controller->logout();
    exit; 
}



// ==========================================================
// 1. Xử lý logic ĐĂNG NHẬP / KIỂM TRA ĐĂNG NHẬP
// ==========================================================

// A. Nếu là action 'login_process' (Xử lý POST form đăng nhập)
if ($action === 'login_process') {
    // Không cần kiểm tra session, chỉ cần gọi hàm xử lý
    $controller->login_process();
    // Hàm này sẽ tự chuyển hướng sau khi xử lý thành công/thất bại
    exit; 
}

// B. Kiểm tra xem Admin đã đăng nhập chưa (Kiểm tra $_SESSION['admin'])
if (!isset($_SESSION['admin'])) {
    // Nếu chưa đăng nhập:
    
    // Nếu người dùng truy cập bất kỳ trang nào khác: chuyển về form login
    if ($action !== 'login' && $page !== null) { 
        header('location: admin.php?action=login');
        exit;
    }
    
    // HIỂN THỊ FORM ĐĂNG NHẬP (ĐÃ CẬP NHẬT ĐƯỜNG DẪN)
    // Đường dẫn tương đối từ public/ ra ngoài (../) rồi vào app/view/admin/
    include "../app/view/admin/login.php"; // <--- ĐÃ SỬA TẠI ĐÂY
    exit; 
}

// ==========================================================
// 2. Logic dành cho ADMIN ĐÃ ĐĂNG NHẬP
// ==========================================================

// Nếu đã đăng nhập, bao gồm header/sidebar/footer cho trang Admin
include "../app/view/admin/views/layouts/header.php";
include "../app/view/admin/views/layouts/sidebar.php";

// Kiểm tra trang và gọi controller (như code cũ của bạn)
if (!isset($_GET['page']) || empty($_GET['page'])){
    // Sau khi đăng nhập thành công, nếu không có page, chuyển về dashboard
    header('location: admin.php?page=dashboard');
    exit;
}else{
    $page = $_GET['page'];
    
    // Kiểm tra xem phương thức có tồn tại trong controller không
    if (method_exists($controller, $page)) {
        $controller->$page();
    } else {
        // Xử lý lỗi 404 hoặc trang không tồn tại
        echo "<h1>404 Page Not Found</h1>";
        // Có thể include view lỗi 404
    }
}

include "../app/view/admin/views/layouts/footer.php";
?>