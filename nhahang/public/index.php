<?php

session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once '../app/controller/HomeController.php';
require_once '../app/controller/UserController.php';
$request = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
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