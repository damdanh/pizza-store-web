<?php
class AdminModel {
    private $conn;
    private $table = 'admin';

    public function __construct() {
        require_once __DIR__ . '/../config/database.php'; 
        try {
            $this->conn = getConnection(); 
        } catch (\Exception $e) {
            throw new Exception("Lỗi kết nối database: " . $e->getMessage());
        }
    }

    /**
     * Lấy tất cả tài khoản admin
     */
    public function getAllAdmins() {
        try {
            // Sửa đổi câu truy vấn để lấy các cột cần thiết cho trang admin.php
            // Đã đổi 'created_at' thành 'ngay_tao' theo cấu trúc CSDL giả định trong AdminModel.
            $sql = "SELECT id_admin, ten, email, vai_tro, created_at AS ngay_tao FROM " . $this->table . " ORDER BY created_at ASC";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Lỗi truy vấn CSDL: " . $e->getMessage());
        }
    }

    /**
     * Lấy thông tin từ id
     */
    public function getAdminById($id) {
        try {
            $sql = "SELECT id_admin, ten, email, vai_tro, trang_thai_hoat_dong FROM " . $this->table . " WHERE id_admin = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Lỗi CSDL khi lấy thông tin Admin: " . $e->getMessage());
        }
    }

    /**
     * Thêm admin mới vào CSDL
     */
    public function addAdmin($ten, $email, $mat_khau, $vai_tro, $trang_thai_hoat_dong = 1) {
    try {
        // Kiểm tra email đã tồn tại chưa
        $checkSql = "SELECT COUNT(*) FROM " . $this->table . " WHERE email = :email";
        $checkStmt = $this->conn->prepare($checkSql);
        $checkStmt->bindParam(':email', $email);
        $checkStmt->execute();
        if ($checkStmt->fetchColumn() > 0) {
            throw new Exception("Email đã tồn tại. Vui lòng chọn email khác.");
        }

        // Băm mật khẩu trước khi lưu
        $hashed_password = password_hash($mat_khau, PASSWORD_DEFAULT);
        
        // 1. Câu lệnh SQL định nghĩa placeholder là :trang_thai_hoat_dong
        $sql = "INSERT INTO " . $this->table . " (ten, email, mat_khau, vai_tro, trang_thai_hoat_dong, created_at) 
                VALUES (:ten, :email, :mat_khau, :vai_tro, :trang_thai_hoat_dong, NOW())"; 

        $stmt = $this->conn->prepare($sql);
        
        $stmt->bindParam(':ten', $ten);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':mat_khau', $hashed_password);
        $stmt->bindParam(':vai_tro', $vai_tro);
        
        // 2. SỬA LỖI: Tên placeholder trong bindParam() phải khớp chính xác với SQL
        $stmt->bindParam(':trang_thai_hoat_dong', $trang_thai_hoat_dong, PDO::PARAM_INT); 
        
        return $stmt->execute();
    } catch (PDOException $e) {
        // Lỗi 23000 thường là lỗi khóa duy nhất (unique constraint), ví dụ email đã tồn tại
        if ($e->getCode() == '23000') {
            throw new Exception("Email đã tồn tại. Vui lòng chọn email khác.");
        }
        throw new Exception("Lỗi CSDL khi thêm Admin: " . $e->getMessage());
    }
}

    /**
     * Cập nhật thông tin admin
     */
    public function updateAdmin($id, $ten, $email, $vai_tro, $trang_thai_hoat_dong, $mat_khau = null) {
        try {
            // Kiểm tra email trùng lặp (trừ email hiện tại của người dùng đang sửa)
            $checkSql = "SELECT COUNT(*) FROM " . $this->table . " WHERE email = :email AND id_admin != :id";
            $checkStmt = $this->conn->prepare($checkSql);
            $checkStmt->bindParam(':email', $email);
            $checkStmt->bindParam(':id', $id, PDO::PARAM_INT);
            $checkStmt->execute();
            if ($checkStmt->fetchColumn() > 0) {
                 throw new Exception("Email đã tồn tại. Vui lòng chọn email khác.");
            }

            $sql = "UPDATE " . $this->table . 
                   " SET ten = :ten, email = :email, vai_tro = :vai_tro, trang_thai_hoat_dong = :trang_thai_hoat_dong";
            $params = [
                ':id' => $id, 
                ':ten' => $ten, 
                ':email' => $email,
                ':vai_tro' => $vai_tro,
                ':trang_thai_hoat_dong' => $trang_thai_hoat_dong
            ];

            if ($mat_khau) {
                $hashed_password = password_hash($mat_khau, PASSWORD_DEFAULT);
                $sql .= ", mat_khau = :mat_khau";
                $params[':mat_khau'] = $hashed_password;
            }

            $sql .= " WHERE id_admin = :id";
            
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute($params);
        } catch (PDOException $e) {
             // Lỗi 23000 (Duplicate entry) cũng đã được xử lý bằng check email thủ công ở trên.
            throw new Exception("Lỗi CSDL khi cập nhật Admin: " . $e->getMessage());
        }
    }

    /**
     * Xóa admin
     */
    public function deleteAdmin($id) {
        try {
            $sql = "DELETE FROM " . $this->table . " WHERE id_admin = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            throw new Exception("Lỗi CSDL khi xóa Admin: " . $e->getMessage());
        }
    }
}