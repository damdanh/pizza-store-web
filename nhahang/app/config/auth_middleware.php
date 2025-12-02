<?php
// app/config/auth_middleware.php

function requireLogin() {
    if (!isset($_SESSION['user_id'])) {
        $_SESSION['login_error'] = "Vui lòng đăng nhập để xem thực đơn chi tiết!";
        $_SESSION['redirect_after_login'] = $_SERVER['REQUEST_URI']; // Lưu URL để redirect sau khi đăng nhập
        header("Location: /WD20302-PRO1014_N5/nhahang/public/login");
        exit;
    }
}