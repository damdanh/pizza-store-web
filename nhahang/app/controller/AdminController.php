<?php
ob_start();
require_once __DIR__. '/../Model/CategoryModel.php';
require_once __DIR__. '/../Model/ProductModel.php';
// require_once __DIR__. '/../Model/UserModel.php';
require_once __DIR__. '/../Model/AdminModel.php';
require_once __DIR__. '/../Model/BookingModel.php';
require_once __DIR__. '/../Model/chinhanhModel.php';

class AdminController {
    public $danhmuc;
    public $sanpham;
    public $admin;
    public $booking;
    // public $user;
    public $db;

    public function __construct($db_object = null) {
        $this->danhmuc = new CategoryModel();
        $this->sanpham = new ProductModel();
        $this->admin = new AdminModel();
        $this->booking = new BookingModel();
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
        
        // --- LẤY DỮ LIỆU ĐẶT BÀN ---
        $totalBookings = 0;
        $pendingBookings = 0;
        try {
            // Sử dụng getAllBookings để lấy toàn bộ danh sách
            $ds_datban = $this->booking->getAllBookings(); 
            $totalBookings = is_array($ds_datban) ? count($ds_datban) : 0;
            
            // Đếm số đơn chờ xác nhận (status = 0)
            foreach($ds_datban as $datban) {
                // Giả định cột 'status' tồn tại và 0   là chờ xác nhận
                if (($datban['status'] ?? 0) == 0) { 
                    $pendingBookings++;
                }
            }
        } catch (Exception $e) {
            // Bỏ qua lỗi DB nếu không tìm thấy dữ liệu đặt bàn, chỉ set count về 0
            error_log("Lỗi lấy dữ liệu đặt bàn cho dashboard: " . $e->getMessage()); 
        }
        // --- KẾT THÚC LẤY DỮ LIỆU ĐẶT BÀN ---
        
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

        // Truyền các biến mới vào view
        include '../app/view/admin/dashboard.php';
    }

