<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);


// KHAI BÁO BIẾN CHUNG
$GLOBALS['base_url_path'] = "/WD20302-PRO1014_N5/nhahang/public/";

// Cấu hình
require_once __DIR__ . '/../app/config/constants.php';
require_once __DIR__ . '/../app/config/database.php';

$conn = getConnection();

// ROOT_PATH chỉ define nếu chưa có
if (!defined('ROOT_PATH')) {
    define('ROOT_PATH', realpath(__DIR__ . '/../') . DIRECTORY_SEPARATOR);
}

// Load controllers
require_once ROOT_PATH . 'app/controller/HomeController.php';
require_once ROOT_PATH . 'app/controller/AboutController.php';
require_once ROOT_PATH . 'app/controller/ContactController.php';
require_once ROOT_PATH . 'app/controller/BookingController.php';
require_once ROOT_PATH . 'app/controller/EventController.php';
require_once ROOT_PATH . 'app/controller/UserController.php';
require_once ROOT_PATH . 'app/controller/CategoryController.php';
require_once ROOT_PATH . 'app/controller/BlogController.php';
require_once ROOT_PATH . 'app/controller/AccountController.php';


// -----------------------------------------
// XỬ LÝ URL
// -----------------------------------------

$request = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');

// Tách theo thư mục để lấy phần route cuối cùng
$segments = explode('/', $request);
$route = end($segments);   // ví dụ: login, home, ve-chung-toi

// Danh sách không cần login
// ĐÃ THÊM: forgot_password, verify_reset_code, reset_password
$publicPages = ['','home','login','register','signin', 'forgot_password', 'verify_reset_code', 'reset_password'];

// Nếu chưa login mà truy cập trang cần login
if (!isset($_SESSION['user_id']) && !in_array($route, $publicPages)) {
    header("Location: /WD20302-PRO1014_N5/nhahang/public/login");
    exit;
}

// Khởi tạo UserController chỉ một lần
$userController = new UserController();

switch ($route) {
    case '':
    case 'home':
    case 'public':
    case 'index.php':
        (new HomeController())->index();
        exit;

    case 'chung-toi':
        (new AboutController())->index();
        exit;

    case 'su-kien':
        (new EventController())->index();
        exit;

    case 'bao-chi':
        (new BlogController())->index();
        exit;

    case 'dat-ban':
        (new BookingController())->showBookingForm();
        exit;
            
    case 'xac-nhan':
        (new BookingController())->showConfirmation();
        break;

    case 'lien-he':
        (new ContactController())->index();
        exit;

    case 'booking_info':
        require_once __DIR__ . '/booking_info.php';
        exit;
    
    case 'xac-nhan':
        require_once __DIR__ . '/xacnhan.php';
        exit;
        
    case 'process_booking.php':
        require_once __DIR__ . '/process_booking.php';
        exit;
        
    // ==========================================
    // CÁC ROUTE QUÊN VÀ CẬP NHẬT MẬT KHẨU
    // ==========================================
    case 'forgot_password':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Xử lý gửi mã xác nhận (sendResetCode)
            $userController->sendResetCode();
        } else {
            // Hiển thị form nhập email (showForgotPassword)
            $userController->showForgotPassword();
        }
        exit;

    case 'verify_reset_code':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Xử lý xác nhận mã code (verifyResetCode)
            $userController->verifyResetCode();
        } else {
            // Hiển thị form nhập mã code (showVerifyCode)
            $userController->showVerifyCode();
        }
        exit;

    case 'reset_password':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Xử lý cập nhật mật khẩu (resetPassword)
            $userController->resetPassword();
        } else {
            // Hiển thị form cập nhật mật khẩu (showResetPassword)
            $userController->showResetPassword();
        }
        exit;
    // ==========================================

    case 'login':
        // Sử dụng $userController đã khởi tạo
        if ($_SERVER['REQUEST_METHOD'] === 'POST') $userController->login();
        else $userController->showLogin();
        exit;

    case 'register':
    case 'signin':
        // Sử dụng $userController đã khởi tạo
        if ($_SERVER['REQUEST_METHOD'] === 'POST') $userController->register();
        else $userController->showRegister();
        exit;

    case 'logout':
        $userController->logout();
        exit;

    case 'account': 
        (new AccountController())->index();
        exit;
    case 'dang-cho-xu-ly':
        (new BookingController())->showProcessingPage();
            exit;

    default:
      
        if (count($segments) >= 2 && $segments[count($segments)-2] === 'danh-muc') {
            (new CategoryController())->show((int)$route);
            exit;
        }

        http_response_code(404);
        echo "<h1>404 Not Found</h1>";
        exit;

}
// Dấu đóng của file php nếu có (phải được xóa theo logic MVC chuẩn)
// }