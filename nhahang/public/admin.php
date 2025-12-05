<?php
include "../app/controller/AdminController.php";
    $controller = new AdminController();
include "../app/view/admin/views/layouts/header.php";
include "../app/view/admin/views/layouts/sidebar.php";

if (!isset($_GET['page'])){
        header('location:admin.php?page=dashboard');
    }else{
        $page = $_GET['page'];
        $controller->$page();
    }

include "../app/view/admin/views/layouts/footer.php";
?>