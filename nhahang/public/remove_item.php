<?php
session_start();

$id = $_GET['id'] ?? 0;

// Nếu giỏ hàng tồn tại và có món đó
if (isset($_SESSION['cart'][$id])) {
    unset($_SESSION['cart'][$id]);  // Xoá món khỏi giỏ hàng
}

// Quay về trang đặt bàn
header("Location: datban.php");
exit;
?>
