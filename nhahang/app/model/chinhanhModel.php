<?php
// tạo muc Model cho chi nhánh
class ChinhanhModel {
    private $conn;

    public function __construct() {
        require_once __DIR__ . '/../config/database.php';
        try {
            $this->conn = getConnection();
        } catch (\Exception $e) {
            throw new Exception("Kết nối database không tồn tại. Vui lòng kiểm tra file config/database.php");
        }
    }

    public function getAllBranches() {
        try {
            $sql = "SELECT id, ten_chi_nhanh, dia_chi, gio_mo_cua, gio_dong_cua, so_luong_ban, suc_chua, khung_gio, ban_con_trong FROM chinhanh ORDER BY id";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Lỗi truy vấn database: " . $e->getMessage());
        }
    }

    public function getBranchById($id) {
        try {
            $sql = "SELECT * FROM chinhanh WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Lỗi truy vấn database: " . $e->getMessage());
        }
    }

    public function createBranch($data) {
        try {
            // Basic validation
            if (empty($data['ten_chi_nhanh'])) {
                throw new Exception("Tên chi nhánh không được để trống.");
            }

            $sql = "INSERT INTO chinhanh (ten_chi_nhanh, dia_chi, gio_mo_cua, gio_dong_cua, so_luong_ban, suc_chua, khung_gio, ban_con_trong)
                    VALUES (:ten, :dia_chi, :gio_mo, :gio_dong, :so_luong_ban, :suc_chua, :khung_gio, :ban_con_trong)";
            $stmt = $this->conn->prepare($sql);

            $stmt->bindParam(':ten', $data['ten_chi_nhanh'], PDO::PARAM_STR);
            $stmt->bindParam(':dia_chi', $data['dia_chi'], PDO::PARAM_STR);
            $stmt->bindParam(':gio_mo', $data['gio_mo_cua'], PDO::PARAM_STR);
            $stmt->bindParam(':gio_dong', $data['gio_dong_cua'], PDO::PARAM_STR);
            $stmt->bindParam(':so_luong_ban', $data['so_luong_ban'], PDO::PARAM_INT);
            $stmt->bindParam(':suc_chua', $data['suc_chua'], PDO::PARAM_INT);
            $stmt->bindParam(':khung_gio', $data['khung_gio'], PDO::PARAM_STR);
            $stmt->bindParam(':ban_con_trong', $data['ban_con_trong'], PDO::PARAM_INT);

            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Lỗi SQL khi thêm chi nhánh: " . $e->getMessage());
            throw new Exception("Lỗi Database khi thêm chi nhánh: " . $e->getMessage());
        }
    }

    public function updateBranch($id, $data) {
        try {
            $sql = "UPDATE chinhanh SET ten_chi_nhanh = :ten, dia_chi = :dia_chi, gio_mo_cua = :gio_mo, gio_dong_cua = :gio_dong, so_luong_ban = :so_luong_ban, suc_chua = :suc_chua, khung_gio = :khung_gio, ban_con_trong = :ban_con_trong WHERE id = :id";
            $stmt = $this->conn->prepare($sql);

            $stmt->bindParam(':ten', $data['ten_chi_nhanh'], PDO::PARAM_STR);
            $stmt->bindParam(':dia_chi', $data['dia_chi'], PDO::PARAM_STR);
            $stmt->bindParam(':gio_mo', $data['gio_mo_cua'], PDO::PARAM_STR);
            $stmt->bindParam(':gio_dong', $data['gio_dong_cua'], PDO::PARAM_STR);
            $stmt->bindParam(':so_luong_ban', $data['so_luong_ban'], PDO::PARAM_INT);
            $stmt->bindParam(':suc_chua', $data['suc_chua'], PDO::PARAM_INT);
            $stmt->bindParam(':khung_gio', $data['khung_gio'], PDO::PARAM_STR);
            $stmt->bindParam(':ban_con_trong', $data['ban_con_trong'], PDO::PARAM_INT);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);

            return $stmt->execute();
        } catch (PDOException $e) {
            throw new Exception("Lỗi CSDL khi cập nhật chi nhánh: " . $e->getMessage());
        }
    }

    public function deleteBranch($id) {
        try {
            $sql = "DELETE FROM chinhanh WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            throw new Exception("Lỗi CSDL khi xóa chi nhánh: " . $e->getMessage());
        }
    }
}
?>
