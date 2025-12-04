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
    $this->db = $db_object;
    $this->user = new UserModel($this->db);
  }
  public function home(){
    $dssp = $this->sanpham->getAllProducts();  
    $dsuser = $this->user->getAllUsers();
    include '../app/view/admin/admin.php';
  }

  public function products(){
    $dsdm = $this->danhmuc->getAllCategories();
    $sp_edit = null;
    include '../app/view/admin/menu.php';
    /* ================== 1. XÓA SẢN PHẨM ================== */
    if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
        $this->sanpham->remove_sp($_GET['id']);
        header("Location: admin.php?page=product");
        exit;
    }
  } 

  public function cauhinh(){
        include '../app/view/admin/cauhinh.php';
    }
}
?>