<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Require các controller cần thiết
require_once '../app/controller/HomeController.php';
require_once '../app/controller/UserController.php';
require_once '../app/controller/BookingController.php';
require_once '../app/controller/AboutController.php';

// Lấy page từ URL
$request = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
$parts   = explode('/', $request);
$publicIndex = array_search('public', $parts);
$page = ($publicIndex !== false && isset($parts[$publicIndex + 1])) ? $parts[$publicIndex + 1] : '';

// Trang công khai không cần login
$publicPages = ['', 'home', 'login', 'register', 'signin'];

// Nếu chưa login và không phải trang công khai → chuyển về login
if (!isset($_SESSION['user_id']) && !in_array($page, $publicPages)) {
    header("Location: /WD20302-PRO1014_N5/nhahang/public/login");
    exit;
}

// Trang chủ
if ($page === '' || $page === 'home' || $page === 'index.php') {
    (new HomeController())->index();
    exit;
}

// Xử lý các page khác
switch ($page) {
    case 'login':
        $controller = new UserController();
        $_SERVER['REQUEST_METHOD'] === 'POST' ? $controller->login() : $controller->showLogin();
        break;

    case 'register':
    case 'signin':
        $controller = new UserController();
        $_SERVER['REQUEST_METHOD'] === 'POST' ? $controller->register() : $controller->showRegister();
        break;

    case 'logout':
        $controller = new UserController();
        $controller->logout();
        break;

    default:
        http_response_code(404);
        echo "<h1>404 Not Found</h1>";
        break;
}