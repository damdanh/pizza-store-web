<?php
// File: app/Model/DatbanModel.php

class DatbanModel {
    private $conn;
    private $table = 'dat_ban';

    public function __construct() {
        require_once __DIR__ . '/../config/database.php';
        try {
            $this->conn = getConnection();
        } catch (\Exception $e) {
            throw new Exception("Lỗi kết nối database: " . $e->getMessage());
        }
    }

    /**
     * TÌM KIẾM HOẶC TẠO ID Khách hàng nhanh chóng từ form đặt bàn.
     * @param string $ten Tên khách hàng
     * @param string $email Email khách hàng
     * @param string $sdt SĐT khách hàng
     * @return int ID khách hàng
     * @throws Exception
     */
    public function createCustomerQuick($ten, $email, $sdt) {
        try {
            // 1. Kiểm tra Khách hàng đã tồn tại chưa (dựa trên email)
            $checkSql = "SELECT id_khach_hang FROM khach_hang WHERE email = :email";
            $checkStmt = $this->conn->prepare($checkSql);
            $checkStmt->bindParam(':email', $email, PDO::PARAM_STR);
            $checkStmt->execute();
            $existingCustomer = $checkStmt->fetch(PDO::FETCH_ASSOC);

            if ($existingCustomer) {
                return $existingCustomer['id_khach_hang']; // Trả về ID nếu đã tồn tại
            }

            // 2. Nếu chưa tồn tại, tạo Khách hàng mới
            // Chúng ta dùng mật khẩu tạm vì form đặt bàn không yêu cầu mật khẩu
            $default_password = 'temp_password_for_reservation';
            $hashed_default_password = password_hash($default_password, PASSWORD_DEFAULT);
            
            $insertSql = "INSERT INTO khach_hang (ten, sdt, email, mat_khau, trang_thai_tai_khoan)
                          VALUES (:ten, :sdt, :email, :mat_khau, 'Active')";
            
            $insertStmt = $this->conn->prepare($insertSql);
            $insertStmt->bindParam(':ten', $ten, PDO::PARAM_STR);
            $insertStmt->bindParam(':sdt', $sdt, PDO::PARAM_STR);
            $insertStmt->bindParam(':email', $email, PDO::PARAM_STR);
            $insertStmt->bindParam(':mat_khau', $hashed_default_password, PDO::PARAM_STR);
            
            $insertStmt->execute();
            
            return $this->conn->lastInsertId();

        } catch (PDOException $e) {
             // Lỗi 23000 thường là lỗi khóa duy nhất (unique constraint), ví dụ email đã tồn tại
             if ($e->getCode() == '23000') {
                 // Nếu trùng email, coi như đã có (hoặc xử lý lỗi cụ thể hơn nếu cần)
                 throw new Exception("Email đã tồn tại trong hệ thống.");
             }
             error_log("Lỗi SQL khi tạo Khách hàng nhanh: " . $e->getMessage());
             throw new Exception("Lỗi Database khi tạo thông tin Khách hàng.");
        }
    }
    
