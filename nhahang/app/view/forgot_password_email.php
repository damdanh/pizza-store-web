<?php 
// app/view/auth/forgot_password_email.php
// Đảm bảo có biến $base_url_path từ main.php
$base_url_path = '/WD20302-PRO1014_N5/nhahang/'; 
?>
<div class="login-container">
    <div class="login-box">
        <h1 class="login-title">Quên Mật khẩu</h1>
        
        <?php if (!empty($error)): ?>
            <div class="alert alert-danger">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <form action="<?= $base_url_path ?>public/forgot_password" method="POST">
            
            <div class="form-group">
                <label class="form-label">Địa chỉ Email</label>
                <input 
                    type="email" 
                    name="email" 
                    class="form-input"  
                    placeholder="Nhập email đã đăng ký" 
                    required>
            </div>

            <button type="submit" class="login-btn">Gửi Mã Xác Nhận</button>
        </form>

        <div class="text-center mt-3">
            <p>
                <a href="<?= $base_url_path ?>public/login">Quay lại Đăng nhập</a>
            </p>
        </div>
    </div>
</div>