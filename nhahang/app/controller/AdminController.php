<?php
ob_start();
require_once __DIR__. '/../Model/CategoryModel.php';
require_once __DIR__. '/../Model/ProductModel.php';
// require_once __DIR__. '/../Model/UserModel.php';
require_once __DIR__. '/../Model/AdminModel.php';
require_once __DIR__. '/../Model/DatBanModel.php';

class AdminController {
    public $danhmuc;
    public $sanpham;
    public $admin;
    // public $user;
    public $datban;
    public $db;

    public function __construct($db_object = null) {
        $this->danhmuc = new CategoryModel();
        $this->sanpham = new ProductModel();
        $this->admin = new AdminModel();
        $this->datban = new DatbanModel();
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
        // Prepare counts for dashboard KPIs
        require_once __DIR__ . '/../Model/chinhanhModel.php';
        try {
            $dssp = $this->sanpham->getAllProducts();
        } catch (Exception $e) {
            $dssp = [];
        }
        $totalProducts = is_array($dssp) ? count($dssp) : 0;

        try {
            $branchesModel = new ChinhanhModel();
            $branches = $branchesModel->getAllBranches();
        } catch (Exception $e) {
            $branches = [];
        }
        $totalBranches = is_array($branches) ? count($branches) : 0;

        include '../app/view/admin/dashboard.php';
    }

    public function quanlydatban(){
        $action = $_GET['action'] ?? 'list';
        $id = $_GET['id'] ?? null;
        $message = '';
        $is_error = false;
        
        // Lấy thông báo lỗi/thành công từ URL nếu có
        if (isset($_GET['error'])) {
            $message = $_GET['error'];
            $is_error = true;
        } else if (isset($_GET['msg'])) {
            $message = $_GET['msg'];
        }
        
        /* ================== XỬ LÝ CẬP NHẬT TRẠNG THÁI ================== */
        if ($action == 'update_status' && $id) {
            $status = $_GET['status'] ?? 'Chờ xác nhận'; // Giá trị trạng thái mới
            try {
                $result = $this->datban->updateReservationStatus($id, $status);
                if ($result) {
                    $msg = "Cập nhật trạng thái đơn đặt bàn #{$id} thành **'{$status}'** thành công!";
                    header("Location: admin.php?page=quanlydatban&msg=" . urlencode($msg));
                    exit;
                } else {
                    $error_msg = "Không tìm thấy đơn đặt bàn #{$id} hoặc trạng thái không thay đổi.";
                    header("Location: admin.php?page=quanlydatban&error=" . urlencode($error_msg));
                    exit;
                }
            } catch (\Exception $e) {
                $error_msg = "Lỗi CSDL: " . $e->getMessage();
                header("Location: admin.php?page=quanlydatban&error=" . urlencode($error_msg));
                exit;
            }
        }
        
        /* ================== XỬ LÝ HIỂN THỊ CHI TIẾT ================== */
        if ($action == 'view' && $id) {
            try {
                $reservation_detail = $this->datban->getReservationDetails($id);
                if (!$reservation_detail) {
                     $error_msg = "Không tìm thấy đơn đặt bàn #{$id}.";
                     header("Location: admin.php?page=quanlydatban&error=" . urlencode($error_msg));
                     exit;
                }
                // Nếu bạn có View cho chi tiết đặt bàn (vd: view/admin/chitietdatban.php)
                // include '../app/view/admin/chitietdatban.php'; 
                // Tạm thời hiển thị dưới dạng JSON để kiểm tra dữ liệu
                 echo "<pre>" . print_r($reservation_detail, true) . "</pre>";
                 return;
            } catch (\Exception $e) {
                 $error_msg = "Lỗi: " . $e->getMessage();
                 header("Location: admin.php?page=quanlydatban&error=" . urlencode($error_msg));
                 exit;
            }
        }

        /* ================== XỬ LÝ DANH SÁCH (MẶC ĐỊNH) ================== */
        // Lấy tham số lọc trạng thái từ URL (vd: admin.php?page=quanlydatban&filter_status=Chờ xác nhận)
        $filter_status = $_GET['filter_status'] ?? null; 
        
        try {
             $ds_datban = $this->datban->getAllReservations($filter_status);
        } catch (\Exception $e) {
             $ds_datban = [];
             $error_msg = "Lỗi khi tải danh sách: " . $e->getMessage();
             $is_error = true;
        }
        
        // Chuẩn bị các trạng thái để dùng cho filter/dropdown (nếu cần)
        $statuses = ['Chờ xác nhận', 'Đã xác nhận', 'Đã hoàn thành', 'Đã hủy'];

        // Truyền dữ liệu sang View
        include '../app/view/admin/quanlydatban.php';
    }

