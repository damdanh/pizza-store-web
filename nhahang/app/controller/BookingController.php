<?php
class BookingController {
    
    // Thuộc tính để chứa đường dẫn view
    private $viewPath; 

    public function __construct() {
        // Thiết lập đường dẫn cơ sở đến thư mục view
        $this->viewPath = ROOT_PATH . 'app/view/';
    }
    
    // Hàm hiển thị trang Đặt Bàn (datban.php)
    public function showBookingForm() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->processConfirmation();
        } else {
            require_once $this->viewPath . 'datban.php';
        }
    }

    // Hàm xử lý logic Xác nhận Đặt Bàn (dachonmon.php)
    public function processConfirmation() {
        // 1. Kiểm tra xem request có phải là POST không
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            // 2. Lấy dữ liệu từ form (số lượng người, ngày, giờ, tên, SĐT...)
            // $data = $_POST;
            
            // 3. Thực hiện xác thực dữ liệu (validation)
            // if (empty($data['name']) || empty($data['phone'])) { ... }
            
            // 4. Nếu hợp lệ, lưu dữ liệu vào database qua BookingModel
            // $bookingModel = new BookingModel();
            // $bookingId = $bookingModel->createBooking($data);
            
            // 5. Chuẩn bị dữ liệu để hiển thị trên trang xác nhận
            // $bookingInfo = $bookingModel->getBookingDetails($bookingId);
            
            // Load view xác nhận
            // $bookingInfo được truyền vào view để hiển thị thông tin
            require_once $this->viewPath . 'mondachon.php';
        } else {
            // Nếu không phải POST, chuyển hướng về trang đặt bàn
            header('Location: ' . $GLOBALS['base_url_path'] . 'datban');
            exit;
        }
    }
}
?>