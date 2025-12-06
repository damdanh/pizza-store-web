<?php
class BookingModel {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function createBooking($data) {
        $stmt = $this->pdo->prepare("
            INSERT INTO bookings (name, phone, email, people, booking_date, booking_time, branch, notes, created_at)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())
        ");

        $stmt->execute([
            $data['name'],
            $data['phone'],
            $data['email'] ?? null,
            $data['people'],
            $data['date'],
            $data['time'],
            $data['branch'],
            $data['notes']
        ]);

        return $this->pdo->lastInsertId();
    }

    public function addBookingItem($bookingId, $idMon, $soLuong, $gia) {
        // ✅ VALIDATE TRƯỚC KHI INSERT
        if (empty($idMon) || $idMon <= 0) {
            error_log("❌ Lỗi: id_mon không hợp lệ - Giá trị: " . var_export($idMon, true));
            throw new Exception("ID món ăn không hợp lệ");
        }

        if (empty($soLuong) || $soLuong <= 0) {
            throw new Exception("Số lượng không hợp lệ");
        }

        if (empty($gia) || $gia <= 0) {
            throw new Exception("Giá không hợp lệ");
        }

        // Log để debug
        error_log("✅ Đang lưu booking_item - BookingID: $bookingId, MonID: $idMon, SL: $soLuong, Giá: $gia");

        $stmt = $this->pdo->prepare("
            INSERT INTO booking_items (booking_id, id_mon, so_luong, gia)
            VALUES (?, ?, ?, ?)
        ");

        return $stmt->execute([
            $bookingId, 
            (int)$idMon,      // ✅ Ép kiểu chắc chắn
            (int)$soLuong, 
            (float)$gia
        ]);
    }
}