    public function quanlydatban(){
        $message = $_GET['msg'] ?? null;
        $error = $_GET['error'] ?? null;

        // Xử lý các hành động: Xóa và Cập nhật trạng thái
        if (isset($_GET['action']) && isset($_GET['id'])) {
            $bookingId = (int)$_GET['id'];
            try {
             // >>> THAY THẾ: Xử lý HỦY BỎ/THẤT BẠI (Status 2) <<<
                if ($_GET['action'] === 'cancel' || $_GET['action'] === 'delete') { 
                    $this->booking->updateBookingStatus($bookingId, 2); 
                    $message = "Đơn đặt bàn #{$bookingId} đã được **HỦY BỎ** (Trạng thái 2).";
                    header("Location: admin.php?page=quanlydatban&msg=" . urlencode($message));
                    exit;
                }
                // ----------------------------------------------------
                
                elseif ($_GET['action'] === 'confirm') {
                    // XỬ LÝ CẬP NHẬT TRẠNG THÁI (LUÔN LÀ ĐÃ XÁC NHẬN: 1)
                    $this->booking->updateBookingStatus($bookingId, 1); 
                    $message = "Đơn đặt bàn #{$bookingId} đã được **XÁC NHẬN** (Trạng thái 1).";
                    header("Location: admin.php?page=quanlydatban&msg=" . urlencode($message));
                    exit;
                }
            } catch (\Exception $e) {
                $error = "Lỗi xử lý đơn hàng: " . $e->getMessage();
            }
        }
        
        try {
            // Lấy danh sách đơn đặt bàn từ Model
            $ds_datban = $this->booking->getAllBookings();
        } catch (\Exception $e) {
            $ds_datban = [];
            $error = $e->getMessage();
        }

        // Truyền $ds_datban ra view
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
        
        // 1. Lấy danh sách chi nhánh để hiển thị trong select box
        require_once __DIR__ . '/../Model/ChinhanhModel.php'; 
        $branchesModel = new ChinhanhModel();
        $ds_chinhanh = $branchesModel->getAllBranches(); 
        $error = $_GET['error'] ?? null;
        $prev_data = json_decode(urldecode($_GET['prev_data'] ?? '{}'), true); 

        // =============== XỬ LÝ POST FORM ĐẶT BÀN ===============
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_booking'])) {
            // Lấy ID chi nhánh được gửi lên
            $selectedBranchId = (int)($_POST['chinhanh'] ?? 0);
            
            // Tìm tên chi nhánh dựa trên ID đã chọn từ danh sách
            $branchName = '';
            foreach ($ds_chinhanh as $cn) {
                if ((int)$cn['id'] === $selectedBranchId) {
                    $branchName = htmlspecialchars($cn['ten_chi_nhanh']);
                    break;
                }
            }
            
            // Kiểm tra xem đã tìm thấy tên chi nhánh chưa
            if (empty($branchName)) {
                $error_msg = "Lỗi: Chi nhánh không hợp lệ hoặc không được chọn.";
                header("Location: admin.php?page=formDemo&error=" . urlencode($error_msg) . "&prev_data=" . urlencode(json_encode($_POST)));
                exit;
            }

            // === SỬA LỖI XỬ LÝ NGÀY/GIỜ ===
            $ngay_dat = trim($_POST['ngay'] ?? '');
            $gio_dat = trim($_POST['gio'] ?? ''); 
            
            $booking_date = null;
            $booking_time = null;
            
            // 1. Phân tích Ngày: Đảm bảo format dd/mm/yy chính xác
            if (!empty($ngay_dat)) {
                $date_obj = DateTime::createFromFormat('d/m/y', $ngay_dat);
                // Kiểm tra nếu object được tạo và ngày tháng không bị tràn (false positives)
                if ($date_obj && $date_obj->format('d/m/y') === $ngay_dat) {
                    $booking_date = $date_obj->format('Y-m-d');
                }
            }
            
            // 2. Phân tích Giờ: Đảm bảo format HH:mm chính xác
            if (!empty($gio_dat)) {
                $time_obj = DateTime::createFromFormat('H:i', $gio_dat);
                // Nếu H:i thất bại, thử H:i A (vì đôi khi form web mặc định nhập kiểu này)
                if (!$time_obj) {
                     $time_obj = DateTime::createFromFormat('h:i A', strtoupper($gio_dat));
                }
                
                if ($time_obj) {
                    $booking_time = $time_obj->format('H:i:s');
                }
            }
            
            // KIỂM TRA VALIDATION CỦA CONTROLLER
            if (empty($booking_date)) {
                $error_msg = "Lỗi: Ngày đặt bàn (dd/mm/yy) không hợp lệ hoặc bị thiếu.";
                header("Location: admin.php?page=formDemo&error=" . urlencode($error_msg) . "&prev_data=" . urlencode(json_encode($_POST)));
                exit;
            }
            
            if (empty($booking_time)) {
                $error_msg = "Lỗi: Giờ đặt bàn (HH:mm) không hợp lệ hoặc bị thiếu.";
                header("Location: admin.php?page=formDemo&error=" . urlencode($error_msg) . "&prev_data=" . urlencode(json_encode($_POST)));
                exit;
            }
            // ===============================

            // Chuẩn bị dữ liệu cho Model
            $data = [
                'name' => trim($_POST['ten'] ?? ''),
                'phone' => trim($_POST['sdt'] ?? ''),
                'email' => trim($_POST['email'] ?? ''),
                'branch' => $branchName, 
                'booking_date' => $booking_date, // Đã validate và format
                'booking_time' => $booking_time, // Đã validate và format
                'soluongban' => (int)($_POST['songuoi'] ?? 1),
                'notes' => trim($_POST['ghichu'] ?? ''),
                'id_khach_hang' => $_SESSION['user']['id'] ?? null, // SỬ DỤNG id_khach_hang
                'total' => 0,
                'status' => 0 // ĐẶT TRẠNG THÁI MẶC ĐỊNH LÀ CHỜ XÁC NHẬN (0)
            ];

            try {
                // Gọi Model để lưu dữ liệu
                $bookingId = $this->booking->createBooking($data);
                
                // Chuyển hướng thành công về trang quản lý đặt bàn kèm ID
                header("Location: admin.php?page=quanlydatban&msg=" . urlencode("Đã tạo đơn đặt bàn #{$bookingId} thành công và đang chờ xác nhận."));
                exit;

            } catch (\Exception $e) {
                // Chuyển hướng lại form Demo với lỗi và dữ liệu đã nhập
                $error_msg = "Lỗi đặt bàn: " . $e->getMessage();
                header("Location: admin.php?page=formDemo&error=" . urlencode($error_msg) . "&prev_data=" . urlencode(json_encode($_POST))); 
                exit;
            }
        }
        // ========================================================
        
