<?php
// 1. Tải Model (Từ file BookingController.php gốc)
require_once ROOT_PATH . 'app/model/BookingModel.php'; 

class BookingController {

    private $viewPath;

    public function __construct() {
        $this->viewPath = ROOT_PATH . 'app/view/';
    }

    /**
     * Hiển thị form đặt bàn
     * (Chức năng có trong cả hai file)
     */
    public function showBookingForm() {
        $data = [
            'title' => 'Đặt Bàn',
            'base_url_path' => $GLOBALS['base_url_path']
        ];

        $content_view = $this->viewPath . 'datban.php';
        extract($data);
        include ROOT_PATH . 'app/view/main.php';
    }

    /**
     * Xử lý việc tạo đơn đặt bàn mới từ dữ liệu POST.
     * (Chức năng chỉ có trong file BookingController.php gốc)
     */
    public function handleBookingCreation() {
        // 1. Chỉ xử lý khi có dữ liệu được gửi đi (POST)
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            // 2. Thu thập dữ liệu từ POST
            $data = [
                'name' => $_POST['name'] ?? '',
                'phone' => $_POST['phone'] ?? '',
                'email' => $_POST['email'] ?? null,
                'soluongban' => $_POST['soluongban'] ?? 0,
                'booking_date' => $_POST['booking_date'] ?? '', 
                'booking_time' => $_POST['booking_time'] ?? '', 
                'branch' => $_POST['branch'] ?? '', 
                'notes' => $_POST['notes'] ?? '',
                'total' => $_POST['total'] ?? 0, 
                'id_khach_hang' => $_SESSION['user_id'] ?? null, 
                'status' => 0 // Mặc định là đơn chờ xử lý
            ];

            try {
                // 3. Khởi tạo và gọi Model
                $bookingModel = new BookingModel();
                $newBookingId = $bookingModel->createBooking($data);
                
                // 4. Xử lý thành công
                // Chuyển hướng đến trang xác nhận
                header('Location: ' . $GLOBALS['base_url_path'] . 'xac-nhan-dat-ban'); 
                exit();

            } catch (Exception $e) {
                // 5. Xử lý lỗi (ví dụ: lỗi validate từ Model)
                
                $error_message = $e->getMessage();
                
                // Cần phải tải lại form với thông báo lỗi
                $data = [
                    'title' => 'Đặt Bàn (Lỗi)',
                    'base_url_path' => $GLOBALS['base_url_path'],
                    'error' => $error_message, // Truyền lỗi để hiển thị trên View
                    'old_data' => $data // Giữ lại dữ liệu người dùng đã nhập
                ];
                
                $content_view = $this->viewPath . 'datban.php';
                extract($data);
                include ROOT_PATH . 'app/view/main.php';
                return;
            }
        }
        
        // Nếu không phải POST, chuyển hướng về trang đặt bàn
        header('Location: ' . $GLOBALS['base_url_path'] . 'dat-ban');
        exit();
    }


    /**
     * Trang xác nhận đặt bàn
     * (Chức năng có trong cả hai file)
     */
    public function showConfirmation() {
        $data = [
            'title' => 'Xác Nhận Đặt Bàn',
            'base_url_path' => $GLOBALS['base_url_path'],
        ];

        $content_view = $this->viewPath . 'xacnhandatban.php';
        extract($data);
        include ROOT_PATH . 'app/view/main.php';
    }
    
    /**
     * Trang Đơn hàng đang được xử lý
     * (Chức năng bổ sung từ file BookingController (1).php)
     */
    public function showProcessingPage() {
        $data = [
            'title' => 'Đơn Hàng Đang Được Xử Lý',
            'base_url_path' => $GLOBALS['base_url_path'],
        ];

        $content_view = $this->viewPath . 'dang-cho-xu-ly.php';
        extract($data);
        include ROOT_PATH . 'app/view/main.php';
    }
}