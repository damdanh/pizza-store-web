<section class="booking-container">
    <div class="booking-image"></div>

    <div class="booking-form-section">
        <h2>ĐẶT BÀN</h2>
        <div class="booking-date">
            <span>📅 Mon 12, 2025</span>
            <span>👤 7052</span>
            <span>📝</span>
        </div>

        <!-- FORM DUY NHẤT -->
        <form action="/WD20302-PRO1014_N5/nhahang/public/process_booking.php" method="POST">

            <div class="form-section">
                <h3>Điền thông tin đặt bàn</h3>

                <div class="form-group">
                    <label>Số lượng người *</label>
                    <input type="number" id="people" name="people" min="1" value="2">
                </div>
                                
                <div class="form-group">
                    <label>Thời gian</label>
                    <select name="time">
                        <option>10:00:00</option>
                        <option>12:00:00</option>
                        <option>13:00:00</option>
                        <option>15:00:00</option>
                        <option>17:00:00</option>
                        <option selected>19:00:00</option>
                    </select>
                </div>
            </div>

            <div class="form-section">
                <h3>Chọn vùng</h3>
                <div class="location-select">
                    <select name="branch" style="width: 100%; padding: 10px; border: none; background: white; border-radius: 5px;">
                        <option>Pizza & Pasta - 24 Nguyễn Thị Nghĩa -</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label>Họ và tên *</label>
                <input type="text" name="name" required placeholder="Nhập họ và tên">
            </div>

            <div class="form-group">
                <label>Số điện thoại *</label>
                <input type="tel" name="phone" required placeholder="Ví dụ: 0901234567">
            </div>

            <div class="form-group">
                <label>Email (không bắt buộc)</label>
                <input type="email" name="email" placeholder="email@example.com">
            </div>

            <input type="hidden" name="date" value="2025-12-15">

            <button type="submit" class="submit-btn">Tiếp tục</button>
        </form>
    </div>
</section>
