<?php
class ProductModel {
    private $conn;
    private $hasIsHidden; // Thuộc tính để lưu trạng thái cột is_hidden

    public function __construct() {
        global $conn;
        if (!isset($conn) || $conn === null) {
            // Include database config nếu chưa có
            if (!function_exists('getConnection')) {
                require_once __DIR__ . '/../config/database.php';
            }
            // Giả sử getConnection() trả về kết nối PDO
            $conn = getConnection(); 
        }
        
        $this->conn = $conn;
        // Kiểm tra xem cột is_hidden có tồn tại không để tránh lỗi trên DB cũ
        try {
            // Sử dụng $this->conn->query() thay vì $this->conn->prepare() cho SHOW COLUMNS
            $stmt = $this->conn->query("SHOW COLUMNS FROM `mon_an` LIKE 'is_hidden'");
            // Lưu ý: fetch() sẽ trả về mảng nếu cột tồn tại, hoặc false nếu không
            $this->hasIsHidden = ($stmt && $stmt->fetch() !== false); 
        } catch (Exception $e) {
            // Bắt lỗi nếu bảng 'mon_an' không tồn tại hoặc lỗi truy vấn khác
            $this->hasIsHidden = false; 
            // Có thể thêm log lỗi ở đây
            // error_log("Lỗi kiểm tra cột is_hidden: " . $e->getMessage()); 
        }
    }

    /**
     * Trả về điều kiện WHERE để lọc món không ẩn nếu cột is_hidden tồn tại.
     */
    private function hiddenCondition($alias = 'm') {
        if ($this->hasIsHidden) {
            // Trả về điều kiện lọc: không ẩn (0) HOẶC NULL (cho các bản ghi cũ)
            // Nếu alias rỗng, không thêm dấu chấm
            $col = $alias ? "{$alias}.is_hidden" : "is_hidden";
            return " AND ({$col} = 0 OR {$col} IS NULL)";
        }
        return "";
    }

    // --- Phương thức Đọc (READ) ---
    public function getPopularProducts($limit = 10) {
        try {
            // Sử dụng alias rỗng vì không có join
            // Tối ưu hóa: ORDER BY theo một cột phù hợp hơn (ví dụ: số lượng bán, lượt xem) nếu có
            $sql = "SELECT id_mon, ten_mon, gia, hinh_anh, mo_ta, trang_thai
                    FROM mon_an 
                    WHERE trang_thai = 'Còn hàng'" . $this->hiddenCondition('') . "
                    ORDER BY id_mon ASC 
                    LIMIT :limit"; // Sử dụng tham số cho LIMIT để bảo mật và nhất quán
            
            $stmt = $this->conn->prepare($sql);
            // Liên kết tham số LIMIT
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

    public function createProduct($data) {
        try {
            // Sửa logic SQL để tránh lặp lại code: chỉ tạo chuỗi cột và tham số
            $columns = 'ten_mon, gia, hinh_anh, mo_ta, trang_thai, id_danh_muc_mon';
            $params = ':ten_mon, :gia, :hinh_anh, :mo_ta, :trang_thai, :id_danh_muc_mon';

            if ($this->hasIsHidden) {
                $columns .= ', is_hidden';
                $params .= ', :is_hidden';
            }

            $sql = "INSERT INTO mon_an ({$columns}) VALUES ({$params})";
            $stmt = $this->conn->prepare($sql);
            
            // Liên kết các tham số cơ bản
            $stmt->bindParam(':ten_mon', $data['ten_mon']);
            $stmt->bindParam(':gia', $data['gia']);
            $stmt->bindParam(':hinh_anh', $data['hinh_anh']);
            $stmt->bindParam(':mo_ta', $data['mo_ta']);
            $stmt->bindParam(':trang_thai', $data['trang_thai']);
            $stmt->bindParam(':id_danh_muc_mon', $data['id_danh_muc_mon'], PDO::PARAM_INT);

            if ($this->hasIsHidden) {
                // Đảm bảo is_hidden là số nguyên (0 hoặc 1)
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
            // Sửa logic SQL để tránh lặp lại code: chỉ tạo chuỗi SET
            $setClauses = "ten_mon = :ten_mon, 
                           gia = :gia, 
                           hinh_anh = :hinh_anh, 
                           mo_ta = :mo_ta, 
                           trang_thai = :trang_thai, 
                           id_danh_muc_mon = :id_danh_muc_mon";

            if ($this->hasIsHidden) {
                $setClauses .= ", is_hidden = :is_hidden";
            }

            $sql = "UPDATE mon_an SET {$setClauses} WHERE id_mon = :id";
            $stmt = $this->conn->prepare($sql);
            
            // Liên kết các tham số
            $stmt->bindParam(':ten_mon', $data['ten_mon']);
            $stmt->bindParam(':gia', $data['gia']);
            $stmt->bindParam(':hinh_anh', $data['hinh_anh']);
            $stmt->bindParam(':mo_ta', $data['mo_ta']);
            $stmt->bindParam(':trang_thai', $data['trang_thai']);
            $stmt->bindParam(':id_danh_muc_mon', $data['id_danh_muc_mon'], PDO::PARAM_INT);
            
            if ($this->hasIsHidden) {
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
    
    // --- Phương thức Xóa/Ẩn (DELETE/SOFT DELETE) ---
    
    // Thay vì xóa vật lý, ẩn sản phẩm bằng cột is_hidden = 1
    public function hideProduct($id) {
        try {
            if (!$this->hasIsHidden) {
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

    // *** Đã sửa lỗi: Phương thức này cần nằm trong Class ***
    public function unhideProduct($id) { 
        try {
            if (!$this->hasIsHidden) {
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

    // *** Đã sửa lỗi: Phương thức này cần nằm trong Class ***
    // Lấy các món đã bị ẩn (dành cho trang admin khi muốn hiển thị món đã ẩn)
    public function getHiddenProducts() {
        try {
            if (!$this->hasIsHidden) {
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