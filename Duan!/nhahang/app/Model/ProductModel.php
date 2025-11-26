<?php
class ProductModel {
    private $db;
    private $table = 'mon_an';

    public function __construct($db) {
        $this->db = $db;
    }

    public function getAllProduct() {
    $sql = "SELECT m.*, dm.ten_danh_muc 
            FROM " . $this->table . " m
            LEFT JOIN danh_muc_mon dm ON m.id_danh_muc_mon = dm.id_danh_muc_mon";
        return $this->db->get_all($sql);
    }

    public function getProductById($id) {
        $sql = "SELECT * FROM " . $this->table . " WHERE id_mon = :id";
        return $this->db->get_row($sql, ['id' => $id]);
    }

    public function addProduct($name, $price, $description, $cat_id, $image) {
        $sql = "INSERT INTO " . $this->table . 
               " (ten_mon, gia, mo_ta, id_danh_muc_mon, hinh_anh) 
               VALUES (:name, :price, :description, :cat_id, :image)";
               
        $params = [
            'name' => $name, 
            'price' => $price, 
            'description' => $description,
            'cat_id' => $cat_id,
            'image' => $image 
        ];
        return $this->db->action($sql, $params);
    }

    public function updateProduct($id, $name, $price, $description, $cat_id, $image, $status = 'Còn hàng') {
        $sql = "UPDATE " . $this->table . 
               " SET ten_mon = :name, gia = :price, mo_ta = :description, 
                   id_danh_muc_mon = :cat_id, hinh_anh = :image, trang_thai = :status
               WHERE id_mon = :id";
               
        $params = [
            'id' => $id, 
            'name' => $name, 
            'price' => $price, 
            'description' => $description,
            'cat_id' => $cat_id,
            'image' => $image,
            'status' => $status 
        ];
        return $this->db->action($sql, $params);
    }

    public function deleteProduct($id) {
        $sql = "DELETE FROM " . $this->table . " WHERE id_mon = :id";
        return $this->db->action($sql, ['id' => $id]);
    }

}
?>