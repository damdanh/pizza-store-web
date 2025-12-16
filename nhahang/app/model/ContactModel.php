<?php
class ContactModel {
    private $conn;

    public function __construct() {
        global $conn;
        $this->conn = $conn;
    }

    public function insertContact($hoTen, $sdt, $email, $noiDung) {
        $sql = "INSERT INTO contact (ho_ten, sdt, email, noi_dung) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$hoTen, $sdt, $email, $noiDung]);
    }
}
