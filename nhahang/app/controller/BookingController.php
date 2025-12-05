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
