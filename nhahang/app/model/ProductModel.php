<?php

class ProductModel {
    private $conn;

    public function __construct() {
        global $conn;
        if (!isset($conn) || $conn === null) {
            // Include database config nếu chưa có
            if (!function_exists('getConnection')) {
                require_once __DIR__ . '/../config/database.php';
            }
            $conn = getConnection();
        }
        
        $this->conn = $conn;
    }
    public function getPopularProducts($limit = 10) {
        try {
            $sql = "SELECT id_mon, ten_mon, gia, hinh_anh, mo_ta, trang_thai
                    FROM mon_an 
                    WHERE trang_thai = 'Còn hàng' 
                    ORDER BY id_mon ASC 
                    LIMIT :limit";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Lỗi truy vấn database: " . $e->getMessage());
        }
    }


    public function getAllProducts() {
        try {
            $sql = "SELECT m.*, dm.ten_danh_muc 
                    FROM mon_an m
                    LEFT JOIN danh_muc_mon dm ON m.id_danh_muc_mon = dm.id_danh_muc_mon
                    ORDER BY m.id_mon DESC";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Lỗi truy vấn database: " . $e->getMessage());
        }
    }

  
    public function getProductById($id) {
        try {
            $sql = "SELECT m.*, dm.ten_danh_muc 
                    FROM mon_an m
                    LEFT JOIN danh_muc_mon dm ON m.id_danh_muc_mon = dm.id_danh_muc_mon
                    WHERE m.id_mon = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Lỗi truy vấn database: " . $e->getMessage());
        }
    }

   
    public function getProductsByCategory($categoryId) {
        try {
            $sql = "SELECT m.*, dm.ten_danh_muc 
                    FROM mon_an m
                    LEFT JOIN danh_muc_mon dm ON m.id_danh_muc_mon = dm.id_danh_muc_mon
                    WHERE m.id_danh_muc_mon = :categoryId
                    ORDER BY m.id_mon ASC";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':categoryId', $categoryId, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Lỗi truy vấn database: " . $e->getMessage());
        }
    }
}
