<?php
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
        $stmt = $this->pdo->prepare("
            SELECT id_don_hang, tong_tien, trang_thai, ngay_dat
            FROM don_hang
            WHERE id_khach_hang = ?
            ORDER BY ngay_dat DESC
            LIMIT ?
        ");

        $stmt->bindValue(1, $userId, PDO::PARAM_INT);
        $stmt->bindValue(2, (int)$limit, PDO::PARAM_INT);

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function getCustomerReviews($userId, $limit = 5) {
        $stmt = $this->pdo->prepare("
            SELECT * FROM danh_gia
            WHERE id_khach_hang = ? 
            ORDER BY ngay_danh_gia DESC
            LIMIT ?
        ");

        $stmt->bindValue(1, $userId, PDO::PARAM_INT);
        $stmt->bindValue(2, (int)$limit, PDO::PARAM_INT);

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function verifyOrderOwnership($orderId, $userId) {
        // Đã sửa 'id' thành 'id_don_hang' và 'user_id' thành 'id_khach_hang'
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM don_hang WHERE id_don_hang = ? AND id_khach_hang = ?"); 
        $stmt->execute([$orderId, $userId]);
        return $stmt->fetchColumn() > 0;
    }

    public function hasReviewed($orderId, $userId) {
        // Đã sửa 'don_hang_id' thành 'id_don_hang'
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM danh_gia WHERE id_don_hang = ? AND id_khach_hang = ?");
        $stmt->execute([$orderId, $userId]);
        return $stmt->fetchColumn() > 0;
    }

    public function addReview($orderId, $userId, $rating, $comment) {
        // Đã sửa tên cột
        $stmt = $this->pdo->prepare("INSERT INTO danh_gia (id_khach_hang, id_don_hang, sao, nhan_xet) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$userId, $orderId, $rating, $comment]);
    }

    public function capNhatTongChiTieu($userId, $tongTien) {
        $stmt = $this->pdo->prepare("UPDATE khach_hang SET tong_chi_tieu = tong_chi_tieu + ? WHERE id_khach_hang = ?");
        $stmt->execute([$tongTien, $userId]);
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