<?php
require_once __DIR__ . '/../config/database.php';
class UserController {
    private $base_url = '/WD20302-PRO1014_N5/nhahang/public';
    private $pdo;

    public function __construct() {
        $this->pdo = getConnection();
    }
    public function showRegister() {
        $data = [
            'title' => 'Đăng Ký Tài Khoản',
            'content_view' => __DIR__ . '/../view/register.php',
            'errors' => [], 
            'old' => []
        ];
        extract($data);
        include __DIR__ . '/../view/main.php';
    }

    public function register() {
        error_log("=== BẮT ĐẦU ĐĂNG KÝ ===");
        error_log("REQUEST_METHOD: " . $_SERVER['REQUEST_METHOD']);
        error_log("POST data: " . print_r($_POST, true));
        error_log("REQUEST_URI: " . $_SERVER['REQUEST_URI']);
        
        $errors = [];
        $old = [];
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            error_log("Không phải POST request");
            return;
        }

        $ho_ten   = trim($_POST['ho_ten'] ?? '');
        $email    = trim($_POST['email'] ?? '');
        $sdt      = trim($_POST['sdt'] ?? '');
        $password = $_POST['password'] ?? '';
        $confirm  = $_POST['confirm_password'] ?? '';
        $agree    = isset($_POST['agree']);
        
        error_log("Dữ liệu nhận được - Tên: '$ho_ten', Email: '$email', SDT: '$sdt'");

        $old = $_POST;
        if (empty($ho_ten)) $errors[] = "Họ và tên là bắt buộc.";
        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Email không hợp lệ.";
        }
        if (strlen($password) < 8) $errors[] = "Mật khẩu phải có tối thiểu 8 ký tự.";
        if (!preg_match('/[A-Z]/', $password)) $errors[] = "Mật khẩu phải có ít nhất 1 chữ hoa (A-Z).";
        if (!preg_match('/[a-z]/', $password)) $errors[] = "Mật khẩu phải có ít nhất 1 chữ thường.";
        if (!preg_match('/[0-9]/', $password)) $errors[] = "Mật khẩu phải có ít nhất 1 số.";
        if (!preg_match('/[^A-Za-z0-9]/', $password)) $errors[] = "Mật khẩu phải có ít nhất 1 ký tự đặc biệt.";
        if ($password !== $confirm) $errors[] = "Xác nhận mật khẩu không khớp.";
        if (!$agree) $errors[] = "Bạn phải đồng ý với Điều khoản Dịch vụ và Chính sách Bảo mật.";
        if (empty($errors)) {
            try {
                $check = $this->pdo->prepare("SELECT id_khach_hang FROM khach_hang WHERE email = ?");
                $check->execute([$email]);
                if ($check->rowCount() > 0) {
                    $errors[] = "Email này đã được sử dụng. Vui lòng chọn Đăng nhập.";
                }
            } catch (PDOException $e) {
                error_log("Lỗi check email: " . $e->getMessage());
                $errors[] = "Lỗi kiểm tra email: " . $e->getMessage();
            }
        }
        if (!empty($errors)) {
            error_log("Có lỗi validate: " . implode(", ", $errors));
            $data = [
                'title' => 'Đăng Ký Tài Khoản',
                'content_view' => __DIR__ . '/../view/register.php',
                'errors' => $errors,
                'old' => $old
            ];
            extract($data);
            include __DIR__ . '/../view/main.php';
            return;
        }
        try {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            
            error_log("Chuẩn bị INSERT - Tên: $ho_ten, Email: $email");
            $sql = "INSERT INTO khach_hang 
                    (ten, mat_khau, email, trang_thai_tai_khoan) 
                    VALUES 
                    (?, ?, ?, 'Active')";
            
            $stmt = $this->pdo->prepare($sql);
            $result = $stmt->execute([$ho_ten, $hash, $email]);
            
            if ($result) {
                $lastId = $this->pdo->lastInsertId();
                error_log("✅ INSERT THÀNH CÔNG! ID: $lastId");
                
                $_SESSION['success'] = "Đăng ký thành công! Dữ liệu đã lưu vào database.";
                header("Location: $this->base_url/login");
                exit;
            } else {
                error_log("❌ INSERT thất bại - không có exception");
                throw new Exception("Không thể lưu dữ liệu");
            }
            
        } catch (PDOException $e) {
            error_log("❌ LỖI PDO: " . $e->getMessage());
            error_log("SQL State: " . $e->getCode());
            
            $errors[] = "Lỗi database: " . $e->getMessage();
            
            $data = [
                'title' => 'Đăng Ký Tài Khoản',
                'content_view' => __DIR__ . '/../view/register.php',
                'errors' => $errors,
                'old' => $old
            ];
            extract($data);
            include __DIR__ . '/../view/main.php';
        } catch (Exception $e) {
            error_log("❌ LỖI EXCEPTION: " . $e->getMessage());
            
            $errors[] = "Lỗi hệ thống: " . $e->getMessage();
            
            $data = [
                'title' => 'Đăng Ký Tài Khoản',
                'content_view' => __DIR__ . '/../view/register.php',
                'errors' => $errors,
                'old' => $old
            ];
            extract($data);
            include __DIR__ . '/../view/main.php';
        }
    }
    public function showLogin() {
        $data = [
            'title' => 'Đăng Nhập',
            'content_view' => __DIR__ . '/../view/login.php',
            'error' => $_SESSION['login_error'] ?? '',
            'success' => $_SESSION['success'] ?? ''
        ];
        unset($_SESSION['login_error'], $_SESSION['success']);
        extract($data);
        include __DIR__ . '/../view/main.php';
    }

   public function login() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $email = trim($_POST['email'] ?? '');
        $pass  = $_POST['password'] ?? '';

        if (empty($email) || empty($pass)) {
            $_SESSION['login_error'] = "Vui lòng nhập đầy đủ email và mật khẩu!";
            $this->showLogin();
            return;
        }

        try {
            $stmt = $this->pdo->prepare("SELECT * FROM khach_hang WHERE email = ?");
            $stmt->execute([$email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($pass, $user['mat_khau'])) {
                $_SESSION['user_id']   = $user['id_khach_hang'];
                $_SESSION['user_name'] = $user['ten'];
                
                error_log("✅ Đăng nhập thành công - User ID: " . $user['id_khach_hang']);
                
                
                $redirect = $_SESSION['redirect_after_login'] ?? "$this->base_url/";
                unset($_SESSION['redirect_after_login']);
                
                header("Location: $redirect");
                exit;
            }
            
            $_SESSION['login_error'] = "Email hoặc mật khẩu không đúng!";
        } catch (PDOException $e) {
            error_log("Lỗi đăng nhập: " . $e->getMessage());
            $_SESSION['login_error'] = "Lỗi hệ thống. Vui lòng thử lại!";
        }
    }
    
    $this->showLogin();
}

    public function logout() {
        session_destroy();
        header("Location: $this->base_url/");
        exit;
    }
}