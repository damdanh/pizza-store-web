<!-- Hero Section -->
 <?php
$base_url_path = '/WD20302-PRO1014_N5/nhahang/';
?>
    <section class="hero">
        <div class="hero-images">
            <div class="hero-image"></div>
            <div class="hero-image"></div>
            <div class="hero-image"></div>
        </div>
    </section>

    <!-- Menu Categories -->
    <section class="menu-section">
        <div class="container">
            <h2 class="section-title">THỰC ĐƠN</h2>
            <div class="menu-categories">
                <div class="category-card">
                    <div class="category-icon" style="background-image: url('https://images.unsplash.com/photo-1528735602780-2552fd46c7af?w=300')"></div>
                    <h3>Delivery Combo</h3>
                </div>
                <div class="category-card">
                    <div class="category-icon" style="background-image: url('https://images.unsplash.com/photo-1513104890138-7c749659a591?w=300')"></div>
                    <h3>Bánh pizza</h3>
                </div>
                <div class="category-card">
                    <div class="category-icon" style="background-image: url('https://images.unsplash.com/photo-1625944525533-473f1a3d54e7?w=300')"></div>
                    <h3>Khai vị</h3>
                </div>
                <div class="category-card">
                    <div class="category-icon" style="background-image: url('https://images.unsplash.com/photo-1621996346565-e3dbc646d9a9?w=300')"></div>
                    <h3>Món chính + mỳ ý</h3>
                </div>
                <div class="category-card">
                    <div class="category-icon" style="background-image: url('https://images.unsplash.com/photo-1512621776951-a57141f2eefd?w=300')"></div>
                    <h3>Salad</h3>
                </div>
                <div class="category-card">
                    <div class="category-icon" style="background-image: url('https://images.unsplash.com/photo-1556679343-c7306c1976bc?w=300')"></div>
                    <h3>Thức uống</h3>
                </div>
            </div>
        </div>
    </section>

    <!-- Popular Dishes -->
    <section class="popular-section">
        <div class="container">
            <h2 class="section-title">PHỔ BIẾN NHẤT</h2>
            <div class="dish-grid">
                <?php 
                // Biến $popularProducts được Controller gửi sang.
                if (!empty($popularProducts)): 
                    
                    foreach ($popularProducts as $product):
                        // CÁC CỘT DỮ LIỆU: id_mon, ten_mon, gia, hinh_anh
                ?>
                
                <div class="dish-card">
                    <div class="dish-image" style="background-image: url('<?php echo htmlspecialchars($product['hinh_anh']); ?>')"></div>
                    <div class="dish-info">
                        <p class="dish-name"><?php echo htmlspecialchars($product['ten_mon']); ?></p>
                        <div class="dish-footer">
                            <button class="add-btn">+</button>
                            <p class="dish-price"><?php echo number_format($product['gia'], 0, ',', '.'); ?> vnđ</p>
                        </div>
                    </div>
                </div>

                <?php 
                    endforeach; 
                else:
                ?>
                <p>Hiện chưa có món ăn phổ biến nào để hiển thị.</p>
                <?php endif; ?>
                
            </div>
        </div>
    </section>

    <!-- Community Section -->
    <section class="community-section">
        <div class="container">
            <h2>THAM GIA CỘNG ĐỒNG CỦA CHÚNG TÔI</h2>
            <p>Đăng ký để nhận thông tin khuyến mại mới nhất của các Thực Đơn, Ưu Đãi, Tin Tức và các Câu Nhật ký mới nhất của chúng tôi</p>
            <form class="subscribe-form">
                <input type="text" placeholder="Tên">
                <input type="text" placeholder="Họ">
                <input type="email" placeholder="Địa chỉ Email của bạn">
                <button type="submit">ĐĂNG KÝ</button>
            </form>
            <p class="subscribe-note">Mọi thông tin cần tương thành trong Hộp thư sẽ có thông qua đó cho các biên nhân<br>Bạn có thể hủy đăng ký vào bất cứ lúc nào.</p>
        </div>
    </section>