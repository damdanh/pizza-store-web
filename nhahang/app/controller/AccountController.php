<?php
// file: AccountController.php (ĐÃ LOẠI BỎ LOGIC GỌI ĐÁNH GIÁ)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../model/AccountModel.php';


class AccountController {
    private $account;

    public function __construct() {
        $this->account = new AccountModel();
    }

    public function index() {
        try {

            // kiểm tra login
            if (!isset($_SESSION['user_id'])) {
                header("Location: /WD20302-PRO1014_N5/nhahang/public/login");
                exit;
            }

            $userId = $_SESSION['user_id'];

            // lấy dữ liệu từ model
            $customer  = $this->account->getCustomerInfo($userId);
            $membership = $this->account->getMembershipInfo($userId);
            $orders = $this->account->getOrderHistory($userId);
            // XÓA: $reviews = $this->account->getCustomerReviews($userId);
            $reviews = []; // Gán mảng rỗng để profile.php không bị lỗi

            // KHẮC PHỤC LỖI: Gán đối tượng Model cho biến để truyền xuống View
            $accountModel = $this->account; 

            // gửi dữ liệu sang view
            $title = "Hồ sơ cá nhân";

            // đường dẫn view đúng theo cấu trúc của bạn
            $content_view = __DIR__ . '/../view/profile.php';

            // gọi layout
            include __DIR__ . '/../view/main.php';

        } catch (Exception $e) {
            // error_log("LỖI AccountController::index => " . $e->getMessage());
            echo $e->getMessage();
        }
    }

    public function profile() {
       
        header("Location: /WD20302-PRO1014_N5/nhahang/public/account");
        exit;
    }
}
// XÓA DẤU NGOẶC NHỌN THỪA