        include '../app/view/admin/formDemo.php';
    }

    public function menu(){
    $dsdm = $this->danhmuc->getAllCategories();
    
    // --- 1. XÁC ĐỊNH CHẾ ĐỘ LỌC TỪ URL ---
    $filter_mode = 'active'; // Mặc định hiển thị món 'Còn hàng' (active)
    if (isset($_GET['show']) && $_GET['show'] == 'hidden') {
        $filter_mode = 'hidden'; // Nếu có &show=hidden, chỉ hiển thị món đã ẩn
    }
    // Giả định nếu không có tham số nào, ProductModel::getAllProducts() mặc định chỉ lấy món "Còn hàng"
    // Nếu bạn muốn hiển thị TẤT CẢ theo mặc định: $filter_mode = 'all';
    
    // Khởi tạo các biến nếu cần, ví dụ: $sp_edit, $dm

    /* ================== Xử lý LƯU NHÓM MÓN ================== */
    if (isset($_POST['save_category'])) {
        $ten_danh_muc = trim($_POST['category_name']);
        $mo_ta = trim($_POST['category_description'] ?? '');

        try {
            $this->danhmuc->createCategory($ten_danh_muc, $mo_ta);
            header("Location: admin.php?page=menu&msg=" . urlencode("Đã thêm nhóm món thành công."));
            exit;
        } catch (\Exception $e) {
            echo "<script>alert('Lỗi thêm nhóm món: " . $e->getMessage() . "');</script>";
        }
    }

    /* ================== LƯU SẢN PHẨM (THÊM/SỬA) ================== */
    if (isset($_POST['save_product'])) {
        $product_id = isset($_POST['product_id']) ? $_POST['product_id'] : null;
        $name = $_POST['ten_mon'];
        $price = $_POST['gia'];
        $trang_thai = $_POST['trang_thai_hoat_dong'];
        $cat_id = $_POST['category'];
        $mota = isset($_POST['mo_ta']) ? $_POST['mo_ta'] : '';

        // Xử lý ảnh (Giữ nguyên logic upload ảnh của bạn)
        $img = "";
        $upload_dir = "nhahang/app/public/img/";
        if (!empty($_FILES['img']['name'])) {
            $img = time() . "_" . basename($_FILES['img']['name']);
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }
            move_uploaded_file($_FILES['img']['tmp_name'], $upload_dir . $img);
        } else {
            $img = $_POST['old_img'] ?? ''; 
        }

        $data = [
            'ten_mon' => $name,
            'gia' => $price,
            'hinh_anh' => $img,
            'trang_thai_hoat_dong' => $trang_thai,
            'id_danh_muc_mon' => $cat_id,
            'mo_ta' => $mota
        ];

        try {
            if ($product_id) {
                $this->sanpham->updateProduct($product_id, $data);
                $msg = "Đã cập nhật món ăn thành công.";
            } else {
                $this->sanpham->createProduct($data);
                $msg = "Đã thêm món ăn mới thành công.";
            }
            header("Location: admin.php?page=menu&msg=" . urlencode($msg));
            exit;
        } catch (\Exception $e) {
             echo "<script>alert('Lỗi lưu sản phẩm: " . $e->getMessage() . "');</script>";
        }
    }

    /* ================== 1. XÓA SẢN PHẨM ================== */
    if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
        $this->sanpham->deleteProduct($_GET['id']);
        header("Location: admin.php?page=menu&msg=" . urlencode("Đã xóa món ăn thành công."));
        exit;
    }

    /* ================== 2. ẨN / HIỆN SẢN PHẨM (TOGGLE STATUS) ================== */
    if (isset($_GET['action']) && ($_GET['action'] == 'hide' || $_GET['action'] == 'unhide') && isset($_GET['id'])) {
        $id = (int)$_GET['id'];
        $action = $_GET['action'];
        
        // Xác định trạng thái mới dựa trên action
        $new_status = ($action === 'hide') ? 'Hết hàng' : 'Còn hàng';
        $msg = ($action === 'hide') ? 'Đã ẩn món ăn thành công.' : 'Đã hiển thị món ăn thành công.';

        try {
            // Cập nhật trạng thái thông qua ProductModel
            $data = ['trang_thai' => $new_status];
            $this->sanpham->updateProduct($id, $data);
            
            // CHUYỂN HƯỚNG VỀ TRANG XEM HIỆN TẠI ĐỂ DUY TRÌ BỘ LỌC
            $redirect_url = "admin.php?page=menu";
            if ($filter_mode === 'hidden') {
                $redirect_url .= "&show=hidden";
            }
            $redirect_url .= "&msg=" . urlencode($msg);

            header("Location: " . $redirect_url);
            exit;
        } catch (\Exception $e) {
            $error_msg = "Lỗi cập nhật trạng thái: " . $e->getMessage();
            header("Location: admin.php?page=menu&error=" . urlencode($error_msg));
            exit;
        }
    }


    /* ================== 3. HIỂN THỊ FORM SỬA/THÊM MÓN ================== */
    
    // Giữ lại logic hiển thị form SỬA
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

    /* ================== 5. THÊM SẢN PHẨM (HIỂN THỊ FORM) ================== */
    if (isset($_GET['action']) && $_GET['action'] == 'add') {
        $dsdm = $this->danhmuc->getAllCategories();
        $sp_edit = null; 
        include_once  "../app/view/admin/themmonan.php";
        return;
    }
    
    // --- 2. GỌI MODEL VỚI BỘ LỌC (Cần sửa ProductModel để chấp nhận tham số) ---
    // Giả sử ProductModel::getAllProducts($filter_mode) đã được sửa để hoạt động
    // Nếu bạn chưa sửa Model, nó sẽ chỉ lấy mặc định, bạn cần phải sửa Model
    $dssp = $this->sanpham->getAllProducts($filter_mode);
    
    // Gán cờ is_hidden vào từng món ăn để View có thể xử lý style
    foreach ($dssp as $key => $dish) {
        $dssp[$key]['is_hidden'] = ($dish['trang_thai'] === 'Hết hàng');
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
            if ($mat_khau === $admin_info['mat_khau']) {
                
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
/* ================== XỬ LÝ ĐĂNG XUẤT ================== */
    public function logout() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        // Xóa tất cả các biến session
        $_SESSION = [];
        
        // Hủy session
        session_destroy();
        
        // Chuyển hướng về trang đăng nhập
        header("Location: admin.php?action=login&msg=" . urlencode("Đã đăng xuất thành công!"));
        exit;
    }


}
?>
