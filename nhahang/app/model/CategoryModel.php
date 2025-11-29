<?php
class CategoryModel {
    private $conn;

    public function __construct() {
        global $conn;
        if (!isset($conn) || $conn === null) {
            require_once __DIR__ . '/../config/database.php';
            $conn = $GLOBALS['conn'];
        }
        
        if (!isset($conn) || $conn === null) {
            throw new Exception("Kết nối database không tồn tại. Vui lòng kiểm tra file config/database.php");
        }
        
        $this->conn = $conn;
    }
    public function getAllCategories() {
        try {
            $sql = "SELECT id_danh_muc_mon, ten_danh_muc, mo_ta FROM danh_muc_mon ORDER BY id_danh_muc_mon";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Lỗi truy vấn database: " . $e->getMessage());
        }
    }
    public function getCategoryById($id) {
        try {
            $sql = "SELECT id_danh_muc_mon, ten_danh_muc, mo_ta FROM danh_muc_mon WHERE id_danh_muc_mon = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Lỗi truy vấn database: " . $e->getMessage());
        }
    }

    // Đếm số món ăn trong mỗi danh mục
    public function getCategoriesWithCount() {
        try {
            $sql = "SELECT dm.id_danh_muc_mon, dm.ten_danh_muc, dm.mo_ta, COUNT(m.id_mon) as so_luong_mon
                    FROM danh_muc_mon dm
                    LEFT JOIN mon_an m ON dm.id_danh_muc_mon = m.id_danh_muc_mon
                    GROUP BY dm.id_danh_muc_mon, dm.ten_danh_muc, dm.mo_ta
                    ORDER BY dm.id_danh_muc_mon";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Lỗi truy vấn database: " . $e->getMessage());
        }
    }
}