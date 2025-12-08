<?php

class ProductModel {
    private $conn;
    private $hasIsHidden; // Thêm thuộc tính để lưu trạng thái cột is_hidden

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
        // Kiểm tra xem cột is_hidden có tồn tại không để tránh lỗi trên DB cũ
        try {
            $stmt = $this->conn->query("SHOW COLUMNS FROM `mon_an` LIKE 'is_hidden'");
            $this->hasIsHidden = ($stmt && $stmt->fetch() !== false);
        } catch (Exception $e) {
            $this->hasIsHidden = false;
        }
    }

    /**
     * Trả về điều kiện WHERE để lọc món ẩn nếu cột is_hidden tồn tại
     */
    private function hiddenCondition($alias = 'm') {
        if (!empty($this->hasIsHidden)) {
            return " AND ({$alias}.is_hidden = 0 OR {$alias}.is_hidden IS NULL)";
        }
        return "";
    }

    /**
     * Trả về điều kiện WHERE để lọc món ẩn nếu cột is_hidden tồn tại
     */
    private function hiddenCondition($alias = 'm') {
        if (!empty($this->hasIsHidden)) {
            // Trả về điều kiện lọc: không ẩn (0) HOẶC NULL (cho các bản ghi cũ)
            return " AND ({$alias}.is_hidden = 0 OR {$alias}.is_hidden IS NULL)";
        }
        return "";
    }

    // --- Phương thức Đọc (READ) ---
    public function getPopularProducts($limit = 10) {
        try {
                $sql = "SELECT id_mon, ten_mon, gia, hinh_anh, mo_ta, trang_thai
                    FROM mon_an 
                    WHERE trang_thai = 'Còn hàng'" . $this->hiddenCondition('') . "
                    ORDER BY id_mon ASC 
                    LIMIT $limit";
            
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Lỗi truy vấn database: " . $e->getMessage());
        }
    }

    public function getAllProducts() {
        try {
            // Mặc định: chỉ trả về món không ẩn. Để admin muốn xem món ẩn, dùng getAllProducts(true) hoặc getAllProducts(true, true)
                $sql = "SELECT m.*, dm.ten_danh_muc 
                    FROM mon_an m
                    LEFT JOIN danh_muc_mon dm ON m.id_danh_muc_mon = dm.id_danh_muc_mon
                    WHERE 1=1" . $this->hiddenCondition('m') . "
                    ORDER BY m.id_mon ASC";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Lỗi truy vấn database: " . $e->getMessage());
        }
    }

  
    public function getProductById($id, $includeHidden = false) {
        try {
            $sql = "SELECT m.*, dm.ten_danh_muc 
                    FROM mon_an m
                    LEFT JOIN danh_muc_mon dm ON m.id_danh_muc_mon = dm.id_danh_muc_mon
                    WHERE m.id_mon = :id";
            if (!$includeHidden) {
                $sql .= $this->hiddenCondition('m');
            }
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
                    WHERE m.id_danh_muc_mon = :categoryId" . $this->hiddenCondition('m') . "
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
                // Nếu DB chưa có cột is_hidden thì không chèn tham số này
                if (!empty($this->hasIsHidden)) {
                $sql = "INSERT INTO mon_an (ten_mon, gia, hinh_anh, mo_ta, trang_thai, id_danh_muc_mon, is_hidden) 
                    VALUES (:ten_mon, :gia, :hinh_anh, :mo_ta, :trang_thai, :id_danh_muc_mon, :is_hidden)";
                } else {
                $sql = "INSERT INTO mon_an (ten_mon, gia, hinh_anh, mo_ta, trang_thai, id_danh_muc_mon) 
                    VALUES (:ten_mon, :gia, :hinh_anh, :mo_ta, :trang_thai, :id_danh_muc_mon)";
                }
            $stmt = $this->conn->prepare($sql);
            
            // Liên kết các tham số
            $stmt->bindParam(':ten_mon', $data['ten_mon']);
            $stmt->bindParam(':gia', $data['gia']);
            $stmt->bindParam(':hinh_anh', $data['hinh_anh']);
            $stmt->bindParam(':mo_ta', $data['mo_ta']);
            $stmt->bindParam(':trang_thai', $data['trang_thai']);
            $stmt->bindParam(':id_danh_muc_mon', $data['id_danh_muc_mon'], PDO::PARAM_INT);
            if (!empty($this->hasIsHidden)) {
                $isHidden = isset($data['is_hidden']) ? (int)$data['is_hidden'] : 0;
                $stmt->bindParam(':is_hidden', $isHidden, PDO::PARAM_INT);
            }

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
            // Nếu DB có is_hidden thì cập nhật trường này, nếu không thì bỏ qua
            if (!empty($this->hasIsHidden)) {
                $sql = "UPDATE mon_an 
                        SET ten_mon = :ten_mon, 
                            gia = :gia, 
                            hinh_anh = :hinh_anh, 
                            mo_ta = :mo_ta, 
                            trang_thai = :trang_thai, 
                            id_danh_muc_mon = :id_danh_muc_mon,
                            is_hidden = :is_hidden
                        WHERE id_mon = :id";
            } else {
                $sql = "UPDATE mon_an 
                        SET ten_mon = :ten_mon, 
                            gia = :gia, 
                            hinh_anh = :hinh_anh, 
                            mo_ta = :mo_ta, 
                            trang_thai = :trang_thai, 
                            id_danh_muc_mon = :id_danh_muc_mon
                        WHERE id_mon = :id";
            }
            $stmt = $this->conn->prepare($sql);
            
            // Liên kết các tham số
            $stmt->bindParam(':ten_mon', $data['ten_mon']);
            $stmt->bindParam(':gia', $data['gia']);
            $stmt->bindParam(':hinh_anh', $data['hinh_anh']);
            $stmt->bindParam(':mo_ta', $data['mo_ta']);
            $stmt->bindParam(':trang_thai', $data['trang_thai']);
            $stmt->bindParam(':id_danh_muc_mon', $data['id_danh_muc_mon'], PDO::PARAM_INT);
            if (!empty($this->hasIsHidden)) {
                $isHidden = isset($data['is_hidden']) ? (int)$data['is_hidden'] : 0;
                $stmt->bindParam(':is_hidden', $isHidden, PDO::PARAM_INT);
            }
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);

            $stmt->execute();
            
            // Trả về số lượng hàng bị ảnh hưởng
            return $stmt->rowCount();
        } catch (PDOException $e) {
            throw new Exception("Lỗi cập nhật sản phẩm trong database: " . $e->getMessage());
        }
    }
    // Thay vì xóa vật lý, ẩn sản phẩm bằng cột is_hidden = 1
    public function hideProduct($id) {
        try {
            if (empty($this->hasIsHidden)) {
                throw new Exception('Cột is_hidden chưa tồn tại. Hãy chạy migration add_is_hidden_to_mon_an.sql.');
            }
            $sql = "UPDATE mon_an SET is_hidden = 1 WHERE id_mon = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->rowCount();
        } catch (PDOException $e) {
            throw new Exception("Lỗi ẩn sản phẩm: " . $e->getMessage());
        }
    }

    public function unhideProduct($id) {
        try {
            if (empty($this->hasIsHidden)) {
                throw new Exception('Cột is_hidden chưa tồn tại. Hãy chạy migration add_is_hidden_to_mon_an.sql.');
            }
            $sql = "UPDATE mon_an SET is_hidden = 0 WHERE id_mon = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->rowCount();
        } catch (PDOException $e) {
            throw new Exception("Lỗi hiện lại sản phẩm: " . $e->getMessage());
        }
    }

    // Lấy các món đã bị ẩn (dành cho trang admin khi muốn hiển thị món đã ẩn)
    public function getHiddenProducts() {
        try {
            if (empty($this->hasIsHidden)) {
                return [];
            }
            $sql = "SELECT m.*, dm.ten_danh_muc 
                    FROM mon_an m
                    LEFT JOIN danh_muc_mon dm ON m.id_danh_muc_mon = dm.id_danh_muc_mon
                    WHERE m.is_hidden = 1
                    ORDER BY m.id_mon ASC";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Lỗi lấy danh sách món ẩn: " . $e->getMessage());
        }
    }

    public function unhideProduct($id) {
        try {
            if (empty($this->hasIsHidden)) {
                throw new Exception('Cột is_hidden chưa tồn tại. Hãy chạy migration add_is_hidden_to_mon_an.sql.');
            }
            $sql = "UPDATE mon_an SET is_hidden = 0 WHERE id_mon = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->rowCount();
        } catch (PDOException $e) {
            throw new Exception("Lỗi hiện lại sản phẩm: " . $e->getMessage());
        }
    }

    // Lấy các món đã bị ẩn (dành cho trang admin khi muốn hiển thị món đã ẩn)
    public function getHiddenProducts() {
        try {
            if (empty($this->hasIsHidden)) {
                return [];
            }
            $sql = "SELECT m.*, dm.ten_danh_muc 
                    FROM mon_an m
                    LEFT JOIN danh_muc_mon dm ON m.id_danh_muc_mon = dm.id_danh_muc_mon
                    WHERE m.is_hidden = 1
                    ORDER BY m.id_mon ASC";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Lỗi lấy danh sách món ẩn: " . $e->getMessage());
        }
    }
}