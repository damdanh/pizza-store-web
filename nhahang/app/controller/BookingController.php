<?php
class BookingController {


    private $viewPath;

    public function __construct() {
        $this->viewPath = ROOT_PATH . 'app/view/';
    }

    // Hiển thị form đặt bàn
    public function showBookingForm() {
        $data = [
            'title' => 'Đặt Bàn',
            'base_url_path' => $GLOBALS['base_url_path']
        ];

        $content_view = $this->viewPath . 'datban.php';
        extract($data);
        include ROOT_PATH . 'app/view/main.php';
    }

    // Hiển thị trang xác nhận đặt bàn
    public function showConfirmation() {
        if (!isset($_SESSION['booking'])) {
            header("Location: " . $GLOBALS['base_url_path'] . "dat-ban");
    
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

        $data = [
            'title' => 'Xác Nhận Đặt Bàn',
            'base_url_path' => $GLOBALS['base_url_path'],
            'bookingInfo' => $_SESSION['booking']
        ];

        $content_view = $this->viewPath . 'xacnhandatban.php';
        extract($data);
        include ROOT_PATH . 'app/view/main.php';
    }

}

}

