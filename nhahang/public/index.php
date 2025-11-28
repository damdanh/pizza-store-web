<?php
include '../app/config/database.php';
define('ROOT_PATH', __DIR__ . '/../');
require_once ROOT_PATH . 'app/controller/HomeController.php';
$request_uri = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
$last = basename($request_uri);
if (
    $request_uri == '' ||
    $last == 'public' ||
    $last == 'index.php'
) {
    $controller = new HomeController();
    $controller->index();
    exit;
}

http_response_code(404);
echo '<h1>404 Not Found</h1>';
