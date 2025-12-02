<?php


session_start();
header('Content-Type: application/json');

try {
    $cartItems = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
    $totalItems = count($cartItems);

    echo json_encode([
        'success' => true, 
        'cart_items' => $cartItems, 
        'total_items' => $totalItems
    ]);

} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Lỗi: ' . $e->getMessage()]);
}
?>