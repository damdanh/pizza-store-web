<?php
class CategoryModel {
    private $db;
    private $table = 'danh_muc_mon';

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getAllCategories()
    {
        $sql = "SELECT * FROM " . $this->table;
        return $this->db->get_all($sql);
    }
    public function getCategoryById($id)
    {
        $sql = "SELECT * FROM " . $this->table . " WHERE id_danh_muc_mon = :id";
        return $this->db->get_row($sql, ['id' => $id]);
    }

    public function addCategory($name, $description)
    {
        $sql = "INSERT INTO " . $this->table . " (ten_danh_muc, mo_ta) VALUES (:name, :description)";
        return $this->db->action($sql, ['name' => $name, 'description' => $description]);
    }

    public function updateCategory($id, $name, $description)
    {
        $sql = "UPDATE " . $this->table . " SET ten_danh_muc = :name, mo_ta = :description WHERE id_danh_muc_mon = :id";
        return $this->db->action($sql, ['id' => $id, 'name' => $name, 'description' => $description]);
    }

    public function deleteCategory($id)
    {
        $sql = "DELETE FROM " . $this->table . " WHERE id_danh_muc_mon = :id";
        return $this->db->action($sql, ['id' => $id]);
    }
}
?>