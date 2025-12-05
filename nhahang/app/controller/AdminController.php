<?php
ob_start();
require_once __DIR__. '/../Model/CategoryModel.php';
require_once __DIR__. '/../Model/ProductModel.php';
require_once __DIR__. '/../Model/UserModel.php';

class AdminController {
    public $danhmuc;
    public $sanpham;
    public $user;
    public $db;

    public function __construct($db_object = null) {
        $this->danhmuc = new CategoryModel();
        $this->sanpham = new ProductModel();
        $this->db = $db_object;
        $this->user = new UserModel($this->db);
    }

    public function home(){
        $dssp = $this->sanpham->getAllProducts();
        // $dsuser = $this->user->getAllUsers();
        include '../app/view/admin/admin.php';
    }

    public function cauhinh(){
        include '../app/view/admin/cauhinh.php';
    }

    public function dashboard(){
        include '../app/view/admin/dashboard.php';
    }

    public function quanlydatban(){
        include '../app/view/admin/quanlydatban.php';
    }

    public function chinhanh(){
        include '../app/view/admin/chinhanh.php';
    }

    public function admin(){
        include '../app/view/admin/admin.php';
    }

    public function doanhthu(){
        include '../app/view/admin/doanhthu.php';
    }

    public function formDemo(){
        include '../app/view/admin/formDemo.php';
    }

    public function menu(){
    $dsdm = $this->danhmuc->getAllCategories();
    $dssp = $this->sanpham->getAllProducts();
    
    // Khởi tạo các biến nếu cần, ví dụ: $sp_edit, $dm

    /* ================== Xử lý LƯU NHÓM MÓN ================== */
    if (isset($_POST['save_category'])) {
        $ten_danh_muc = trim($_POST['category_name']);
        $mo_ta = trim($_POST['category_description'] ?? '');

        try {
            // Logic cập nhật (nếu có id) hoặc thêm mới
            // Hiện tại chỉ xử lý thêm mới:
            $this->danhmuc->createCategory($ten_danh_muc, $mo_ta);
            header("Location: admin.php?page=menu");
            exit;
        } catch (\Exception $e) {
            // Thêm logic xử lý lỗi tại đây nếu cần
            echo "<script>alert('Lỗi thêm nhóm món: " . $e->getMessage() . "');</script>";
        }
    }

    /* ================== 3. LƯU SẢN PHẨM (THÊM/SỬA) ================== */
    // Kiểm tra tên nút submit trong form themmonan.php là 'save_product'
    if (isset($_POST['save_product'])) {
        $product_id = isset($_POST['product_id']) ? $_POST['product_id'] : null;
        $name = $_POST['ten_mon'];
        $price = $_POST['gia'];
        $trang_thai = $_POST['trang_thai'];
        $cat_id = $_POST['category'];
        $mota = isset($_POST['mo_ta']) ? $_POST['mo_ta'] : '';

        // Xử lý ảnh
        $img = "";
        $upload_dir = "nhahang/app/public/img/";
        if (!empty($_FILES['img']['name'])) {
            $img = time() . "_" . basename($_FILES['img']['name']);
            // Kiểm tra và tạo thư mục nếu chưa có
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }
            move_uploaded_file($_FILES['img']['tmp_name'], $upload_dir . $img);
        } else {
            // Giữ lại ảnh cũ khi sửa nếu không upload ảnh mới
            $img = $_POST['old_img'] ?? ''; 
        }

        $data = [
            'ten_mon' => $name,
            'gia' => $price,
            'hinh_anh' => $img,
            'trang_thai' => $trang_thai,
            'id_danh_muc_mon' => $cat_id,
            'mo_ta' => $mota
        ];

        try {
            if ($product_id) {
                // Cập nhật sản phẩm
                $this->sanpham->updateProduct($product_id, $data);
            } else {
                // Thêm sản phẩm mới
                $this->sanpham->createProduct($data);
            }
            header("Location: admin.php?page=menu");
            exit;
        } catch (\Exception $e) {
             echo "<script>alert('Lỗi lưu sản phẩm: " . $e->getMessage() . "');</script>";
        }
    }

    /* ================== 1. XÓA SẢN PHẨM ================== */
    if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
        $this->sanpham->deleteProduct($_GET['id']);
        header("Location: admin.php?page=menu");
        exit;
    }

    /* ================== 2. SỬA SẢN PHẨM (HIỂN THỊ FORM) ================== */
    if (isset($_GET['action']) && $_GET['action'] == 'edit' && isset($_GET['id'])) {
        $sp_edit = $this->sanpham->getProductById($_GET['id']);
        $dsdm = $this->danhmuc->getAllCategories();
        include "../app/view/admin/themmonan.php";
        return;
    }

    /* ================== 4. THÊM NHÓM MÓN (HIỂN THỊ FORM) ================== */
    if (isset($_GET['action']) && $_GET['action'] == 'add_category') {
        $category_edit = null;
        include_once "../app/view/admin/themnhommon.php";
        return;
    }

    /* ================== 4. THÊM SẢN PHẨM (HIỂN THỊ FORM) ================== */
    if (isset($_GET['action']) && $_GET['action'] == 'add') {
        $dsdm = $this->danhmuc->getAllCategories();
        $sp_edit = null; 
        include_once  "../app/view/admin/themmonan.php";
        return;
    }
    $dssp = $this->sanpham->getAllProducts();
    include '../app/view/admin/menu.php';
}

    public function products(){
        $dsdm = $this->danhmuc->getAllCategories();
        $sp_edit = null;

       
    }
}
?>