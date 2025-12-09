<?php
class BookingModel {
    private $pdo;

   public function __construct() { 
        // 1. Đảm bảo file database.php được tải
        require_once __DIR__ . '/../config/database.php'; 
        try {
            // 2. Tự gọi hàm kết nối (giả định hàm getConnection() tồn tại)
            // Fix lỗi 'Too few arguments' bằng cách loại bỏ tham số trong __construct()
            $this->pdo = getConnection(); 
        } catch (\Exception $e) {
            // Xử lý lỗi nếu kết nối thất bại
            die("Lỗi kết nối database trong BookingModel: " . $e->getMessage());
        }
    }

    /**
     * Lấy tất cả các đơn đặt bàn.
     */
    public function getAllBookings() {
        try {
            // Đảm bảo lấy các cột cần thiết, bao gồm soluongban và status
            $sql = "SELECT b.id, b.name, b.phone, b.email, b.soluongban, b.booking_date, b.booking_time, b.branch, b.notes, b.total, b.created_at, b.status 
                    FROM bookings b
                    ORDER BY b.created_at DESC"; 

            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("PDO Error in getAllBookings: " . $e->getMessage());
            throw new Exception("Lỗi database khi lấy danh sách đặt bàn: " . $e->getMessage());
        }
    }
    
    /**
     * Tạo một đơn đặt bàn mới.
     */
    public function createBooking($data) {
        try {
            // Validate dữ liệu
            $required = ['name', 'phone', 'soluongban', 'booking_date', 'booking_time', 'branch'];
            foreach ($required as $field) {
                if (empty($data[$field])) {
                    throw new Exception("Thiếu trường bắt buộc: {$field}"); 
                }
            }
            
            // LẤY DỮ LIỆU BỔ SUNG
            $userId = $data['id_khach_hang'] ?? null;
            $totalAmount = $data['total'] ?? 0;
            $status = $data['status'] ?? 0;
            
            // CẬP NHẬT CÂU LỆNH SQL: Thêm cột status
            $stmt = $this->pdo->prepare("
                INSERT INTO bookings (name, phone, email, id_khach_hang, soluongban, booking_date, booking_time, branch, notes, total, created_at, status)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), ?)
            ");
            
            // CẬP NHẬT THỨ TỰ THAM SỐ:
            $success = $stmt->execute([
                $data['name'], 
                $data['phone'], 
                $data['email'] ?? null,
                $userId,                    
                $data['soluongban'], 
                $data['booking_date'],      
                $data['booking_time'], 
                $data['branch'], 
                $data['notes'] ?? '',
                $totalAmount,               
                $status                     
            ]);

            if (!$success) {
                throw new Exception("Execute failed: " . implode(", ", $stmt->errorInfo()));
            }

            return $this->pdo->lastInsertId();
            
        } catch (PDOException $e) {
            error_log("PDO Error in createBooking: " . $e->getMessage());
            throw new Exception("Lỗi database: " . $e->getMessage());
        }
    }
    
    /**
     * Cập nhật trạng thái của đơn đặt bàn
     */
    public function updateBookingStatus($id, $status) {
        try {
            $stmt = $this->pdo->prepare("
                UPDATE bookings 
                SET status = ? 
                WHERE id = ?
            ");
            return $stmt->execute([$status, $id]);
        } catch (PDOException $e) {
            error_log("PDO Error in updateBookingStatus: " . $e->getMessage());
            throw new Exception("Lỗi database khi cập nhật trạng thái đơn đặt bàn: " . $e->getMessage());
        }
    }
    
    /**
     * Xóa đơn đặt bàn
     */
    public function deleteBooking($id) {
        try {
            // Xóa chi tiết liên quan (giả định booking_items)
            $stmt_items = $this->pdo->prepare("DELETE FROM booking_items WHERE booking_id = ?");
            $stmt_items->execute([$id]);

            // Xóa đơn đặt bàn
            $stmt = $this->pdo->prepare("DELETE FROM bookings WHERE id = ?");
            return $stmt->execute([$id]);
        } catch (PDOException $e) {
            error_log("PDO Error in deleteBooking: " . $e->getMessage());
            throw new Exception("Lỗi database khi xóa đơn đặt bàn: " . $e->getMessage());
        }
    }
}