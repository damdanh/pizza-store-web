<?php
class DoanhthuModel {
    private $conn;

    public function __construct() {
        // Tái sử dụng kết nối database từ ChinhanhModel
        require_once __DIR__ . '/../config/database.php';
        try {
            // Giả sử getConnection() được định nghĩa trong database.php
            $this->conn = getConnection();
        } catch (\Exception $e) {
            throw new Exception("Lỗi kết nối database: " . $e->getMessage());
        }
    }

    /** * @param string $startDate
     * @param string $endDate
     * @param int|null $branchId
     * @return array
     */
    public function getRevenueSummary($startDate, $endDate, $branchId = null) {

        $sql = "SELECT 
                    SUM(tong_tien) as total_revenue,
                    COUNT(id) as total_orders
                FROM donhang
                WHERE DATE(ngay_dat) BETWEEN :start_date AND :end_date
                AND trang_thai = 'Hoàn thành'"; // Chỉ tính đơn hàng hoàn thành

        if ($branchId) {
            $sql .= " AND id_chi_nhanh = :branch_id";
        }

        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':start_date', $startDate);
            $stmt->bindParam(':end_date', $endDate);

            if ($branchId) {
                $stmt->bindParam(':branch_id', $branchId, PDO::PARAM_INT);
            }
            
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            // Giả lập Lợi nhuận ròng bằng 30% Doanh thu (Do CSDL thiếu cột lợi nhuận)
            $totalRevenue = $result['total_revenue'] ?? 0;
            $netProfit = $totalRevenue * 0.3; 

            return [
                'total_revenue' => (float)$totalRevenue,
                'net_profit' => (float)$netProfit,
                'total_orders' => (int)($result['total_orders'] ?? 0),
            ];

        } catch (PDOException $e) {
            error_log("Lỗi truy vấn Summary: " . $e->getMessage());
            return ['total_revenue' => 0, 'net_profit' => 0, 'total_orders' => 0];
        }
    }

    /**
     * Lấy dữ liệu doanh thu theo từng ngày trong khoảng thời gian
     */
    public function getDailyRevenue($startDate, $endDate, $branchId = null) {
        $sql = "SELECT 
                    DATE(ngay_dat) as order_date,
                    SUM(tong_tien) as daily_revenue
                FROM donhang
                WHERE DATE(ngay_dat) BETWEEN :start_date AND :end_date
                AND trang_thai = 'Hoàn thành'";
                
        if ($branchId) {
            $sql .= " AND id_chi_nhanh = :branch_id";
        }

        $sql .= " GROUP BY order_date ORDER BY order_date ASC";

        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':start_date', $startDate);
            $stmt->bindParam(':end_date', $endDate);

            if ($branchId) {
                $stmt->bindParam(':branch_id', $branchId, PDO::PARAM_INT);
            }
            
            $stmt->execute();
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Xử lý dữ liệu để tính thêm Lợi nhuận (giả lập 30%)
            $processedData = [];
            foreach ($results as $row) {
                $revenue = (float)$row['daily_revenue'];
                $processedData[] = [
                    'date' => $row['order_date'],
                    'revenue' => $revenue,
                    'profit' => $revenue * 0.3 // Giả lập 30% lợi nhuận
                ];
            }

            return $processedData;

        } catch (PDOException $e) {
            error_log("Lỗi truy vấn Daily Revenue: " . $e->getMessage());
            return [];
        }
    }
    
    /**
     * Cập nhật trạng thái của một đơn hàng
     *
     * @param int $orderId ID của đơn hàng cần cập nhật
     * @param string $status Trạng thái mới (ví dụ: 'Hoàn thành')
     * @return bool
     */
    public function updateOrderStatus($orderId, $status) {
        $sql = "UPDATE donhang 
                SET trang_thai = :status 
                WHERE id = :id"; 
        
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':status', $status, PDO::PARAM_STR);
            $stmt->bindParam(':id', $orderId, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Lỗi CSDL khi cập nhật trạng thái đơn hàng: " . $e->getMessage());
            return false;
        }
    }
}
?>