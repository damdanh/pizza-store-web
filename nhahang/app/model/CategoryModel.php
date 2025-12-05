<?php
class CategoryModel {
    private $conn;

    public function __construct() {

        global $conn;
        if (!isset($conn) || $conn === null) {
            require_once __DIR__ . '/../config/database.php';
            $conn = getConnection();
        }

        // 1. Chỉ cần require file chứa hàm getConnection()
        require_once __DIR__ . '/../config/database.php'; 

        
        // 2. GỌI HÀM để lấy đối tượng PDO
        try {
            // Đảm bảo hàm getConnection() đã được load từ file require_once
            $this->conn = getConnection(); 

        } catch (\Exception $e) {
            // Xử lý lỗi nếu getConnection() bị lỗi kết nối
            throw new Exception("Kết nối database không tồn tại. Vui lòng kiểm tra file config/database.php");
        }
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

     public function createCategory($ten_danh_muc, $mo_ta = '') {
        try {
            if (empty($ten_danh_muc)) {
                throw new Exception("Tên danh mục không được để trống.");
            }
            
            $sql = "INSERT INTO danh_muc_mon (ten_danh_muc, mo_ta) VALUES (:ten_danh_muc, :mo_ta)";
            $stmt = $this->conn->prepare($sql);

            $stmt->bindParam(':ten_danh_muc', $ten_danh_muc, PDO::PARAM_STR);
            $stmt->bindParam(':mo_ta', $mo_ta, PDO::PARAM_STR);

            return $stmt->execute(); // Trả về true/false
        } catch (PDOException $e) {
             // In ra lỗi chi tiết để debug
             error_log("Lỗi SQL khi thêm danh mục: " . $e->getMessage());
             throw new Exception("Lỗi Database khi thêm nhóm món: " . $e->getMessage());
        }
    }

     public function updateCategory($id, $ten_danh_muc, $mo_ta) {
        try {
            if (empty($ten_danh_muc)) {
                throw new Exception("Tên danh mục không được để trống.");
            }

            $sql = "UPDATE danh_muc_mon SET ten_danh_muc = :ten, mo_ta = :mo_ta WHERE id_danh_muc_mon = :id";
            $stmt = $this->conn->prepare($sql);

            $stmt->bindParam(':ten', $ten_danh_muc, PDO::PARAM_STR);
            $stmt->bindParam(':mo_ta', $mo_ta, PDO::PARAM_STR);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);

            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Lỗi SQL khi cập nhật danh mục: " . $e->getMessage());
            throw new Exception("Lỗi Database khi cập nhật nhóm món: " . $e->getMessage());
        }
    }

     public function deleteCategory($id) {
        try {
            // Kiểm tra ràng buộc khoá ngoại trước khi xoá (ví dụ: món ăn)
            // Nếu có món ăn thuộc danh mục này, SQL có thể bị lỗi (FOREIGN KEY constraint) 
            // trừ khi bạn thiết lập ON DELETE CASCADE.
            
            $sql = "DELETE FROM danh_muc_mon WHERE id_danh_muc_mon = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);

            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Lỗi SQL khi xóa danh mục: " . $e->getMessage());
            // Thông báo lỗi thân thiện hơn cho người dùng cuối
            if ($e->getCode() == '23000') {
                 throw new Exception("Không thể xóa nhóm món này vì có món ăn liên quan đang sử dụng.");
            }
            throw new Exception("Lỗi Database khi xóa nhóm món: " . $e->getMessage());
        }
    }
}