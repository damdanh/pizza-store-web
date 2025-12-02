<?php
session_start(); 
require_once __DIR__ . '/../app/config/auth_middleware.php';
requireLogin();

include '../app/config/database.php';
$conn = getConnection();


define('ROOT_PATH', __DIR__ . '/../');
require_once ROOT_PATH . 'app/controller/CategoryController.php';


$categoryId = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($categoryId > 0) {
  
    $controller = new CategoryController();
    $controller->show($categoryId);
} else {
   
    header("Location: /WD20302-PRO1014_N5/nhahang/public/");
    exit;
}