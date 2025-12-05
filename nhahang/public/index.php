<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Require controllers
require_once '../app/controller/HomeController.php';
require_once '../app/controller/UserController.php';
require_once '../app/controller/BookingController.php';
require_once '../app/controller/AboutController.php';
require_once '../app/controller/AccountController.php';

// Lấy URL hiện tại
$request = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
$parts   = explode('/', $request);
$publicIndex = array_search('public', $parts);
$page = ($publicIndex !== false && isset($parts[$publicIndex + 1])) 
        ? $parts[$publicIndex + 1] 
        : '';

// Các trang không cần login
$publicPages = ['', 'home', 'login', 'register', 'signin', 'index.php'];

// Nếu chưa login và truy cập trang cần bảo vệ
if (!isset($_SESSION['user_id']) && !in_array($page, $publicPages)) {
    header("Location: /WD20302-PRO1014_N5/nhahang/public/login");
    exit;
}
if (strpos($page, 'category.php') === 0 && isset($_GET['id'])) {
    $categoryId = (int)$_GET['id'];
    (new CategoryController())->show($categoryId);
    exit;
}

// Route trang chủ
if ($page === '' || $page === 'home' || $page === 'index.php') {
    (new HomeController())->index();
    exit;
}

// Route account
if ($page === 'account') {
    (new AccountController())->index();
    exit;
}

// Route profile — TẠO THÊM ROUTE NÀY
if ($page === 'profile') {
    (new AccountController())->profile();
    exit;
}

// Route khác
$userController = new UserController();

switch ($page) {

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

    default:
        http_response_code(404);
        echo "<h1>404 Not Found</h1>";
        break;
}
