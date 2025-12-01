<?php
// admin.php (Đã sửa - Tệp Điều hướng Chính)

// Bắt đầu Output Buffering để tránh lỗi header() nếu có khoảng trắng vô ý
ob_start(); 

// Định nghĩa thư mục gốc của dự án để đảm bảo đường dẫn luôn đúng
define('PROJECT_ROOT', __DIR__);

// 1. Nhúng Controller
require_once PROJECT_ROOT . "/app/controller/AdminController.php"; 

// 2. Khởi tạo Controller
$controller = new AdminController();

// 3. Xử lý Chuyển hướng Mặc định (Phải làm trước khi có bất kỳ Output nào)
$page = $_GET['page'] ?? null; 
if ($page === null) {
    // Nếu không có tham số 'page', chuyển hướng về trang chủ
    header('Location: admin.php?page=home');
    ob_end_flush(); // Kết thúc buffering và gửi đầu ra
    exit();
}

// 4. Kiểm tra và thực thi phương thức Controller
if (method_exists($controller, $page)) {
    // Gọi phương thức tương ứng. Phương thức này sẽ gọi renderAdmin() và tải Layout
    $controller->$page(); 
} else {
    // Xử lý trang không tìm thấy (404)
    header("HTTP/1.0 404 Not Found");
    // Có thể render một View 404 đẹp hơn tại đây
    echo "<h1>Lỗi 404</h1><p>Trang quản trị không tìm thấy.</p>";
}

// Kết thúc Output Buffering nếu chưa được kết thúc ở đâu đó
if (ob_get_level() > 0) {
    ob_end_flush();
}
?>