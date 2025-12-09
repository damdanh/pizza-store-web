<?php
class BookingModel {
    private $pdo;

    public function __construct($pdo) { 
        $this->pdo = $pdo; 
    }

    public function createBooking($data) {
        try {
            // ✅ Validate dữ liệu trước khi INSERT
            // Đã thêm 'user_id' và 'total' vào các trường cần thiết trong $data, 
            // nhưng chỉ validate các trường bắt buộc ban đầu.
            $required = ['name', 'phone', 'soluongban', 'date', 'time', 'branch'];
            foreach ($required as $field) {
                if (empty($data[$field])) {
                    throw new Exception("Thiếu trường bắt buộc: {$field}");
                }
            }
            
            // LẤY DỮ LIỆU BỔ SUNG
            $userId = $data['user_id'] ?? null;
            $totalAmount = $data['total'] ?? 0;
            
            // CẬP NHẬT CÂU LỆNH SQL: Thêm id_khach_hang và total
            $stmt = $this->pdo->prepare("
                INSERT INTO bookings (name, phone, email, id_khach_hang, soluongban, booking_date, booking_time, branch, notes, total, created_at)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())
            ");
            
            // CẬP NHẬT THỨ TỰ THAM SỐ:
            $success = $stmt->execute([
                $data['name'], 
                $data['phone'], 
                $data['email'] ?? null,
                $userId,                    // THAM SỐ MỚI: id_khach_hang
                $data['soluongban'], 
                $data['date'],              // booking_date
                $data['time'], 
                $data['branch'], 
                $data['notes'] ?? '',
                $totalAmount                // THAM SỐ MỚI: total
            ]);

            if (!$success) {
                throw new Exception("Execute failed: " . implode(", ", $stmt->errorInfo()));
            }

            $lastId = $this->pdo->lastInsertId();
            
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

            $stmt = $this->pdo->prepare("
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