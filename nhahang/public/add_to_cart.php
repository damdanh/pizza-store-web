<?php
// FILE: public/add_to_cart.php

// 1. Khởi động Session
session_start();

// 2. Thiết lập Header để trả về JSON
header('Content-Type: application/json');

// Yêu cầu Model và Database (cần thiết để lấy giá và tên chính xác)
include '../app/config/database.php';
require_once '../app/model/ProductModel.php';
$conn = getConnection(); // Lấy kết nối database

// Kiểm tra phương thức và dữ liệu
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['id_mon'])) {
    echo json_encode(['success' => false, 'message' => 'Yêu cầu không hợp lệ.']);
    exit;
}

$productId = filter_input(INPUT_POST, 'id_mon', FILTER_VALIDATE_INT);
$quantity = 1; // Mặc định thêm 1 sản phẩm

try {
    $productModel = new ProductModel();
    // Lấy thông tin chi tiết sản phẩm từ database
    $product = $productModel->getProductById($productId);

    if (!$product) {
        echo json_encode(['success' => false, 'message' => 'Sản phẩm không tồn tại.']);
        exit;
    }

    // 3. Khởi tạo giỏ hàng nếu chưa có
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // 4. Cập nhật hoặc thêm sản phẩm vào Session
    if (array_key_exists($productId, $_SESSION['cart'])) {
        $_SESSION['cart'][$productId]['so_luong'] += $quantity;
    } else {
        $_SESSION['cart'][$productId] = [
            'id_mon' => $productId,
            'ten_mon' => $product['ten_mon'],
            'gia' => $product['gia'],
            'hinh_anh' => $product['hinh_anh'],
            'mo_ta' => $product['mo_ta'],
            'so_luong' => $quantity,
        ];
    }
    
    // 5. Tính tổng số lượng item trong giỏ hàng (để cập nhật UI)
    $totalItems = count($_SESSION['cart']);

    echo json_encode(['success' => true, 'cart_items' => $_SESSION['cart'], 'total_items' => $totalItems]);

} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Lỗi server: ' . $e->getMessage()]);
}
?>