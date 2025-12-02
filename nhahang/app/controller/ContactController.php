<?php

class ContactController {

    public function index() {
        // 1. Chuẩn bị dữ liệu cần thiết cho View
        $data = [
            'title' => 'Liên Hệ - PIZZA & PASTA',
            // Đường dẫn này được sử dụng trong main.php để tải CSS, giữ nguyên như HomeController
            'base_url_path' => '/WD20302-PRO1014_N5/nhahang/', 
        ];
        
        // 2. Định nghĩa tệp View (nội dung)
        // Giả sử contact.php đã được chuyển vào thư mục 'view/'
        $content_view = __DIR__ . '/../view/contact.php'; 

        // 3. Truyền dữ liệu và tải View
        extract($data); // Chuyển các khóa trong $data thành biến ($title, $base_url_path)
        include __DIR__ . '/../view/main.php'; // Tải Layout chính
    }
}