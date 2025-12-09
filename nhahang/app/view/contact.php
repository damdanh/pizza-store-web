


<div class="banner">
    <img src="https://images.unsplash.com/photo-1414235077428-338989a2e8c0?w=1600&h=400&fit=crop" alt="Contact Banner">
    <div class="banner-text">LIÊN HỆ</div>
</div>

<div class="contact-container">
    <aside class="contact-sidebar">
        <h2 class="sidebar-title">Gửi Thông Tin</h2>
        <form class="contact-form" method="POST">
    <?php if (!empty($message)): ?>
        <p style="color: green; font-weight: bold;"><?php echo $message; ?></p>
    <?php endif; ?>

    <div class="form-group">
        <label>HỌ VÀ TÊN</label>
        <input name="ho_ten" type="text" placeholder="Nguyễn Văn A" class="form-input" required>
    </div>

    <div class="form-group">
        <label>SỐ ĐIỆN THOẠI</label>
        <input name="sdt" type="tel" placeholder="Số điện thoại" class="form-input" required>
    </div>

    <div class="form-group">
        <label>EMAIL</label>
        <input name="email" type="email" placeholder="abc@gmail.com" class="form-input" required>
    </div>

    <div class="form-group">
        <label>NỘI DUNG</label>
        <textarea name="noi_dung" class="form-textarea" rows="5" required></textarea>
    </div>

    <button type="submit" class="form-submit">GỬI</button>
</form>

    </aside>

    <div class="contact-content">
        <h2 class="content-title">Thông Tin Liên Hệ</h2>

        <div class="info-grid">
            <div class="info-card">
                <div class="info-icon">
                    <i class="fas fa-map-marker-alt"></i>
                </div>
                <div class="info-label">Địa Chỉ</div>
                <div class="info-text">
                    24, Nguyễn Thị Nghĩa,<br>
                    Phường Bến Thành, Quận 1<br>
                    Thành Phố Hồ Chí Minh
                </div>
            </div>

            <div class="info-card">
                <div class="info-icon">
                    <i class="far fa-clock"></i>
                </div>
                <div class="info-label">Giờ Hoạt Động</div>
                <div class="info-text">
                    Thứ 2 - Chủ Nhật (Trừ ngày<br>
                    lễ và Tết): 10:30 - 23:00<br>
                    Phục vụ theo phiên: Trưa,<br>
                    Chiều/Tối (TPV)
                </div>
            </div>

            <div class="info-card">
                <div class="info-icon">
                    <i class="far fa-envelope"></i>
                </div>
                <div class="info-label">Email</div>
                <div class="info-text">
                    ivan.sinaga@
gmail.com
                </div>
            </div>

            <div class="info-card">
                <div class="info-icon">
                    <i class="fas fa-phone-alt"></i>
                </div>
                <div class="info-label">Phone</div>
                <div class="info-text">
                    +6287654321
                </div>
            </div>
        </div>

        <div class="map-container">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3919.4967829956694!2d106.69741831533428!3d10.773004962181988!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31752f4b3330bcc9%3A0xb55e07593e74d9d!2zMjQgTmd1eeG7hW4gVGjhu4sgTmdoxKlhLCBCw6BuIE5naMOoLCBRdeG6rW4gMSwgVGjDoG5oIHBo4buRIEjhu5MgQ2jDrSBNaW5oLCBWaeG7h3QgTmFt!5e0!3m2!1svi!2s!4v1624511234567!5m2!1svi!2s" ...></iframe>
        </div>
    </div>
</div>


