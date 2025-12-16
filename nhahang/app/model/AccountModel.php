<?php
// file: AccountModel.php (ĐÃ LOẠI BỎ LOGIC ĐÁNH GIÁ)
require_once __DIR__ . '/../config/database.php';

class AccountModel {
    private $pdo;

    public function __construct() {
        $this->pdo = getConnection(); 
    }

    public function getCustomerInfo($userId) {
        $stmt = $this->pdo->prepare("SELECT * FROM khach_hang WHERE id_khach_hang = ?");
        $stmt->execute([$userId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getMembershipInfo($userId) {
        $stmt = $this->pdo->prepare("SELECT hang_thanh_vien, tong_chi_tieu FROM khach_hang WHERE id_khach_hang = ?");
        $stmt->execute([$userId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getOrderHistory($userId, $limit = 10) {
        // Lấy cả đơn hàng và đơn đặt bàn (booking)
        $stmt = $this->pdo->prepare("
            (SELECT dh.id_don_hang, dh.tong_tien, dh.trang_thai, dh.ngay_dat, 'order' as loai_don, dh.tong_tien as tong_tien_hien_thi
            FROM don_hang dh
            WHERE dh.id_khach_hang = :userId1)
            
            UNION ALL
            
            (SELECT b.id as id_don_hang,              
            b.total as tong_tien, 
            'Đã đặt bàn' as trang_thai, 
            b.booking_date as ngay_dat,   
            'booking' as loai_don,
            -- CẬP NHẬT LOGIC: TỔNG TIỀN MÓN (CÓ VAT) = TIỀN THANH TOÁN SAU + TIỀN CỌC
            (b.tien_thanh_toan_sau + b.total) as tong_tien_hien_thi
            FROM bookings b
            WHERE b.id_khach_hang = :userId2)
            
            ORDER BY ngay_dat DESC
            LIMIT :limit
        ");

        $stmt->bindValue(':userId1', $userId, PDO::PARAM_INT);
        $stmt->bindValue(':userId2', $userId, PDO::PARAM_INT);
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);

        if (!$stmt->execute()) {
             error_log("LỖI TRUY VẤN getOrderHistory: " . implode(" | ", $stmt->errorInfo()));
        }
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    // Xóa các hàm đánh giá cũ (getReviewByOrderAndUser, verifyOrderOwnership, hasReviewed, addReview, updateReview)

    public function getCustomerReviews($userId, $limit = 5) {
        // Giữ lại hàm này nhưng sẽ luôn trả về mảng rỗng vì không cần dùng nữa
        return [];
    }
    
    // ======== LOGIC HẠNG THÀNH VIÊN (Giữ nguyên) ========

    public function xacDinhHang($tongChiTieu) {
        if ($tongChiTieu >= 15000000) {
            return 'kimcuong';
        } elseif ($tongChiTieu >= 5000000) {
            return 'vang';
        } elseif ($tongChiTieu >= 2000000) {
            return 'bac';
        } elseif ($tongChiTieu >= 500000) {
            return 'dong'; 
        } else {
            return 'thuong'; 
        }
    }

    public function capNhatTongChiTieu($userId, $tongTienMoi) {
        // Cập nhật tổng chi tiêu
        $stmt = $this->pdo->prepare("UPDATE khach_hang SET tong_chi_tieu = tong_chi_tieu + ? WHERE id_khach_hang = ?");
        $stmt->execute([$tongTienMoi, $userId]); 
        
        // Lấy lại tổng chi tiêu mới
        $newTongChiTieu = $this->getTongChiTieu($userId);
        
        // Tự động cập nhật hạng thành viên
        $newHang = $this->xacDinhHang($newTongChiTieu);
        $this->capNhatHangThanhVien($userId, $newHang);
        
        return $newHang;
    }

    public function getTongChiTieu($userId) {
        $stmt = $this->pdo->prepare("SELECT tong_chi_tieu FROM khach_hang WHERE id_khach_hang = ?");
        $stmt->execute([$userId]);
        return $stmt->fetchColumn();
    }

    public function capNhatHangThanhVien($userId, $hang) {
        $stmt = $this->pdo->prepare("UPDATE khach_hang SET hang_thanh_vien = ? WHERE id_khach_hang = ?");
        $stmt->execute([$hang, $userId]);
    }
}