<?php
include '../app/config/database.php';
$conn = getConnection();
define('ROOT_PATH', __DIR__ . '/../');
require_once __DIR__ . '/../app/controller/HomeController.php';
require_once __DIR__ . '/../app/controller/AboutController.php';
require_once __DIR__ . '/../app/controller/ContactController.php';
require_once __DIR__ . '/../app/controller/BookingController.php';
require_once __DIR__ . '/../app/controller/EventController.php';
$request_uri = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
$last = basename($request_uri);
if (
    $request_uri == '' || $last == 'public' || $last == 'index.php'
) {
    $controller = new HomeController();
    $controller->index();
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