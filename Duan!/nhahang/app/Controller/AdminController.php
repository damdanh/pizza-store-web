<?php
class AdminController {
    private $db;
    private $DanhmucModel;
    private $SanphamModel;
    private $NguoidungModel;
    public function __construct($db){
        $this->db = $db;
        $this->DanhmucModel = new CategoryModel($db);
        $this->SanphamModel = new ProductModel($db);
        $this->NguoidungModel = new UserModel($db);
    }
}
?>