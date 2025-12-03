<?php
require 'nhahang/app/Model/CategoryModel.php';
require 'nhahang/app/Model/ProductModel.php';
require 'nhahang/app/Model/UserModel.php';
  class AdminController {
  public $danhmuc;
  public $sanpham;
  public $user;
  public $db;
  public function __construct($db_object){
    $this->danhmuc = new CategoryModel();
    $this->sanpham = new ProductModel();
    $this->user = new UserModel($this->db);
  }
    public function home(){
    //   $dssp = $this->sanpham->getall_sp();  
    // $dsuser = $this->user->getAllUsers();
    include '../app/view/admin/admin.php';
  }
    public function cauhinh(){
        include '../app/view/admin/cauhinh.php';
    }
}
?>