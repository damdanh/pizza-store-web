<?php 
// app/view/auth/reset_password.php
// Đảm bảo có biến $base_url_path từ main.php
$base_url_path = '/WD20302-PRO1014_N5/nhahang/'; 
?>
<div class="login-container">
    <div class="login-box">
        <h1 class="login-title">Cập Nhật Mật Khẩu Mới</h1>
        
        <?php if (!empty($error)): ?>
            <div class="alert alert-danger">
                <?= $error ?>
            </div>
        <?php endif; ?>

        <form action="<?= $base_url_path ?>public/reset_password" method="POST">
            <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">
            
            <div class="form-group">
                <label class="form-label">Mật khẩu mới</label>
                <input 
                    type="password" 
                    name="password" 
                    class="form-input"  
                    placeholder="Mật khẩu mới (Tối thiểu 8 ký tự, có đủ ký tự đặc biệt, hoa, thường, số)" 
                    required>
                <small style="color: #666; font-size: 12px;">
                    Phải có: Chữ hoa, chữ thường, số và ký tự đặc biệt.
                </small>
            </div>

            <div class="form-group">
                <label class="form-label">Xác nhận mật khẩu mới</label>
                <input 
                    type="password" 
                    name="confirm_password" 
                    class="form-input" 
                    placeholder="Nhập lại mật khẩu mới" 
                    required>
            </div>

            <button type="submit" class="login-btn">Cập Nhật Mật Khẩu</button>
        </form>
    </div>
</div>