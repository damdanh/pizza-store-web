<?php

require_once __DIR__ . '/../Model/CategoryModel.php'; 
require_once __DIR__ . '/../Model/ProductModel.php';
require_once __DIR__ . '/../Model/UserModel.php'; 

class AdminController
{
    public $danhmuc;
    public $sanpham;
    public $user;
    
    const ADMIN_VIEW_PATH = 'app/View/admin/';
    const ADMIN_LAYOUT_PATH = 'app/View/admin/layout/';
    
    const BASE_URL = '/WD20302-PRO1014_N5/nhahang/'; 

    public function __construct(){
        $this->danhmuc = new CategoryModel();
        $this->sanpham = new ProductModel();
        $this->user = new UserModel();
    }
    
    private function renderAdmin($viewFile, $data = []) {
        $data['base_url_path'] = self::BASE_URL; 
        
        extract($data); 
        
        $content_view = self::ADMIN_VIEW_PATH . $viewFile;
        
        require_once self::ADMIN_LAYOUT_PATH . 'main.php'; 
    }

    public function home(){
        
        $dssp = []; 
        $dsuser = [];
        
        $kpi = [
            'total_bookings' => 0, 
            'pending_bookings' => 0, 
            'total_dishes' => 0, 
            'total_branches' => 0, 
            'revenue_today' => 0, 
        ];
        
        $data = [
            'pageTitle' => 'Tổng Quan - Dashboard',
            'activePage' => 'home', 
            'kpi' => $kpi,
            'dssp' => $dssp,
            'dsuser' => $dsuser
        ];
        
        $this->renderAdmin('dashborad.php', $data); 
    }
    
    public function product(){
        if (isset($_POST['add_sp']) && ($_POST['add_sp'])) {
            if($_POST['n_pro'] != null) {
                $name = $_POST['n_pro'];
                $price = $_POST['price'];
                $cat_id = $_POST['cat_id'];
                $image = $_POST['product_image'];
                if(isset($_POST['idedit']) && $_POST['idedit'] != null){
                    $this->sanpham->update_sp($_POST['idedit'], $name, $price,  $cat_id, $image); 
                    header('location:admin.php?page=product');
                } else {
                    $this->sanpham->add_sp($name, $price,  $cat_id, $image);
                    header('location:admin.php?page=product');
                }
            }
        }
        
        if (isset($_GET['id'])) {
            $this->sanpham->remove_sp($_GET['id']);
            header('location:admin.php?page=product');
            exit();
        }

        $dssp = $this->sanpham->getall_sp();
        $sp_edit = null;
        if(isset($_GET['idedit'])){
            $sp_edit = $this->sanpham->get_sp_byID($_GET['idedit']);
        }
        
        $data = [
            'pageTitle' => 'Quản Lý Món Ăn',
            'activePage' => 'product',
            'dssp' => $dssp,
            'sp_edit' => $sp_edit,
        ];

        $this->renderAdmin('product.php', $data);
    }

    public function users(){
        if (isset($_POST['add_user']) && ($_POST['add_user'])) {
            if($_POST['n_user'] != null) {
                $name = $_POST['n_user'];
                $pass = $_POST['pass'];
                $email = $_POST['email']; 
                $sdt = $_POST['sdt']; 
                
                if(isset($_POST['idedit']) && $_POST['idedit'] != null){
                    $this->user->update_user($_POST['idedit'], $name, $sdt, $email, $_POST['trang_thai']); 
                    header('location:admin.php?page=users');
                } else {
                    $this->user->add_user($name, $sdt, $email, $pass);
                    header('location:admin.php?page=users');
                }
            }
        }
        
        if (isset($_GET['id'])) {
            $this->user->remove_user($_GET['id']);
            header('location:admin.php?page=users');
            exit();
        }

        $dsuser = $this->user->getAllUsers();
        $user_edit = null;
        if(isset($_GET['idedit'])){
            $user_edit = $this->user->getUserById($_GET['idedit']);
        }
        
        $data = [
            'pageTitle' => 'Quản Lý Người Dùng',
            'activePage' => 'users',
            'dsuser' => $dsuser,
            'user_edit' => $user_edit,
        ];

        $this->renderAdmin('users.php', $data);
    }

    public function updateProduct(){
        $data = [
            'pageTitle' => 'Cập Nhật Sản Phẩm',
            'activePage' => 'product',
        ];
        $this->renderAdmin('updateProduct.php', $data);
    }

    public function category(){
        if (isset($_POST['add_cat']) && ($_POST['add_cat'])) {
            if($_POST['cat_name'] != null){
                $name = $_POST['cat_name'];
                $description = $_POST['cat_des'];
                if(isset($_POST['idedit']) && $_POST['idedit'] != null){
                    $this->danhmuc->update_dm($_POST['idedit'], $name, $description);
                    header('location:admin.php?page=category');
                } else{
                    $this->danhmuc->add_dm($name, $description);
                    header('location:admin.php?page=category');
                }
            }
        }
        
        if (isset($_GET['id'])) {
            $this->danhmuc->remove_dm($_GET['id']);
            header('location:admin.php?page=category');
            exit();
        }
        
        $dsdm = $this->danhmuc->getAllCategories();
        
        $dm_edit = null;
        if(isset($_GET['idedit'])){
            $dm_edit = $this->danhmuc->getCategoryById($_GET['idedit']);
        }
        
        $data = [
            'pageTitle' => 'Quản Lý Danh Mục',
            'activePage' => 'category',
            'dsdm' => $dsdm,
            'dm_edit' => $dm_edit,
        ];
        
        $this->renderAdmin('category.php', $data);
    }

    public function quanlydatban(){
        $data = [
            'pageTitle' => 'Quản Lý Đặt Bàn',
            'activePage' => 'quanlydatban',
        ];
        $this->renderAdmin('quanlydatban.php', $data);
    }
    
    public function chinhanh(){
        $data = [
            'pageTitle' => 'Quản Lý Chi Nhánh',
            'activePage' => 'chinhanh',
        ];
        $this->renderAdmin('chinhanh.php', $data);
    }
    
    public function cauhinh(){
        $data = [
            'pageTitle' => 'Cấu Hình Hệ Thống',
            'activePage' => 'cauhinh',
        ];
        $this->renderAdmin('cauhinh.php', $data);
    }
}
?>