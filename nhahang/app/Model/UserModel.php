<?php
// app/model/UserModel.php (Đã sửa để dùng PDO chuẩn)

class UserModel {
    private $db; // Đây là đối tượng PDO được truyền vào từ UserController
    private $table = 'khach_hang';

    public function __construct($pdo) {
        $this->db = $pdo;
    }

 
    public function getUserByEmail(string $email) {
        $sql = "SELECT id_khach_hang, email, mat_khau FROM " . $this->table . " WHERE email = :email";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['email' => $email]);
        return $stmt->fetch(PDO::FETCH_ASSOC); 
    }
    
    // Lưu mã xác minh (OTP) và thời gian hết hạn
    public function saveResetCode(int $user_id, string $code, int $expires_at) {
        $sql = "UPDATE " . $this->table . 
               " SET ma_xac_minh = :code, reset_expires = :expires_at 
               WHERE id_khach_hang = :user_id";
        $params = [
            'code' => $code, 
            'expires_at' => $expires_at, 
            'user_id' => $user_id
        ];
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($params); // Sử dụng PDO chuẩn
    }

    // Kiểm tra mã xác minh và thời gian hết hạn
    public function validateResetCode(int $user_id, string $code): bool {
        $current_time = time();
        $sql = "SELECT id_khach_hang FROM " . $this->table . " 
                WHERE id_khach_hang = :user_id 
                AND ma_xac_minh = :code 
                AND reset_expires > :current_time";
        $params = [
            'user_id' => $user_id, 
            'code' => $code, 
            'current_time' => $current_time
        ];
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetch(PDO::FETCH_ASSOC) ? true : false; // Sử dụng PDO chuẩn
    }


    // Lưu token để cho phép cập nhật mật khẩu (Dùng cột tai_khoan_dang_nhap)
    public function saveResetToken(int $user_id, string $token) {
        $sql = "UPDATE " . $this->table . " SET tai_khoan_dang_nhap = :token WHERE id_khach_hang = :user_id";
        $params = ['token' => $token, 'user_id' => $user_id];
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($params); // Sử dụng PDO chuẩn
    }

    // Lấy người dùng bằng token reset
    public function getUserByResetToken(string $token): array|false {
        $sql = "SELECT id_khach_hang FROM " . $this->table . " WHERE tai_khoan_dang_nhap = :token";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['token' => $token]);
        return $stmt->fetch(PDO::FETCH_ASSOC); // Sử dụng PDO chuẩn
    }
    
    // Cập nhật mật khẩu mới
    public function updatePassword(int $user_id, string $hashed_password) {
        $sql = "UPDATE " . $this->table . " SET mat_khau = :mat_khau WHERE id_khach_hang = :user_id";
        $params = ['mat_khau' => $hashed_password, 'user_id' => $user_id];
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($params); // Sử dụng PDO chuẩn
    }

    // Xóa mã reset và token
    public function clearResetData(int $user_id) {
        $sql = "UPDATE " . $this->table . " SET ma_xac_minh = NULL, reset_expires = NULL, tai_khoan_dang_nhap = NULL WHERE id_khach_hang = :user_id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute(['user_id' => $user_id]); // Sử dụng PDO chuẩn
    }
    
    
}


?>

 
