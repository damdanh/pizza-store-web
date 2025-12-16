<?php
class BookingModel {
    private $pdo;

   public function __construct() { 
        // 1. Đảm bảo file database.php được tải
        require_once __DIR__ . '/../config/database.php'; 
        try {
            // 2. Tự gọi hàm kết nối (giả định hàm getConnection() tồn tại)
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
            // Bao gồm tất cả các cột cần thiết (có trong cả hai file)
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
     * (Hợp nhất: Sử dụng cấu trúc SQL của BookingModel (1).php để bao gồm tien_thanh_toan_sau)
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
            $tienThanhToanSau = $data['tien_thanh_toan_sau'] ?? 0; // Từ BookingModel (1).php
            
            // CÂU LỆNH SQL: Bao gồm cột tien_thanh_toan_sau (12 cột dữ liệu + created_at)
            $stmt = $this->pdo->prepare("
                INSERT INTO bookings (name, phone, email, id_khach_hang, soluongban, booking_date, booking_time, branch, notes, total, tien_thanh_toan_sau, created_at, status)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), ?)
            ");
            
            // CẬP NHẬT THỨ TỰ THAM SỐ: Cần 12 tham số dữ liệu
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
                $tienThanhToanSau, // Tham số thứ 11: tien_thanh_toan_sau
                $status // Tham số thứ 12: status
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
     * Thêm chi tiết món ăn vào đơn đặt bàn.
     */
    public function addBookingItem($bookingId, $idMon, $soLuong, $gia) {
        try {
            // Validate
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
     * Lấy trạng thái và thông tin tóm tắt của đơn đặt bàn.
     * (Chức năng bổ sung từ BookingModel (1).php)
     */
    public function getBookingStatus($id) {
        try {
            if (!is_numeric($id)) return false;

            $stmt = $this->pdo->prepare("
                SELECT status, id, name, branch, total, tien_thanh_toan_sau
                FROM bookings 
                WHERE id = ?
            ");
            $stmt->execute([$id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("PDO Error in getBookingStatus: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Lấy thông tin đầy đủ của booking, bao gồm cart items.
     * (Chức năng bổ sung từ BookingModel (1).php)
     */
    public function getFullBookingInfo($id) {
        try {
            if (!is_numeric($id)) return false;

            // Lấy info chính
            $stmt = $this->pdo->prepare("
                SELECT * FROM bookings WHERE id = ?
            ");
            $stmt->execute([$id]);
            $booking = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if (!$booking) return false;

            // Lấy cart items nếu có
            $stmt_items = $this->pdo->prepare("
                SELECT bi.*, m.ten_mon  -- Giả sử bảng mon_an có cột ten_mon
                FROM booking_items bi
                LEFT JOIN mon_an m ON bi.id_mon = m.id_mon
                WHERE bi.booking_id = ?
            ");
            $stmt_items->execute([$id]);
            $booking['cart'] = $stmt_items->fetchAll(PDO::FETCH_ASSOC);

            return $booking;
        } catch (PDOException $e) {
            error_log("PDO Error in getFullBookingInfo: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Xóa đơn đặt bàn và các mục liên quan.
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