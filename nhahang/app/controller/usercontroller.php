<?php
// app/controller/UserController.php

// Đảm bảo đường dẫn đúng theo cấu trúc: nhahang/app/controller/
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../model/UserModel.php';
require_once __DIR__ . '/../Utils/EmailService.php'; // <--- ĐÃ THAY THẾ EmailSender.php

class UserController {
    private $base_url = '/WD20302-PRO1014_N5/nhahang/public';
    private $pdo;
    private $userModel;

    public function __construct() {
        // Giả định getConnection() trả về đối tượng PDO
        $this->pdo = getConnection();
        $this->userModel = new UserModel($this->pdo); 
    }
    
    // =================================================================
    // CÁC HÀM XỬ LÝ ĐĂNG KÝ/ĐĂNG NHẬP
    // =================================================================
    
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
                    
                    // LƯU Ý: ĐÃ SỬA LOGIC CHUYỂN HƯỚNG TẠI ĐÂY
                    $default_redirect = "$this->base_url/";
                    $redirect = $_SESSION['redirect_after_login'] ?? $default_redirect;
                    unset($_SESSION['redirect_after_login']);
                    
                    // KIỂM TRA và LOẠI BỎ nếu URL chứa "admin.php" (ngăn chuyển hướng sang Admin)
                    if (strpos($redirect, 'admin.php') !== false) {
                        $redirect = $default_redirect;
                    }
                    
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
    

    public function showForgotPassword() {
        $data = [
            'title' => 'Quên Mật Khẩu',
            'content_view' => __DIR__ . '/../view/forgot_password_email.php', 
            'error' => $_SESSION['forgot_error'] ?? ''
        ];
        unset($_SESSION['forgot_error']);
        extract($data);
        include __DIR__ . '/../view/main.php';
    }

    // 2. Xử lý gửi mã xác nhận (Code 6 ký tự)
    public function sendResetCode() {
        $email = trim($_POST['email'] ?? '');
        
        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['forgot_error'] = "Email không hợp lệ.";
            header("Location: $this->base_url/forgot_password");
            exit;
        }

        // Lấy thông tin người dùng qua UserModel
        $user = $this->userModel->getUserByEmail($email);

        if ($user) {
            $code = strtoupper(substr(bin2hex(random_bytes(3)), 0, 6)); // Code 6 ký tự
            $expires_at = time() + (2 * 60); // Hết hạn sau 2 phút
            
            if ($this->userModel->saveResetCode($user['id_khach_hang'], $code, $expires_at)) {
                
                $subject = "Mã Xác Nhận Quên Mật Khẩu N5 Restaurant";
                
                // Nội dung email dạng HTML chuyên nghiệp hơn
                $body = "
                    <html>
                    <body style='font-family: Arial, sans-serif; line-height: 1.6;'>
                        <h2>Yêu cầu Đặt lại Mật khẩu</h2>
                        <p>Bạn đã yêu cầu đặt lại mật khẩu cho tài khoản N5 Restaurant của bạn.</p>
                        <p>Mã xác nhận 6 số của bạn là:</p>
                        <h1 style='background-color: #f4f4f4; padding: 15px; text-align: center; border-radius: 5px; color: #d9534f; font-size: 24px; font-weight: bold;'>$code</h1>
                        <p>Mã này sẽ hết hạn sau 2 phút. Vui lòng nhập mã này vào trang xác minh.</p>
                        <p>Nếu bạn không thực hiện yêu cầu này, vui lòng bỏ qua email này.</p>
                        <p style='color: #888; font-size: 12px;'>Đây là email tự động, vui lòng không trả lời.</p>
                    </body>
                    </html>
                ";
                
                // === GỬI EMAIL BẰNG PHPMailer qua EmailService ===
                $mail_sent = EmailService::sendSMTP($email, $subject, $body); 
                
                if (!$mail_sent) {
                    error_log("❌ Lỗi nghiêm trọng khi gửi email bằng PHPMailer. Kiểm tra log.");
                    // Thông báo lỗi thân thiện cho người dùng
                    $_SESSION['forgot_error'] = "Lỗi khi gửi email xác nhận. Vui lòng thử lại sau.";
                    header("Location: $this->base_url/forgot_password");
                    exit;
                }
                
                // Chuyển hướng đến form nhập mã
                header("Location: $this->base_url/verify_reset_code?email=" . urlencode($email));
                exit;
            } else {
                $_SESSION['forgot_error'] = "Lỗi hệ thống khi lưu mã. Vui lòng thử lại.";
            }
        } else {
            // Luôn thông báo chung chung để tránh lộ thông tin email nào tồn tại
            $_SESSION['forgot_error'] = "Nếu email này tồn tại, mã xác nhận sẽ được gửi đến.";
        }
        
