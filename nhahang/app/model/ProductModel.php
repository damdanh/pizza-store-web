<?php

class ProductModel {
    private $conn;

    public function __construct() {
        global $conn;
        if (!isset($conn) || $conn === null) {
            // Include database config nếu chưa có
            if (!function_exists('getConnection')) {
                // Tốt hơn nên sử dụng đường dẫn tuyệt đối để tránh lỗi
                require_once __DIR__ . '/../config/database.php';
            }
            $conn = getConnection();
        }
        
        $this->conn = $conn;
    }

    // --- Phương thức Đọc (READ) ---
    public function getPopularProducts($limit = 10) {
        try {
            // Sửa lỗi: PDO::PARAM_INT phải được dùng cho LIMIT. 
            // Tuy nhiên, LIMIT cần được truyền trực tiếp vì PDO không hỗ trợ bindParam cho LIMIT clause.
            // Để an toàn, chúng ta ép kiểu (cast) về integer.
            $limit = (int) $limit; 
            
            $sql = "SELECT id_mon, ten_mon, gia, hinh_anh, mo_ta, trang_thai
                    FROM mon_an 
                    WHERE trang_thai = 'Còn hàng' 
                    ORDER BY id_mon ASC 
                    LIMIT $limit"; // KHÔNG DÙNG bindParam cho LIMIT
            
            $stmt = $this->conn->prepare($sql);
            // $stmt->bindParam(':limit', $limit, PDO::PARAM_INT); // Bỏ dòng này
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // Ghi log lỗi thay vì chỉ ném Exception
            // error_log("Lỗi PDO trong getPopularProducts: " . $e->getMessage()); 
            throw new Exception("Lỗi truy vấn database: " . $e->getMessage());
        }
    }

    public function getAllProducts() {
        try {
            $sql = "SELECT m.*, dm.ten_danh_muc 
                    FROM mon_an m
                    LEFT JOIN danh_muc_mon dm ON m.id_danh_muc_mon = dm.id_danh_muc_mon
                    ORDER BY m.id_mon ASC";
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

    // --- Phương thức Thêm (CREATE) ---
    public function createProduct($data) {
        try {
            $sql = "INSERT INTO mon_an (ten_mon, gia, hinh_anh, mo_ta, trang_thai, id_danh_muc_mon) 
                    VALUES (:ten_mon, :gia, :hinh_anh, :mo_ta, :trang_thai, :id_danh_muc_mon)";
            $stmt = $this->conn->prepare($sql);
            
            // Liên kết các tham số
            // Lưu ý: Giá trị tiền tệ (gia) thường nên được bind là string hoặc float/decimal
            $stmt->bindParam(':ten_mon', $data['ten_mon']);
            $stmt->bindParam(':gia', $data['gia']);
            $stmt->bindParam(':hinh_anh', $data['hinh_anh']);
            $stmt->bindParam(':mo_ta', $data['mo_ta']);
            $stmt->bindParam(':trang_thai', $data['trang_thai']);
            $stmt->bindParam(':id_danh_muc_mon', $data['id_danh_muc_mon'], PDO::PARAM_INT);

            $stmt->execute();
            
            // Trả về ID của bản ghi vừa được tạo
            return $this->conn->lastInsertId();
        } catch (PDOException $e) {
            throw new Exception("Lỗi thêm sản phẩm vào database: " . $e->getMessage());
        }
    }

    // --- Phương thức Cập nhật (UPDATE) ---
    public function updateProduct($id, $data) {
        try {
            $sql = "UPDATE mon_an 
                    SET ten_mon = :ten_mon, 
                        gia = :gia, 
                        hinh_anh = :hinh_anh, 
                        mo_ta = :mo_ta, 
                        trang_thai = :trang_thai, 
                        id_danh_muc_mon = :id_danh_muc_mon
                    WHERE id_mon = :id";
            $stmt = $this->conn->prepare($sql);
            
            // Liên kết các tham số
            $stmt->bindParam(':ten_mon', $data['ten_mon']);
            $stmt->bindParam(':gia', $data['gia']);
            $stmt->bindParam(':hinh_anh', $data['hinh_anh']);
            $stmt->bindParam(':mo_ta', $data['mo_ta']);
            $stmt->bindParam(':trang_thai', $data['trang_thai']);
            $stmt->bindParam(':id_danh_muc_mon', $data['id_danh_muc_mon'], PDO::PARAM_INT);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);

            $stmt->execute();
            
            // Trả về số lượng hàng bị ảnh hưởng
            return $stmt->rowCount();
        } catch (PDOException $e) {
            throw new Exception("Lỗi cập nhật sản phẩm trong database: " . $e->getMessage());
        }
    }

    // --- Phương thức Xóa (DELETE) ---
    public function deleteProduct($id) {
        try {
            $sql = "DELETE FROM mon_an WHERE id_mon = :id";
            $stmt = $this->conn->prepare($sql);
            
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);

            $stmt->execute();
            
            // Trả về số lượng hàng bị ảnh hưởng
            return $stmt->rowCount();
        } catch (PDOException $e) {
            throw new Exception("Lỗi xóa sản phẩm khỏi database: " . $e->getMessage());
        }
    }
} // <--- Dấu đóng lớp đã được di chuyển xuống đây.