<?php
class BookingModel {
    private $conn; // Đã đổi tên biến kết nối từ $pdo sang $conn
    private $table = 'bookings'; // Bảng chính của model này

    // SỬA LỖI: Bỏ đối số $pdo và tự thiết lập kết nối
    public function __construct() { 
        // Đường dẫn đến file database.php có thể cần điều chỉnh tùy cấu trúc
        require_once __DIR__ . '/../config/database.php'; 
        try {
            $this->conn = getConnection(); 
        } catch (\Exception $e) {
            throw new Exception("Lỗi kết nối database: " . $e->getMessage());
        }
    }

    public function createBooking($data) {
        try {
            // ✅ Validate dữ liệu trước khi INSERT
            $required = ['name', 'phone', 'people', 'date', 'time', 'branch'];
            foreach ($required as $field) {
                if (empty($data[$field])) {
                    throw new Exception("Thiếu trường bắt buộc: {$field}");
                }
            }
            
            // LẤY DỮ LIỆU BỔ SUNG
            $userId = $data['user_id'] ?? null;
            $totalAmount = $data['total'] ?? 0;
            
            // CẬP NHẬT CÂU LỆNH SQL: Thêm id_khach_hang và total
            $stmt = $this->conn->prepare(" // ĐÃ SỬA: Dùng $this->conn
                INSERT INTO bookings (name, phone, email, id_khach_hang, people, booking_date, booking_time, branch, notes, total, created_at)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())
            ");
            
            // CẬP NHẬT THỨ TỰ THAM SỐ:
            $success = $stmt->execute([
                $data['name'], 
                $data['phone'], 
                $data['email'] ?? null,
                $userId,                    
                $data['people'], 
                $data['date'],              
                $data['time'], 
                $data['branch'], 
                $data['notes'] ?? '',
                $totalAmount                
            ]);

            if (!$success) {
                throw new Exception("Execute failed: " . implode(", ", $stmt->errorInfo()));
            }

            $lastId = $this->conn->lastInsertId(); // ĐÃ SỬA: Dùng $this->conn
            
            // ✅ Log để debug
            error_log("Created booking ID: {$lastId} for {$data['name']} (User ID: {$userId})");
            
            return $lastId;
            
        } catch (PDOException $e) {
            error_log("PDO Error in createBooking: " . $e->getMessage());
            throw new Exception("Lỗi database: " . $e->getMessage());
        }
    }
    
    public function addBookingItem($bookingId, $idMon, $soLuong, $gia) {
        try {
            // ✅ Validate
            if (!is_numeric($bookingId) || !is_numeric($idMon)) {
                throw new Exception("Invalid booking or item ID");
            }

            $stmt = $this->conn->prepare(" // ĐÃ SỬA: Dùng $this->conn
                INSERT INTO booking_items (booking_id, id_mon, so_luong, gia)
                VALUES (?, ?, ?, ?)
            ");
            
            $success = $stmt->execute([$bookingId, $idMon, $soLuong, $gia]);
            
            if (!$success) {
                error_log("Failed to add item: " . implode(", ", $stmt->errorInfo()));
            }
            
            return $success;
            
        } catch (PDOException $e) {
            error_log("PDO Error in addBookingItem: " . $e->getMessage());
            return false;
        }
    }
}