        header("Location: $this->base_url/forgot_password");
        exit;
    }
    
    // 3. Hiển thị Form nhập mã code
    public function showVerifyCode() {
        $email = $_GET['email'] ?? '';
        $error = $_SESSION['verify_error'] ?? '';
        unset($_SESSION['verify_error']);
        
        // ĐÃ XÓA: Logic lấy và truyền $mock_code ra View

        if (empty($email)) {
            header("Location: $this->base_url/forgot_password");
            exit;
        }

        $data = [
            'title' => 'Xác Nhận Mã Code',
            'content_view' => __DIR__ . '/../view/verify_email.php', 
            'email' => $email,
            'error' => $error,
            // ĐÃ XÓA: 'mock_code' => $mock_code 
        ];
        extract($data);
        include __DIR__ . '/../view/main.php';
    }

    // 4. Xử lý xác nhận mã code
    public function verifyResetCode() {
        $email = trim($_POST['email'] ?? '');
        $code = trim($_POST['otp'] ?? '');
        $user = $this->userModel->getUserByEmail($email);
        
        if (!$user) {
            $_SESSION['verify_error'] = "Lỗi hệ thống. Vui lòng thử lại quy trình.";
            header("Location: $this->base_url/forgot_password");
            exit;
        }

        if ($this->userModel->validateResetCode($user['id_khach_hang'], $code)) {
            // Mã hợp lệ, tạo token để cho phép cập nhật mật khẩu
            $reset_token = bin2hex(random_bytes(32)); 
            $this->userModel->saveResetToken($user['id_khach_hang'], $reset_token);

            // Chuyển hướng đến form cập nhật mật khẩu
            header("Location: $this->base_url/reset_password?token=" . $reset_token);
            exit;
        } else {
            $_SESSION['verify_error'] = "Mã xác nhận không hợp lệ hoặc đã hết hạn.";
            // Để giữ email trên URL:
            header("Location: $this->base_url/verify_reset_code?email=" . urlencode($email));
            exit;
        }
    }
    
    // 5. Hiển thị Form cập nhật mật khẩu
    public function showResetPassword() {
        $token = $_GET['token'] ?? '';
        $error = $_SESSION['reset_error'] ?? '';
        unset($_SESSION['reset_error']);
        
        // Kiểm tra tính hợp lệ của token
        if (empty($token) || !$this->userModel->getUserByResetToken($token)) {
            $_SESSION['forgot_error'] = "Liên kết đặt lại mật khẩu không hợp lệ hoặc đã hết hạn.";
            header("Location: $this->base_url/forgot_password");
            exit;
        }
        
        $data = [
            'title' => 'Cập Nhật Mật Khẩu',
            'content_view' => __DIR__ . '/../view/reset_password.php',
            'token' => $token,
            'error' => $error
        ];
        extract($data);
        include __DIR__ . '/../view/main.php';
    }

    // 6. Xử lý cập nhật mật khẩu
    public function resetPassword() {
        $token = $_POST['token'] ?? '';
        $password = $_POST['password'] ?? '';
        $confirm_password = $_POST['confirm_password'] ?? '';

        $user = $this->userModel->getUserByResetToken($token);

        if (!$user) {
            $_SESSION['forgot_error'] = "Phiên cập nhật đã hết hạn. Vui lòng thử lại.";
            header("Location: $this->base_url/forgot_password");
            exit;
        }
        
        // Kiểm tra các điều kiện mật khẩu (giống như trong register)
        $errors = [];
        if (strlen($password) < 8) $errors[] = "Mật khẩu phải có tối thiểu 8 ký tự.";
        if (!preg_match('/[A-Z]/', $password)) $errors[] = "Mật khẩu phải có ít nhất 1 chữ hoa (A-Z).";
        if (!preg_match('/[a-z]/', $password)) $errors[] = "Mật khẩu phải có ít nhất 1 chữ thường.";
        if (!preg_match('/[0-9]/', $password)) $errors[] = "Mật khẩu phải có ít nhất 1 số.";
        if (!preg_match('/[^A-Za-z0-9]/', $password)) $errors[] = "Mật khẩu phải có ít nhất 1 ký tự đặc biệt.";
        if ($password !== $confirm_password) $errors[] = "Xác nhận mật khẩu không khớp.";
        
        if (!empty($errors)) {
             $_SESSION['reset_error'] = implode("<br>", $errors);
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            if ($this->userModel->updatePassword($user['id_khach_hang'], $hashed_password)) {
                $this->userModel->clearResetData($user['id_khach_hang']);
                $_SESSION['success'] = "Mật khẩu đã được cập nhật thành công! Vui lòng đăng nhập.";
                header("Location: $this->base_url/login");
                exit;
            } else {
                $_SESSION['reset_error'] = "Lỗi khi cập nhật mật khẩu. Vui lòng thử lại.";
            }
        }
        
        header("Location: $this->base_url/reset_password?token=" . $token);
        exit;
    }
}