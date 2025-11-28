<?php
// File: /app/controller/HomeController.php

class HomeController {

    /**
     * Phương thức index() là hành động mặc định khi truy cập trang chủ.
     */
    public function index() {
        
        // =========================================================
        // BƯỚC 1: LẤY DỮ LIỆU TỪ MODEL (Tương lai)
        // =========================================================
        
        // Hiện tại, chúng ta chưa có Model. 
        // Sau này, bạn sẽ uncomment các dòng dưới đây:
        
        /*
        $monAnModel = new MonAnModel();
        $danhMuc = $monAnModel->getAllCategories();
        $monAnPhoBien = $monAnModel->getPopularDishes();
        */
        
        // Tạm thời, tạo dữ liệu giả (mock data) để View không bị lỗi
        $data = [
            'title' => 'Trang Chủ - PIZZA & PASTA',
            // 'danhMuc' => $danhMuc,
            // 'monAnPhoBien' => $monAnPhoBien,
        ];


        // =========================================================
        // BƯỚC 2: CHỈ ĐỊNH VIEW NỘI DUNG VÀ LOAD LAYOUT
        // =========================================================
        
        // 1. Định nghĩa đường dẫn tới file View riêng biệt của trang này.
        // Cần đảm bảo đường dẫn này đúng từ vị trí của file index.php
        $content_view = __DIR__ . '/../view/home.php'; 
        
        // 2. Chuyển đổi các biến dữ liệu từ mảng $data thành các biến đơn
        // để có thể sử dụng trực tiếp trong View và Layout.
        // Ví dụ: $data['title'] sẽ trở thành biến $title
        extract($data); 
        
        // 3. Load Layout chính (main.php)
        // Layout chính sẽ dùng biến $content_view và các biến dữ liệu ($title, ...)
        include __DIR__ . '/../view/main.php';
    }
}