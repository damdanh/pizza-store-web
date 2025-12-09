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

    // Trang xác nhận
    public function showConfirmation() {
        $data = [
            'title' => 'Xác Nhận Đặt Bàn',
            'base_url_path' => $GLOBALS['base_url_path'],
        ];

        $content_view = $this->viewPath . 'xacnhandatban.php';
        extract($data);
        include ROOT_PATH . 'app/view/main.php';
    }
}
