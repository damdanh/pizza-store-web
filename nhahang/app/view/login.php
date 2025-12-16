<div class="login-container">
    <div class="login-box">
        <h1 class="login-title">Đăng nhập</h1>
        
        <?php if (!empty($error)): ?>
            <div class="alert alert-danger">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($success)): ?>
            <div class="alert alert-success">
                <?= htmlspecialchars($success) ?>
            </div>
        <?php endif; ?>
        
        <form action="/WD20302-PRO1014_N5/nhahang/public/login" method="POST">
            <div class="form-group">
                <label class="form-label">Địa chỉ Email</label>
                <input 
                    type="email" 
                    name="email" 
                    class="form-input"  
                    placeholder="example@email.com" 
                    required>
            </div>

            <div class="form-group">
                <label class="form-label">Mật khẩu</label>
                <input 
                    type="password" 
                    class="form-input" 
                    name="password" 
                    placeholder="Nhập mật khẩu" 
                    required>
            </div>

            <div class="forgot-password">
                <a href="<?php echo $base_url_path ?? '/WD20302-PRO1014_N5/nhahang/'; ?>public/forgot_password">Quên mật khẩu?</a>
            </div>

            <button type="submit" class="login-btn">Đăng nhập</button>
        </form>

        <div class="divider">
            <span class="divider-text">Or</span>
        </div>

        <div class="text-center mt-3">
            <p>Chưa có tài khoản? 
                <a href="/WD20302-PRO1014_N5/nhahang/public/register">Đăng ký ngay</a>
            </p>
        </div>

     

        <p class="privacy-note">
            Tất cả dữ liệu và hình ảnh của chúng tôi được lưu trữ an toàn<br>
            Xem <a href="#">chính sách quyền riêng tư</a>
        </p>
    </div>
</div>