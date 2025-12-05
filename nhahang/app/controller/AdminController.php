<?php
ob_start();
require_once __DIR__. '/../Model/CategoryModel.php';
require_once __DIR__. '/../Model/ProductModel.php';
// require_once __DIR__. '/../Model/UserModel.php';
require_once __DIR__. '/../Model/AdminModel.php';

class AdminController {
    public $danhmuc;
    public $sanpham;
    public $admin;
    // public $user;
    public $db;

    public function __construct($db_object = null) {
        $this->danhmuc = new CategoryModel();
        $this->sanpham = new ProductModel();
        $this->admin = new AdminModel();
        $this->db = $db_object;
        // $this->user = new UserModel($this->db);
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
        $trang_thai = $_POST['trang_thai_hoat_dong'];
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
            'trang_thai_hoat_dong' => $trang_thai_hoat_dong,
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

    public function admin() {
        // LƯU Ý: Phải gọi session_start() ở đầu admin.php để dùng $_SESSION
        $action = $_GET['action'] ?? 'list';
        $message = '';

        if (isset($_GET['error'])) {
            $message = $_GET['error'];
            $is_error = true;
        } else if (isset($_GET['msg'])) {
            $message = $_GET['msg'];
            $is_error = false;
        }

        /* ================== Xử lý THÊM ADMIN (HIỂN THỊ FORM) ================== */
        if ($action == 'add') {
            $old_data = $_SESSION['old_admin_data'] ?? [];
            unset($_SESSION['old_admin_data']);
            $admin_edit = null; // Đảm bảo biến này null khi thêm mới
            
            include_once "../app/view/admin/themadmin.php";
            return;
        }

        /* ================== Xử lý SỬA ADMIN (HIỂN THỊ FORM) ================== */
        if ($action == 'edit' && isset($_GET['id'])) {
            $id = $_GET['id'];
            $admin_edit = $this->admin->getAdminById($id);
            // Lấy dữ liệu cũ (old_data) để hiện thị lại thông báo lỗi nếu có
            $old_data = $_SESSION['old_admin_data'] ?? []; 
            unset($_SESSION['old_admin_data']);

            include_once "../app/view/admin/themadmin.php"; 
            return;
        }

        /* ================== Xử lý THÊM ADMIN (QUÁ TRÌNH XỬ LÝ POST) ================== */
        if ($action == 'add_process' && $_SERVER['REQUEST_METHOD'] === 'POST') {
            // Lấy dữ liệu từ form
            $ten = trim($_POST['ten'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $mat_khau = $_POST['mat_khau'] ?? '';
            $confirm_mat_khau = $_POST['confirm_mat_khau'] ?? '';
            $vai_tro = $_POST['vai_tro'] ?? '';
            // Giá trị của trang_thai sẽ là '1' nếu checkbox được chọn, hoặc '0' từ input hidden
            $trang_thai_hoat_dong = (int)($_POST['trang_thai_hoat_dong'] ?? 0); 

            // Lưu dữ liệu để load lại form nếu có lỗi
            $_SESSION['old_admin_data'] = [
                'ten' => $ten,
                'email' => $email,
                'vai_tro' => $vai_tro,
                'trang_thai_hoat_dong' => $trang_thai_hoat_dong
            ];

            // 1. Kiểm tra Validate
            if (empty($ten) || empty($email) || empty($mat_khau) || empty($confirm_mat_khau) || empty($vai_tro)) {
                $error_msg = "Vui lòng điền đầy đủ tất cả các trường có dấu (*).";
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error_msg = "Địa chỉ email không hợp lệ.";
            } elseif ($mat_khau !== $confirm_mat_khau) {
                $error_msg = "Mật khẩu và Xác nhận Mật khẩu không khớp.";
            } elseif (strlen($mat_khau) < 6) {
                $error_msg = "Mật khẩu phải có ít nhất 6 ký tự.";
            }

            if (isset($error_msg)) {
                // Quay lại trang add với thông báo lỗi
                header("Location: admin.php?page=admin&action=add&error=" . urlencode($error_msg));
                exit;
            }

            // 2. Xử lý Model
            try {
                $result = $this->admin->addAdmin($ten, $email, $mat_khau, $vai_tro, $trang_thai_hoat_dong);
                if ($result) {
                    $message = "Đã thêm tài khoản Admin mới thành công!";
                    unset($_SESSION['old_admin_data']); // Xóa dữ liệu cũ khi thành công
                } else {
                    $message = "Lỗi không xác định khi thêm Admin.";
                }
                // Chuyển hướng về trang danh sách Admin
                header("Location: admin.php?page=admin&msg=" . urlencode($message));
                exit;
            } catch (\Exception $e) {
                $error_msg = "Lỗi: " . $e->getMessage();
                // Chuyển hướng về trang add với lỗi chi tiết từ Model
                header("Location: admin.php?page=admin&action=add&error=" . urlencode($error_msg));
                exit;
            }
        }
        
        /* ================== Xử lý CẬP NHẬT ADMIN (QUÁ TRÌNH XỬ LÝ POST) ================== */
        if ($action == 'update_process' && $_SERVER['REQUEST_METHOD'] === 'POST') {
            // Lấy dữ liệu từ form
            $id = $_POST['id_admin'] ?? null;
            $ten = trim($_POST['ten'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $mat_khau = $_POST['mat_khau'] ?? ''; // Có thể là rỗng
            $confirm_mat_khau = $_POST['confirm_mat_khau'] ?? ''; // Có thể là rỗng
            $vai_tro = $_POST['vai_tro'] ?? '';
            $trang_thai_hoat_dong = (int)($_POST['trang_thai_hoat_dong'] ?? 0); 
            
             // Lưu dữ liệu để load lại form nếu có lỗi
            $_SESSION['old_admin_data'] = [
                'ten' => $ten,
                'email' => $email,
                'vai_tro' => $vai_tro,
                'trang_thai_hoat_dong' => $trang_thai_hoat_dong
            ];

            // 1. Kiểm tra Validate
            if (empty($id) || empty($ten) || empty($email) || empty($vai_tro)) {
                $error_msg = "Vui lòng điền đầy đủ Tên, Email, Vai trò.";
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error_msg = "Địa chỉ email không hợp lệ.";
            } elseif ($mat_khau !== $confirm_mat_khau) {
                $error_msg = "Mật khẩu và Xác nhận Mật khẩu không khớp.";
            } elseif (!empty($mat_khau) && strlen($mat_khau) < 6) {
                // Kiểm tra độ dài nếu người dùng có nhập mật khẩu
                $error_msg = "Mật khẩu phải có ít nhất 6 ký tự.";
            }

            if (isset($error_msg)) {
                // Quay lại trang edit với thông báo lỗi
                header("Location: admin.php?page=admin&action=edit&id=" . urlencode($id) . "&error=" . urlencode($error_msg));
                exit;
            }

            // 2. Xử lý Model
            try {
                $result = $this->admin->updateAdmin($id, $ten, $email, $vai_tro, $trang_thai_hoat_dong, $mat_khau ?: null);
                if ($result) {
                    $message = "Đã cập nhật tài khoản Admin thành công!";
                    unset($_SESSION['old_admin_data']);
                } else {
                    $message = "Thông tin không thay đổi hoặc lỗi không xác định khi cập nhật Admin.";
                }
                // Chuyển hướng về trang danh sách Admin
                header("Location: admin.php?page=admin&msg=" . urlencode($message));
                exit;
            } catch (\Exception $e) {
                $error_msg = "Lỗi: " . $e->getMessage();
                // Chuyển hướng về trang edit với lỗi chi tiết từ Model
                header("Location: admin.php?page=admin&action=edit&id=" . urlencode($id) . "&error=" . urlencode($error_msg));
                exit;
            }
        }
        
        /* ================== Xử lý XÓA ADMIN ================== */
        if ($action == 'delete' && isset($_GET['id'])) {
            $id = $_GET['id'];
            try {
                $this->admin->deleteAdmin($id);
                $message = "Đã xóa tài khoản Admin.";
                header("Location: admin.php?page=admin&msg=" . urlencode($message));
                exit;
            } catch (\Exception $e) {
                $message = "Lỗi: " . $e->getMessage();
            }
        }
        
        // ... (phần HIỂN THỊ DANH SÁCH ADMIN giữ nguyên) ...
        $ds_admin = $this->admin->getAllAdmins();
        
        // Tải view danh sách admin
        include_once "../app/view/admin/admin.php";
    }
}
?>