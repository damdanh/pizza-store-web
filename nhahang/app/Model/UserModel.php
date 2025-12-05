<?php
class UserModel {
    private $db; 
    private $table = 'khach_hang';

    public function __construct($db) {
        $this->db = $db;
    }

    public function getAllUsers() {
        $sql = "SELECT id_khach_hang, ten, sdt, email, trang_thai_tai_khoan FROM " . $this->table;
        return $this->db->get_all($sql);
    }

    public function getUserById($id) {
        $sql = "SELECT * FROM " . $this->table . " WHERE id_khach_hang = :id";
        return $this->db->get_row($sql, ['id' => $id]);
    }

    public function addUser($ten, $sdt, $email, $mat_khau) {
        $hashed_password = password_hash($mat_khau, PASSWORD_DEFAULT); 
        
        $sql = "INSERT INTO " . $this->table . 
               " (ten, sdt, email, mat_khau) 
               VALUES (:ten, :sdt, :email, :mat_khau)";
               
        $params = [
            'ten' => $ten, 
            'sdt' => $sdt, 
            'email' => $email,
            'mat_khau' => $hashed_password 
        ];
        return $this->db->action($sql, $params);
    }

    public function updateUser($id, $ten, $sdt, $email, $trang_thai) {
        $sql = "UPDATE " . $this->table . 
               " SET ten = :ten, sdt = :sdt, email = :email, trang_thai_tai_khoan = :trang_thai
               WHERE id_khach_hang = :id";
               
        $params = [
            'id' => $id, 
            'ten' => $ten, 
            'sdt' => $sdt, 
            'email' => $email,
            'trang_thai' => $trang_thai
        ];
        return $this->db->action($sql, $params);
    }

    public function deleteUser($id) {
        $sql = "DELETE FROM " . $this->table . " WHERE id_khach_hang = :id";
        return $this->db->action($sql, ['id' => $id]);
    }
}
?>
<!-- login admin -->
 