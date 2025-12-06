<?php
class AdminModel {
    private $conn;
    private $table = 'admin';

    public function __construct() {
        // Đường dẫn đến file database.php có thể cần điều chỉnh tùy cấu trúc
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
            throw new Exception("Lỗi CSDL khi tìm Admin theo ID: " . $e->getMessage());
        }
    }
    
    /**
     * Lấy thông tin từ email (Quan trọng cho Login)
     */
    public function getAdminByEmail($email) {
        try {
            // Truy vấn tất cả các cột cần thiết cho việc kiểm tra
            $sql = "SELECT id_admin, ten, email, mat_khau, vai_tro, trang_thai_hoat_dong FROM " . $this->table . " WHERE email = :email";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Lỗi CSDL khi tìm Admin: " . $e->getMessage());
        }
    }
    
    /**
     * Cập nhật mật khẩu admin (Hàm MỚI để lưu hash)
     */
    public function updatePassword($id, $hashed_password) {
        try {
            $sql = "UPDATE " . $this->table . " SET mat_khau = :mat_khau WHERE id_admin = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':mat_khau', $hashed_password);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            throw new Exception("Lỗi CSDL khi cập nhật mật khẩu: " . $e->getMessage());
        }
    }

    /**
     * Xử lý thêm Admin mới
     */
    public function addAdmin($ten, $email, $mat_khau, $vai_tro, $trang_thai_hoat_dong) {
        try {
            // 1. Kiểm tra email đã tồn tại chưa
            if ($this->getAdminByEmail($email)) {
                throw new Exception("Email đã được sử dụng. Vui lòng chọn email khác.");
            }

            // 2. Băm (Hash) mật khẩu trước khi lưu
            $hashed_password = password_hash($mat_khau, PASSWORD_DEFAULT);

            // 3. Thực hiện Insert
            $sql = "INSERT INTO " . $this->table . " (ten, email, mat_khau, vai_tro, trang_thai_hoat_dong) VALUES (:ten, :email, :mat_khau, :vai_tro, :trang_thai_hoat_dong)";
            $stmt = $this->conn->prepare($sql);
            
            $stmt->bindParam(':ten', $ten);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':mat_khau', $hashed_password);
            $stmt->bindParam(':vai_tro', $vai_tro);
            $stmt->bindParam(':trang_thai_hoat_dong', $trang_thai_hoat_dong, PDO::PARAM_INT);
            
            return $stmt->execute();
        } catch (PDOException $e) {
             // Lỗi 23000 (Duplicate entry) cũng đã được xử lý bằng check email thủ công ở trên.
            throw new Exception("Lỗi CSDL khi thêm Admin: " . $e->getMessage());
        }
    }

    /**
     * Xử lý cập nhật Admin
     */
    public function updateAdmin($id, $ten, $email, $vai_tro, $trang_thai_hoat_dong, $mat_khau = null) {
        try {
            $sql = "UPDATE " . $this->table . " SET ten = :ten, email = :email, vai_tro = :vai_tro, trang_thai_hoat_dong = :trang_thai_hoat_dong";
            $params = [
                ':id' => $id,
                ':ten' => $ten,
                ':email' => $email,
                ':vai_tro' => $vai_tro,
                ':trang_thai_hoat_dong' => $trang_thai_hoat_dong
            ];

            // Nếu có mật khẩu mới, băm và thêm vào câu truy vấn
            if ($mat_khau !== null && !empty($mat_khau)) {
                $hashed_password = password_hash($mat_khau, PASSWORD_DEFAULT);
                $sql .= ", mat_khau = :mat_khau";
                $params[':mat_khau'] = $hashed_password;
            }

            $sql .= " WHERE id_admin = :id";
            
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute($params);
        } catch (PDOException $e) {
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