    public function chinhanh(){
        require_once __DIR__ . '/chinhanh.Controller.php';
        $c = new ChinhanhController();
        $c->index();
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
        // Form sử dụng name="trang_thai"
        $trang_thai = $_POST['trang_thai'] ?? 'Còn hàng';
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

        // is_hidden checkbox
        $data['is_hidden'] = isset($_POST['is_hidden']) ? 1 : 0;

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

    /* ================== 1. ẨN / HIỆN SẢN PHẨM (SOFT DELETE) ================== */
    if (isset($_GET['action']) && isset($_GET['id'])) {
        $action = $_GET['action'];
        $id = $_GET['id'];
        if ($action === 'delete' || $action === 'hide') {
            // Giữ tương thích: 'delete' giờ sẽ ẩn
            $this->sanpham->hideProduct($id);
            header("Location: admin.php?page=menu");
            exit;
        }

        if ($action === 'unhide') {
            $this->sanpham->unhideProduct($id);
            // Nếu đang xem danh sách món ẩn, giữ lại filter
            $redirect = 'admin.php?page=menu';
            if (isset($_GET['show']) && $_GET['show'] === 'hidden') $redirect .= '&show=hidden';
            header("Location: " . $redirect);
            exit;
        }
    }

    /* ================== 2. SỬA SẢN PHẨM (HIỂN THỊ FORM) ================== */
    if (isset($_GET['action']) && $_GET['action'] == 'edit' && isset($_GET['id'])) {
        // Khi edit, cho phép load cả món ẩn để admin có thể chỉnh
        $sp_edit = $this->sanpham->getProductById($_GET['id'], true);
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
    // Nếu yêu cầu hiển thị món ẩn (filter), lấy danh sách món ẩn
    if (isset($_GET['show']) && $_GET['show'] === 'hidden') {
        $dssp = $this->sanpham->getHiddenProducts();
    } else {
        $dssp = $this->sanpham->getAllProducts();
    }
    include '../app/view/admin/menu.php';
}

    public function admin() {
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
        
        /* ================== XỬ LÝ XÓA ADMIN (ĐÃ VÔ HIỆU HÓA) ================== */
        if ($action == 'delete' && isset($_GET['id'])) {
            // Vô hiệu hóa chức năng xóa để tránh mất dữ liệu bằng URL.
            $message = "Chức năng xóa tài khoản Admin đã bị vô hiệu hóa.";
            header("Location: admin.php?page=admin&msg=" . urlencode($message));
            exit;
        }

        /* ================== XỬ LÝ ẨN / KÍCH HOẠT ADMIN (SOFT) ================== */
        if ($action == 'toggle_status' && isset($_GET['id'])) {
            $id = (int)$_GET['id'];
            // mong đợi param status (0 hoặc 1)
            $status = isset($_GET['status']) ? ((int)$_GET['status'] ? 1 : 0) : 0;
            try {
                // Không cho phép admin ẩn chính họ
                if (session_status() === PHP_SESSION_NONE) session_start();
                $currentAdminId = $_SESSION['admin']['id'] ?? null;
                if ($currentAdminId && (int)$currentAdminId === $id) {
                    $message = 'Không thể ẩn/kích hoạt chính bạn.';
                    header("Location: admin.php?page=admin&msg=" . urlencode($message));
                    exit;
                }

                $this->admin->setAdminStatus($id, $status);
                $msg = $status ? 'Đã kích hoạt tài khoản Admin.' : 'Đã ẩn tài khoản Admin.';
                header("Location: admin.php?page=admin&msg=" . urlencode($msg));
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

    

/* ================== XỬ LÝ ĐĂNG NHẬP (NHẬN POST) ================== */
public function login_process() {
    
    if (isset($_SESSION['admin'])) {
        header("Location: admin.php?page=dashboard");
        exit;
    }
    
    // Lấy dữ liệu POST
    $email = trim($_POST['email'] ?? '');
    $mat_khau = $_POST['mat_khau'] ?? '';
    
    if (empty($email) || empty($mat_khau)) {
        $error_msg = "Vui lòng nhập đầy đủ Email và Mật khẩu.";
        header("Location: admin.php?action=login&error=" . urlencode($error_msg));
        exit;
    }

    try {
        // 1. Lấy thông tin admin từ Model
        $admin_info = $this->admin->getAdminByEmail($email);

        if ($admin_info) {
            // 2. Kiểm tra mật khẩu (Quan trọng: Dùng password_verify)
            if (password_verify($mat_khau, $admin_info['mat_khau'])) {
                
                // 3. Kiểm tra trạng thái hoạt động (trang_thai_hoat_dong = 1)
                if ($admin_info['trang_thai_hoat_dong'] != 1) {
                     $error_msg = "Tài khoản của bạn đã bị vô hiệu hóa.";
                     header("Location: admin.php?action=login&error=" . urlencode($error_msg));
                     exit;
                }
                
                // 4. ĐĂNG NHẬP THÀNH CÔNG: Thiết lập Session
                $_SESSION['admin'] = [
                    'id' => $admin_info['id_admin'],
                    'ten' => $admin_info['ten'],
                    'email' => $admin_info['email'],
                    'vai_tro' => $admin_info['vai_tro']
                ];

                // 5. CHUYỂN HƯỚNG về trang Dashboard
                header("Location: admin.php?page=dashboard");
                exit;

            } else {
                $error_msg = "Email hoặc Mật khẩu không đúng.";
            }
        } else {
            $error_msg = "Email hoặc Mật khẩu không đúng.";
        }

    } catch (\Exception $e) {
        $error_msg = "Lỗi hệ thống: " . $e->getMessage();
    }

    // Đăng nhập thất bại: Chuyển hướng lại về trang Login với thông báo lỗi
    header("Location: admin.php?action=login&error=" . urlencode($error_msg));
    exit;
}


}
?>