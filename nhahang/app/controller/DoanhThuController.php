<?php
require_once __DIR__ . '/../Model/DoanhthuModel.php';
require_once __DIR__ . '/../Model/chinhanhModel.php'; // Cần ChinhanhModel để lấy danh sách chi nhánh

class DoanhthuController {
    private $model;
    private $chinhanhModel;

    public function __construct() {
        $this->model = new DoanhthuModel();
        // Cần đảm bảo ChinhanhModel được khởi tạo thành công.
        // Lỗi kết nối CSDL thường xảy ra ở bước này.
        try {
            $this->chinhanhModel = new ChinhanhModel(); 
        } catch (Exception $e) {
            // Xử lý lỗi khởi tạo Model (ví dụ: lỗi kết nối DB)
            error_log("LỖI KHỞI TẠO CHINHANHMODEL: " . $e->getMessage());
            // Có thể dừng hoặc để Model là null, nhưng tốt nhất là xử lý gọn.
            $this->chinhanhModel = null;
        }
    }

    public function index() {
        // 1. Xử lý đầu vào từ bộ lọc
        $defaultEndDate = date('Y-m-d');
        $defaultStartDate = date('Y-m-d', strtotime('-7 days'));

        $startDate = $_GET['start_date'] ?? $defaultStartDate;
        $endDate = $_GET['end_date'] ?? $defaultEndDate;
        $branchId = (int)($_GET['branch_id'] ?? 0); // 0 = Tất cả chi nhánh

        // 2. Lấy dữ liệu từ Model
        $summaryData = $this->model->getRevenueSummary($startDate, $endDate, $branchId);
        $dailyData = $this->model->getDailyRevenue($startDate, $endDate, $branchId);
        
        // --- Đảm bảo lấy danh sách chi nhánh một cách an toàn ---
        $branches = []; // Khởi tạo mảng rỗng mặc định
        if ($this->chinhanhModel) {
            try {
                // Lấy danh sách chi nhánh để hiển thị bộ lọc
                // Lỗi truy vấn database thường xảy ra ở bước này
                $branches = $this->chinhanhModel->getAllBranches(); 
            } catch (Exception $e) {
                // Ghi log lỗi để kiểm tra (rất quan trọng)
                error_log("LỖI KHI LẤY CHI NHÁNH: " . $e->getMessage());
                // $branches vẫn là mảng rỗng, view sẽ hiển thị 'Tất cả chi nhánh'
            }
        }
        // --------------------------------------------------------

        // 3. Chuẩn bị dữ liệu cho Chart.js
        $labels = array_column($dailyData, 'date');
        $revenueData = array_column($dailyData, 'revenue');
        $profitData = array_column($dailyData, 'profit');
        
        $labels_json = json_encode($labels);
        $revenueData_json = json_encode($revenueData);
        $profitData_json = json_encode($profitData);

        // 4. Include View (View sẽ sử dụng các biến đã định nghĩa ở trên)
        include __DIR__ . '/../view/admin/doanhthu.php';
    }
}
?>