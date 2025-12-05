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




// -----------------------------------------
// XỬ LÝ URL
// -----------------------------------------

$request = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');

// Tách theo thư mục để lấy phần route cuối cùng
$segments = explode('/', $request);
$route = end($segments);   // ví dụ: login, home, ve-chung-toi

// Danh sách không cần login
$publicPages = ['','home','login','register','signin'];

// Nếu chưa login mà truy cập trang cần login
if (!isset($_SESSION['user_id']) && !in_array($route, $publicPages)) {
    header("Location: /WD20302-PRO1014_N5/nhahang/public/login");
    exit;
}

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

    

    case 'login':
        $c = new UserController();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') $c->login();
        else $c->showLogin();
        exit;

    case 'register':
    case 'signin':
        $c = new UserController();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') $c->register();
        else $c->showRegister();
        exit;

    case 'logout':
        (new UserController())->logout();
        exit;

    default:
        // danh-muc/12
        if (count($segments) >= 2 && $segments[count($segments)-2] === 'danh-muc') {
            (new CategoryController())->show((int)$route);
            exit;
        }

        http_response_code(404);
        echo "<h1>404 Not Found</h1>";
        exit;
}