    /**
     * Thêm một đơn đặt bàn mới vào CSDL.
     * @param array $data Dữ liệu đặt bàn từ form
     * @param int $id_khach_hang ID khách hàng (có thể là ID mới tạo)
     * @param int|null $id_ban ID bàn được chọn (có thể là NULL nếu chưa chọn bàn cụ thể)
     * @return int ID của bản ghi mới được thêm.
     */
    public function createReservation($data, $id_khach_hang, $id_ban = null) {
        try {
            
            // Xử lý ngày giờ thành định dạng Y-m-d H:i:s
            $datetime_string = $data['ngay'] . ' ' . $data['gio'] . ':00';
            $ngay_dat_ban = date('Y-m-d H:i:s', strtotime($datetime_string));
            
            // Giá trị mặc định
            $trang_thai = 'Chờ xác nhận';
            $tong_gia = 0.00; 
            
            $sql = "INSERT INTO " . $this->table . " (
                        id_khach_hang, 
                        id_ban, 
                        ngay_dat_ban, 
                        trang_thai_dat_ban, 
                        so_luong_nguoi, 
                        ghi_chu,
                        tong_gia
                    ) VALUES (
                        :id_khach_hang, 
                        :id_ban, 
                        :ngay_dat_ban, 
                        :trang_thai, 
                        :so_luong_nguoi, 
                        :ghi_chu, 
                        :tong_gia
                    )";
                    
            $stmt = $this->conn->prepare($sql);
            
            $stmt->bindParam(':id_khach_hang', $id_khach_hang, PDO::PARAM_INT);
            $stmt->bindParam(':id_ban', $id_ban, PDO::PARAM_INT); // NULL là hợp lệ
            $stmt->bindParam(':ngay_dat_ban', $ngay_dat_ban, PDO::PARAM_STR);
            $stmt->bindParam(':trang_thai', $trang_thai, PDO::PARAM_STR);
            $stmt->bindParam(':so_luong_nguoi', $data['songuoi'], PDO::PARAM_INT);
            $stmt->bindParam(':ghi_chu', $data['ghichu'], PDO::PARAM_STR);
            $stmt->bindParam(':tong_gia', $tong_gia);

            $stmt->execute();
            
            return $this->conn->lastInsertId();
            
        } catch (PDOException $e) {
            error_log("Lỗi SQL khi thêm đặt bàn: " . $e->getMessage());
            throw new Exception("Lỗi Database khi đặt bàn: " . $e->getMessage());
        }
    }


    /**
     * Lấy tất cả đơn đặt bàn, join với thông tin Khách hàng và Bàn/Khu vực.
     * Có thể lọc theo trạng thái (status).
     * @param string $status Trạng thái cần lọc (Mặc định là null để lấy tất cả)
     * @return array
     */
    public function getAllReservations($status = null) {
        try {
            // Bổ sung cột sdt_khach_hang
            $sql = "SELECT 
                        db.id_dat_ban, 
                        db.ngay_dat_ban, 
                        db.trang_thai_dat_ban, 
                        db.so_luong_nguoi, 
                        db.ghi_chu,
                        db.tong_gia,
                        kh.ten AS ten_khach_hang, 
                        kh.email AS email_khach_hang,
                        kh.sdt AS sdt_khach_hang, 
                        b.ten_ban,
                        kv.ten_khu_vuc
                    FROM " . $this->table . " db
                    LEFT JOIN khach_hang kh ON db.id_khach_hang = kh.id_khach_hang
                    LEFT JOIN ban b ON db.id_ban = b.id_ban
                    LEFT JOIN khu_vuc kv ON b.id_khu_vuc = kv.id_khu_vuc";
            
            $params = [];
            if ($status !== null) {
                $sql .= " WHERE db.trang_thai_dat_ban = :status";
                $params[':status'] = $status;
            }

            $sql .= " ORDER BY db.ngay_dat_ban DESC";

            $stmt = $this->conn->prepare($sql);
            $stmt->execute($params);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Lỗi CSDL khi lấy danh sách đặt bàn: " . $e->getMessage());
        }
    }
    
    /**
     * Lấy chi tiết đơn đặt bàn
     * @param int $id ID đặt bàn
     * @return array
     */
    public function getReservationDetails($id) {
        try {
            $sql = "SELECT * FROM " . $this->table . " WHERE id_dat_ban = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $reservation = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($reservation) {
                // Lấy chi tiết món ăn đã pre-order
                $detailsSql = "SELECT 
                                ctdb.so_luong, 
                                ctdb.don_gia, 
                                ctdb.ghi_chu,
                                ma.ten_mon
                               FROM chi_tiet_dat_ban ctdb
                               JOIN mon_an ma ON ctdb.id_mon = ma.id_mon
                               WHERE ctdb.id_dat_ban = :id";
                $detailsStmt = $this->conn->prepare($detailsSql);
                $detailsStmt->bindParam(':id', $id, PDO::PARAM_INT);
                $detailsStmt->execute();
                $reservation['mon_an_dat'] = $detailsStmt->fetchAll(PDO::FETCH_ASSOC);
            }
            return $reservation;
        } catch (PDOException $e) {
            throw new Exception("Lỗi CSDL khi lấy chi tiết đặt bàn: " . $e->getMessage());
        }
    }

    /**
     * Cập nhật trạng thái đặt bàn
     * @param int $id ID đặt bàn
     * @param string $status Trạng thái mới ('Đã xác nhận', 'Đã hủy', ...)
     * @return bool
     */
    public function updateReservationStatus($id, $status) {
        try {
            $sql = "UPDATE " . $this->table . " SET trang_thai_dat_ban = :status WHERE id_dat_ban = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':status', $status, PDO::PARAM_STR);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            throw new Exception("Lỗi CSDL khi cập nhật trạng thái đặt bàn: " . $e->getMessage());
        }
    }
}