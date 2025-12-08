<?php
require_once __DIR__ . '/../Model/DatbanModel.php';
require_once __DIR__ . '/../Model/ChinhanhModel.php';

class DatbanController {
    private $datbanModel;
    private $chinhanhModel;

    public function __construct() {
        $this->datbanModel = new DatbanModel();
        $this->chinhanhModel = new ChinhanhModel();
    }
    
    // Phương thức hiển thị Form (Giữ nguyên)
   public function showBookingForm() {
    
    if (class_exists('ChinhanhModel')) {
        echo "<pre>ChinhanhModel đã tải thành công. Khởi tạo đối tượng...</pre>";
        $chinhanh_list = [];
        try {
             // Thử gọi Model và in kết quả ra
             $chinhanh_list = $this->chinhanhModel->getAllBranches(); 
             
             echo "<pre>KẾT QUẢ LẤY DỮ LIỆU TỪ MODEL:";
             var_dump($chinhanh_list);
             echo "</pre>";
             
        } catch (\Exception $e) {
             echo "LỖI KHI GỌI MODEL/DB: " . $e->getMessage();
        }
    } else {
         echo "LỖI NGHIÊM TRỌNG: KHÔNG THỂ TẢI CLASS ChinhanhModel. Kiểm tra require_once!";
         $chinhanh_list = [];
    }
    
    // Đảm bảo không có lệnh 'exit;' nào trước lệnh include View
    include '../app/view/admin/formDemo.php'; 
}
    // Phương thức xử lý submit form (ĐÃ SỬA)
    public function processReservation() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?page=datban&error=Phương thức không hợp lệ');
            exit;
        }

        // Lấy và làm sạch dữ liệu
        $data = [
            'ten' => trim($_POST['ten'] ?? ''),
            'sdt' => trim($_POST['sdt'] ?? ''),
            'email' => trim($_POST['email'] ?? ''),
            'chinhanh' => trim($_POST['chinhanh'] ?? ''),
            'ngay' => trim($_POST['ngay'] ?? ''),
            'gio' => trim($_POST['gio'] ?? ''),
            'songuoi' => (int)($_POST['songuoi'] ?? 0),
            'ghichu' => trim($_POST['ghichu'] ?? ''),
            // Bỏ 'id_khach_hang' và 'id_ban' khỏi đây, sẽ xử lý sau
        ];

        // 1. Validate dữ liệu cơ bản
        if (empty($data['ten']) || empty($data['sdt']) || empty($data['email']) || empty($data['chinhanh']) || empty($data['ngay']) || empty($data['gio']) || $data['songuoi'] <= 0) {
            header('Location: index.php?page=datban&error=Vui lòng điền đầy đủ thông tin bắt buộc.');
            exit;
        }

        // 2. Thử tạo Khách hàng (hoặc tìm Khách hàng đã tồn tại)
        try {
            // SỬ DỤNG PHƯƠNG THỨC MỚI TỪ MODEL ĐỂ CÓ ID KHÁCH HÀNG HỢP LỆ
            $id_khach_hang = $this->datbanModel->createCustomerQuick($data['ten'], $data['email'], $data['sdt']);
            
        } catch (\Exception $e) {
            error_log("Đặt bàn thất bại (Lỗi Khách hàng): " . $e->getMessage());
            header('Location: index.php?page=datban&error=' . urlencode('Lỗi đăng ký/tìm kiếm Khách hàng: ' . $e->getMessage()));
            exit;
        }

        // 3. Thử tạo đơn đặt bàn
        try {
            // ID bàn vẫn để NULL vì chúng ta chưa có logic chọn bàn
            $id_ban = null; 
            
            // GỌI MODEL VỚI ID KHÁCH HÀNG VÀ DỮ LIỆU
            $reservation_id = $this->datbanModel->createReservation($data, $id_khach_hang, $id_ban);
            
            if ($reservation_id) {
                // Đặt bàn thành công
                $msg = "Đặt bàn thành công! Mã đơn của bạn là #{$reservation_id}. Chúng tôi sẽ liên hệ xác nhận sớm nhất.";
                header('Location: index.php?page=datban_thanhcong&msg=' . urlencode($msg));
                exit;
            } else {
                throw new Exception("Không thể lưu đơn đặt bàn.");
            }
        } catch (\Exception $e) {
            error_log("Đặt bàn thất bại (Lỗi Đặt bàn): " . $e->getMessage());
            header('Location: index.php?page=datban&error=' . urlencode('Lỗi hệ thống: ' . $e->getMessage()));
            exit;
        }
    }
}