<?php
class BookingController {
    
    public function showBookingForm() {
        $data = [
            'title' => 'Đặt Bàn - PIZZA & PASTA',
            'base_url_path' => '/WD20302-PRO1014_N5/nhahang/'
        ];
        
        $content_view = __DIR__ . '/../view/datban.php';
        extract($data);
        include __DIR__ . '/../view/main.php';
    }

    public function processConfirmation() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Xử lý logic đặt bàn
            // Lưu vào database...
            
            // Chuyển sang trang xác nhận
            header('Location: /WD20302-PRO1014_N5/nhahang/public/xacnhandatban');
            exit;
        } else {
            header('Location: /WD20302-PRO1014_N5/nhahang/public/datban');
            exit;
        }
    }
}