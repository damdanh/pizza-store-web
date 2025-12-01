<?php
 include "app/controller/AdminController.php";
 $controller = new AdminController();
 include 'app/view/admin/layout/header.php';

//  include 'app/View/admin/home.php';
if(!isset($_GET['page'])){
    // include 'app/View/admin/home.php';
    header('location:admin.php?page=home');
  } else {
    $page = $_GET['page'];
    $controller -> $page();
  }

 include 'app/view/admin/layout/footer.php';
?>