<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);


require_once '../app/controller/HomeController.php';
require_once '../app/controller/UserController.php';
require_once '../app/controller/BookingController.php';
require_once '../app/controller/AboutController.php';
require_once '../app/controller/AccountController.php';


$request = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
$parts   = explode('/', $request);
$publicIndex = array_search('public', $parts);
$page = ($publicIndex !== false && isset($parts[$publicIndex + 1])) 
        ? $parts[$publicIndex + 1] 
        : '';


$publicPages = ['', 'home', 'login', 'register', 'signin', 'index.php', 'forgot_password', 'verify_reset_code', 'reset_password'];

if (!isset($_SESSION['user_id']) && !in_array($page, $publicPages)) {
    header("Location: /WD20302-PRO1014_N5/nhahang/public/login");
    exit;
}
if (strpos($page, 'category.php') === 0 && isset($_GET['id'])) {
    $categoryId = (int)$_GET['id'];
    (new CategoryController())->show($categoryId);
    exit;
}


if ($page === '' || $page === 'home' || $page === 'index.php') {
    (new HomeController())->index();
    exit;
}

if ($page === 'account') {
    (new AccountController())->index();
    exit;
}

if ($page === 'profile') {
    (new AccountController())->profile();
    exit;
}


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

    default:
        http_response_code(404);
        echo "<h1>404 Not Found</h1>";
        break;
}
