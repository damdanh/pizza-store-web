<?php
// Đã loại bỏ session_start() và logic kiểm tra session ở đây.
// Việc này do admin.php (router chính) đảm nhiệm trước khi include file này.

// LƯU Ý: Vẫn để thẻ mở PHP ở đây vì logic hiển thị lỗi sử dụng PHP.
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Pizza 4P's</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background: linear-gradient(135deg, #a89f94 0%, #8b8379 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .header {
            position: fixed;
            top: 0;
            right: 0;
            padding: 20px 30px;
            display: flex;
            gap: 20px;
            z-index: 100;
        }

        .header-icon {
            width: 24px;
            height: 24px;
            cursor: pointer;
            filter: brightness(0) invert(1);
            opacity: 0.8;
            transition: opacity 0.3s;
        }

        .header-icon:hover {
            opacity: 1;
        }

        .container {
            display: flex;
            gap: 60px;
            align-items: center;
            max-width: 1200px;
            width: 100%;
        }

        .promo-banner {
            background: linear-gradient(135deg, #2c4a7c 0%, #1a2942 100%);
            padding: 50px 40px;
            border-radius: 30px;
            position: relative;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            max-width: 520px;
        }

        .promo-banner::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
            animation: shimmer 3s infinite;
        }

        @keyframes shimmer {

            0%,
            100% {
                transform: translate(-25%, -25%);
            }

            50% {
                transform: translate(25%, 25%);
            }
        }

        .stars {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
        }

        .star {
            position: absolute;
            width: 6px;
            height: 6px;
            background: #4a9eff;
            border-radius: 50%;
            animation: twinkle 2s infinite;
        }

        @keyframes twinkle {

            0%,
            100% {
                opacity: 0.3;
                transform: scale(1);
            }

            50% {
                opacity: 1;
                transform: scale(1.2);
            }
        }

        .promo-content {
            position: relative;
            z-index: 2;
        }

        .promo-title {
            color: white;
            font-size: 48px;
            font-weight: 300;
            line-height: 1.2;
            margin-bottom: 30px;
            font-family: 'Georgia', serif;
        }

        .promo-title .highlight {
            font-weight: 600;
        }

        .fish-container {
            display: flex;
            gap: 20px;
            margin: 30px 0;
            justify-content: center;
        }

        .fish {
            width: 80px;
            height: 60px;
            position: relative;
            animation: swim 3s ease-in-out infinite;
        }

        .fish:nth-child(2) {
            animation-delay: 0.5s;
        }

        .fish:nth-child(3) {
            animation-delay: 1s;
        }

        @keyframes swim {

            0%,
            100% {
                transform: translateY(0) rotate(-5deg);
            }

            50% {
                transform: translateY(-10px) rotate(5deg);
            }
        }

        .send-button {
            background: white;
            color: #1a2942;
            border: none;
            padding: 15px 40px;
            border-radius: 30px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            box-shadow: 0 4px 15px rgba(255, 255, 255, 0.3);
        }

        .send-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(255, 255, 255, 0.4);
        }

        .brand-text {
            color: rgba(255, 255, 255, 0.9);
            font-size: 32px;
            font-weight: 700;
            margin-top: 30px;
            letter-spacing: 2px;
        }

        .login-card {
            background: white;
            padding: 50px 45px;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 450px;
        }

        .welcome-title {
            font-size: 36px;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 40px;
            text-align: left;
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-label {
            display: block;
            color: #2c3e50;
            font-size: 14px;
            font-weight: 500;
            margin-bottom: 8px;
        }

        .form-input {
            width: 100%;
            padding: 14px 16px;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            font-size: 15px;
            transition: all 0.3s;
            background: #f8f9fa;
        }

        .form-input:focus {
            outline: none;
            border-color: #4a9eff;
            background: white;
            box-shadow: 0 0 0 3px rgba(74, 158, 255, 0.1);
        }

        .checkbox-group {
            display: flex;
            align-items: center;
            gap: 8px;
            margin: 20px 0;
        }

        .checkbox-input {
            width: 18px;
            height: 18px;
            cursor: pointer;
            accent-color: #2c4a7c;
        }

        .checkbox-label {
            color: #5a6c7d;
            font-size: 14px;
            cursor: pointer;
            user-select: none;
        }

        .login-button {
            width: 100%;
            padding: 16px;
            background: #3d3530;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .login-button:hover {
            background: #2a2420;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(61, 53, 48, 0.3);
        }

        .login-button:active {
            transform: translateY(0);
        }

        .forgot-password {
            text-align: right;
            margin-top: 15px;
        }

        .forgot-password a {
            color: #ff6b6b;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            transition: color 0.3s;
        }

        .forgot-password a:hover {
            color: #ff5252;
            text-decoration: underline;
        }

        .error-message {
            background: #fff3f3;
            border-left: 4px solid #ff6b6b;
            color: #d63031;
            padding: 12px 16px;
            border-radius: 6px;
            margin-bottom: 20px;
            font-size: 14px;
        }

        @media (max-width: 968px) {
            .container {
                flex-direction: column;
                gap: 40px;
            }

            .promo-banner {
                max-width: 100%;
            }
        }

        @media (max-width: 576px) {
            .promo-title {
                font-size: 36px;
            }

            .login-card {
                padding: 35px 25px;
            }

            .welcome-title {
                font-size: 28px;
            }
        }
    </style>
</head>

<body>
    <div class="header">
        <svg class="header-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
            <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
        </svg>
        <svg class="header-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
            <polyline points="16 17 21 12 16 7"></polyline>
            <line x1="21" y1="12" x2="9" y2="12"></line>
        </svg>
    </div>

    <div class="container">
        <div class="promo-banner">
            <div class="stars">
                <span class="star" style="top: 10%; left: 15%; animation-delay: 0s;"></span>
                <span class="star" style="top: 25%; left: 70%; animation-delay: 0.3s;"></span>
                <span class="star" style="top: 40%; left: 30%; animation-delay: 0.6s;"></span>
                <span class="star" style="top: 60%; left: 80%; animation-delay: 0.9s;"></span>
                <span class="star" style="top: 75%; left: 20%; animation-delay: 1.2s;"></span>
                <span class="star" style="top: 15%; left: 85%; animation-delay: 1.5s;"></span>
                <span class="star" style="top: 50%; left: 50%; animation-delay: 1.8s;"></span>
                <span class="star" style="top: 80%; left: 60%; animation-delay: 2.1s;"></span>
            </div>

            <div class="promo-content">
                <h1 class="promo-title">
                    Give your loved<br>
                    ones more 🐠<br>
                    <span class="highlight">Gift Voucher</span><br>
                    than just a gift
                </h1>

                <div class="fish-container">
                    <div class="fish">🐠</div>
                    <div class="fish">🐡</div>
                    <div class="fish">🐟</div>
                </div>

                <button class="send-button">SEND NOW</button>

                <div class="brand-text">PIZZA 4P'S</div>
            </div>
        </div>

        <div class="login-card">
    <h2 class="welcome-title">Welcome Admin</h2>

    <?php 
    // Lấy thông báo lỗi từ query string (do AdminController chuyển hướng về admin.php?error=...)
    $error_message = $_GET['error'] ?? '';
    
    // Nếu Controller lưu lỗi vào Session, ta lấy ra (Chỉ hoạt động nếu session đã được start trong admin.php)
    if (empty($error_message) && isset($_SESSION['error_msg'])) {
        $error_message = $_SESSION['error_msg'];
        // Không thể unset $_SESSION['error_msg'] ở đây an toàn vì không có session_start()
    }
    
    if (!empty($error_message)): 
        // Hiển thị lỗi, đảm bảo escape HTML
        $display_error = htmlspecialchars($error_message);
    ?>
        <div class="error-message">
            <?= $display_error ?>
        </div>
    <?php endif; ?>

    <form action="../public/admin.php?action=login_process" method="POST"> 
        <div class="form-group">
            <label class="form-label" for="email">Email Admin</label>
            <input
                type="text"
                id="email"
                name="email" 
                class="form-input"
                placeholder="vd: admin@pizza4ps.vn"
                value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>"
                required>
        </div>

        <div class="form-group">
            <label class="form-label" for="mat_khau">Mật khẩu</label>
            <input
                type="password"
                id="mat_khau"
                name="mat_khau"
                class="form-input"
                placeholder="Nhập mật khẩu của bạn"
                required>
        </div>

        <div class="checkbox-group">
            <input
                type="checkbox"
                id="remember"
                name="remember"
                class="checkbox-input">
            <label for="remember" class="checkbox-label">Ghi nhớ đăng nhập</label>
        </div>

        <button type="submit" class="login-button">ĐĂNG NHẬP</button>
        
        <div class="forgot-password">
            <a href="admin.php?action=forgot_password">Quên Mật khẩu?</a>
        </div>
    </form>
</div>
    </div>

    <script>
        // Auto dismiss error message after 5 seconds
        const errorMsg = document.querySelector('.error-message');
        if (errorMsg) {
            setTimeout(() => {
                errorMsg.style.opacity = '0';
                errorMsg.style.transition = 'opacity 0.5s';
                setTimeout(() => errorMsg.remove(), 500);
            }, 5000);
        }

        // Add floating animation to fish
        document.querySelectorAll('.fish').forEach((fish, index) => {
            fish.style.animationDelay = `${index * 0.5}s`;
        });
    </script>
</body>

</html>