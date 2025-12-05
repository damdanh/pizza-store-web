<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
session_start();

// Include các controller
require_once '../app/controller/HomeController.php';
require_once '../app/controller/UserController.php';
require_once '../app/controller/BookingController.php';
require_once '../app/controller/AboutController.php';
require_once '../app/controller/AccountController.php';
require_once '../app/controller/ContactController.php';
require_once '../app/controller/EventController.php';
require_once '../app/controller/CategoryController.php';
require_once '../app/controller/BaoChiController.php';

// Lấy đường dẫn từ URL
$request = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
$parts   = explode('/', $request);
$publicIndex = array_search('public', $parts);
$page = ($publicIndex !== false && isset($parts[$publicIndex + 1])) 
        ? $parts[$publicIndex + 1] 
        : '';

// Các trang công khai không cần đăng nhập
$publicPages = [
    '', 
    'home', 
    'login', 
    'register', 
    'signin', 
    'index.php', 
    'forgot_password', 
    'verify_reset_code', 
    'reset_password',
    'contact',
    'chungtoi',
    'about',
    'sukien',
    'event',
    'datban',
    'booking',
    'baochi',
    'category'
];

// Kiểm tra đăng nhập cho các trang yêu cầu
if (!isset($_SESSION['user_id']) && !in_array($page, $publicPages)) {
    $_SESSION['redirect_after_login'] = $_SERVER['REQUEST_URI'];
    header("Location: /WD20302-PRO1014_N5/nhahang/public/login");
    exit;
}

// Xử lý category với ID
if ($page === 'category' && isset($_GET['id'])) {
    $categoryId = (int)$_GET['id'];
    (new CategoryController())->show($categoryId);
    exit;
}

// Routing chính
$userController = new UserController();

switch ($page) {
    
    // ============ TRANG CHỦ ============
    case '':
    case 'home':
    case 'index.php':
        (new HomeController())->index();
        break;

    // ============ TÀI KHOẢN ============
    case 'account':
    case 'profile':
        (new AccountController())->index();
        break;

    // ============ ĐĂNG NHẬP/ĐĂNG KÝ ============
    case 'login':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userController->login();
        } else {
            $userController->showLogin();
        }
        break;

    case 'register':
    case 'signin':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userController->register();
        } else {
            $userController->showRegister();
        }
        break;

    case 'logout':
        $userController->logout();
        break;

    // ============ QUÊN MẬT KHẨU ============
    case 'forgot_password':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userController->sendResetCode();
        } else {
            $userController->showForgotPassword();
        }
        break;

    case 'verify_reset_code':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userController->verifyResetCode();
        } else {
            $userController->showVerifyCode();
        }
        break;

    case 'reset_password':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userController->resetPassword();
        } else {
            $userController->showResetPassword();
        }
        break;

    // ============ CÁC TRANG TĨNH ============
    case 'contact':
        (new ContactController())->index();
        break;

    case 'chungtoi':
    case 'about':
        (new AboutController())->index();
        break;

    case 'sukien':
    case 'event':
        (new EventController())->index();
        break;

    // ============ ĐẶT BÀN ============
    case 'datban':
    case 'booking':
        $bookingController = new BookingController();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $bookingController->processConfirmation();
        } else {
            $bookingController->showBookingForm();
        }
        break;

    case 'chitietdatban':
        // Hiển thị trang chi tiết đặt bàn
        $data = [
            'title' => 'Chi Tiết Đặt Bàn - PIZZA & PASTA',
            'base_url_path' => '/WD20302-PRO1014_N5/nhahang/'
        ];
        extract($data);
        include __DIR__ . '/../app/view/chitietdatban.php';
        break;

    case 'xacnhandatban':
        // Hiển thị xác nhận đặt bàn
        include __DIR__ . '/../app/view/xacnhandatban.php';
        break;

    // ============ BÁO CHÍ ============
    case 'baochi':
        (new BaoChiController())->index();
        break;

    // ============ 404 NOT FOUND ============
    default:
        http_response_code(404);
        echo "<h1 style='text-align:center; margin-top:100px;'>404 - Trang không tồn tại</h1>";
        echo "<p style='text-align:center;'><a href='/WD20302-PRO1014_N5/nhahang/public/'>Quay về trang chủ</a></p>";
        break;
}