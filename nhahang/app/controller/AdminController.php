<?php
// require 'App/Model/category.php';
// require 'App/Model/product.php';
// require 'App/Model/user.php';
// require 'App/Model/order.php';
  class AdminController {
     public $danhmuc;
  public $sanpham;
  public $user;
  public $order;
    public function home(){
    //   $dssp = $this->sanpham->getall_sp();  
    // $dsuser = $this->user->getall_user();
    include 'app/view/admin/admin.php';
  }
    public function cauhinh(){
        include 'app/view/admin/cauhinh.php';
    }
}