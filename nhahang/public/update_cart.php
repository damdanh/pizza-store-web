<?php
// FILE: public/update_cart.php

session_start();
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['id_mon']) || !isset($_POST['action'])) {
    echo json_encode(['success' => false, 'message' => 'Yêu cầu không hợp lệ.']);
    exit;
}

$productId = filter_input(INPUT_POST, 'id_mon', FILTER_VALIDATE_INT);
$action = $_POST['action'];

if (!isset($_SESSION['cart']) || !array_key_exists($productId, $_SESSION['cart'])) {
    echo json_encode(['success' => false, 'message' => 'Sản phẩm không có trong giỏ hàng.']);
    exit;
}

try {
    if ($action === 'plus') {
        $_SESSION['cart'][$productId]['so_luong']++;
    } elseif ($action === 'minus') {
        $_SESSION['cart'][$productId]['so_luong']--;
        
        // Xóa sản phẩm nếu số lượng = 0
        if ($_SESSION['cart'][$productId]['so_luong'] <= 0) {
            unset($_SESSION['cart'][$productId]);
        }
    }

    $totalItems = count($_SESSION['cart']);

    echo json_encode([
        'success' => true, 
        'cart_items' => $_SESSION['cart'], 
        'total_items' => $totalItems
    ]);

} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Lỗi: ' . $e->getMessage()]);
}
?>