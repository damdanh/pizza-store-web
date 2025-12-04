<?php
session_start();
include '../app/config/database.php';
$conn = getConnection();
define('ROOT_PATH', __DIR__ . '/../');
require_once __DIR__ . '/../app/controller/HomeController.php';
require_once __DIR__ . '/../app/controller/AboutController.php';
require_once __DIR__ . '/../app/controller/ContactController.php';
require_once __DIR__ . '/../app/controller/BookingController.php';
require_once __DIR__ . '/../app/controller/EventController.php';
require_once __DIR__ . '/../app/controller/UserController.php';
$request_uri = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
$last = basename($request_uri);
if (
    $request_uri == '' || $last == 'public' || $last == 'index.php'
) 
    $controller = new HomeController();
    $controller->index();


error_reporting(E_ALL);
ini_set('display_errors', 1);

$parts   = explode('/', $request);
$publicIndex = array_search('public', $parts);
$page = '';
if ($publicIndex !== false && isset($parts[$publicIndex + 1])) {
    $page = $parts[$publicIndex + 1];
}
$publicPages = ['', 'home', 'login', 'register', 'signin'];
if (!isset($_SESSION['user_id']) && !in_array($page, $publicPages)) {
    header("Location: /WD20302-PRO1014_N5/nhahang/public/login");

    exit;
}
$path = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');

if ($path === '' || str_ends_with($path, 'index.php') || $path === 'public') {
    (new HomeController())->index();
} 
elseif ($path === 've-chung-toi') {
    (new AboutController())->index();
}
elseif ($path === 'lien-he') {
    (new ContactController())->index();
}
elseif ($path === 'dat-ban') {
    (new BookingController())->showBookingForm();
}
else {
    (new HomeController())->index(); // tạm thời về home
}


http_response_code(404);
echo '<h1>404 Not Found</h1>';

$controller = new UserController();


switch ($page) {
    case '':
    case 'home':
        (new HomeController())->index();
        break;

    case 'login':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $controller->login();
        } else {
            $controller->showLogin();
        }
        break;

    case 'register':
    case 'signin':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $controller->register();
        } else {
            $controller->showRegister();
        }
        break;

    case 'logout':
        $controller->logout();
        break;

    default:
        http_response_code(404);
        echo "<h1>404 Not Found</h1>";
        break;
}

