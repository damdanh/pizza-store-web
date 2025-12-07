<?php 
// app/view/verify_email.php (Đã sửa để dùng CSS layout từ login.css)
// Đảm bảo có biến $base_url_path từ main.php
$base_url_path = '/WD20302-PRO1014_N5/nhahang/'; 
?>
<div class="login-container">
    <div class="login-box"> 
        <h1 class="login-title">Xác Minh Email</h1>
        
        <p style="text-align: center; margin-bottom: 20px;">
            Chúng tôi đã gửi mã xác minh 6 số đến: <b><?= htmlspecialchars($email) ?></b>
        </p>

        <?php if (isset($mock_code) && $mock_code !== 'N/A'): ?>
            <div class="alert alert-warning text-center" style="font-size: 1em; font-weight: bold; padding: 10px; border: 1px solid #f0ad4e; background-color: #fcf8e3; margin-bottom: 20px;">
                **MÃ CODE TEST (DEV MODE): <?= htmlspecialchars($mock_code) ?>**
            </div>
            <script>console.log('Mã OTP Giả định: <?= htmlspecialchars($mock_code) ?>');</script>
        <?php endif; ?>
        
        <?php if(isset($error) && $error): ?>
            <div class="alert alert-danger" style="margin-bottom: 20px;"><?= $error ?></div>
        <?php endif; ?>
        
        <form method="POST" action="<?= $base_url_path ?>public/verify_reset_code">
            <input type="hidden" name="email" value="<?= htmlspecialchars($email) ?>">
            
            <div class="form-group">
                <label class="form-label">Nhập mã OTP</label>
                <input 
                    type="text" 
                    name="otp" 
                    class="form-input" 
                    maxlength="6" 
                    required 
                    style="text-align: center; font-size: 18px; font-weight: bold;">
            </div>
            
            <button type="submit" class="login-btn">Xác Nhận</button> 
        </form>
        <div class="text-center mt-3" style="margin-top: 20px;">
            <small>Mã có hiệu lực trong <b>2 phút</b></small>
        </div>
    </div>
</div>