<div class="register-container">
    <div class="register-box">
        <h1 class="register-title">Đăng ký</h1>
        
        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger">
                <ul style="margin: 0; padding-left: 20px;">
                    <?php foreach ($errors as $error): ?>
                        <li><?= htmlspecialchars($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <?php if (!empty($success)): ?>
            <div class="alert alert-success">
                <?= htmlspecialchars($success) ?>
            </div>
        <?php endif; ?>
        
        <!-- SỬA ACTION VÀ TÊN FIELD -->
        <form action="/WD20302-PRO1014_N5/nhahang/public/register" method="POST">
            
            <div class="form-group">
                <label class="form-label">Họ và Tên <span style="color: red;">*</span></label>
                <input 
                    type="text" 
                    class="form-input" 
                    name="ho_ten" 
                    placeholder="Nhập họ và tên đầy đủ" 
                    value="<?= htmlspecialchars($old['ho_ten'] ?? '') ?>"
                    required>
            </div>

            <div class="form-group">
                <label class="form-label">Địa chỉ Email <span style="color: red;">*</span></label>
                <input 
                    type="email" 
                    class="form-input" 
                    name="email" 
                    placeholder="example@email.com" 
                    value="<?= htmlspecialchars($old['email'] ?? '') ?>"
                    required>
            </div>

            <div class="form-group">
                <label class="form-label">Số điện thoại</label>
                <input 
                    type="tel" 
                    class="form-input" 
                    name="sdt" 
                    placeholder="0123456789"
                    value="<?= htmlspecialchars($old['sdt'] ?? '') ?>">
            </div>

            <div class="form-group">
                <label class="form-label">Mật khẩu <span style="color: red;">*</span></label>
                <input 
                    type="password" 
                    class="form-input" 
                    name="password" 
                    placeholder="Tối thiểu 8 ký tự, có chữ hoa, số và ký tự đặc biệt" 
                    required>
                <small style="color: #666; font-size: 12px;">
                    Phải có: Chữ hoa, chữ thường, số và ký tự đặc biệt (@, #, $, !, ...)
                </small>
            </div>

            <div class="form-group">
                <label class="form-label">Xác nhận mật khẩu <span style="color: red;">*</span></label>
                <input 
                    type="password" 
                    class="form-input" 
                    name="confirm_password" 
                    placeholder="Nhập lại mật khẩu" 
                    required>
            </div>

            <div class="checkbox-group">
                <input type="checkbox" id="agree" name="agree" required>
                <label for="agree" class="checkbox-label">
                    Tôi đồng ý với <a href="#">điều khoản và điều kiện</a> và <a href="#">chính sách bảo mật</a>
                </label>
            </div>

            <button type="submit" class="register-btn">Đăng ký</button>
        </form>

        <div class="divider">
            <span class="divider-text">Or</span>
        </div>

        

        <div class="text-center mt-3">
            <p>Đã có tài khoản? 
                <a href="/WD20302-PRO1014_N5/nhahang/public/login">Đăng nhập</a>
            </p>
        </div>
    </div>
</div>