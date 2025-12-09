<?php
session_start();

// Kết nối DB
include '../app/config/database.php';
require_once '../app/model/ProductModel.php';

$pdo = getConnection();
$productModel = new ProductModel($pdo);

// Kiểm tra request
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['id_mon'])) {
    echo json_encode(['success' => false, 'message' => 'Yêu cầu không hợp lệ']);
    exit;
}

$id = (int)$_POST['id_mon'];
$soLuong = isset($_POST['so_luong']) ? (int)$_POST['so_luong'] : 1;

// Lấy món từ database
$product = $productModel->getProductById($id);
if (!$product) {
    echo json_encode(['success' => false, 'message' => 'Không tìm thấy món ăn']);
    exit;
}

// Tạo giỏ nếu chưa có
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// KEY QUAN TRỌNG: phải dùng 'id_mon' để khớp với database
if (isset($_SESSION['cart'][$id])) {
    $_SESSION['cart'][$id]['so_luong'] += $soLuong;
} else {
    $_SESSION['cart'][$id] = [
        'id_mon'   => $product['id_mon'],  // ✅ Dùng id_mon từ database
        'ten_mon'  => $product['ten_mon'],
        'gia'      => $product['gia'],
        'so_luong' => $soLuong,
        'hinh_anh' => $product['hinh_anh'],
        'mo_ta'    => $product['mo_ta'] ?? ''
    ];
}

// Trả về JSON thay vì redirect
header('Content-Type: application/json');
echo json_encode([
    'success' => true, 
    'cart_items' => $_SESSION['cart'],
    'total_items' => count($_SESSION['cart'])
]);
exit;