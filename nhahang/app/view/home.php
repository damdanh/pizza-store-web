
<?php
$base_url_path = '/WD20302-PRO1014_N5/nhahang/';


$categoryImages = [
    1 => 'https://images.unsplash.com/photo-1528735602780-2552fd46c7af?w=300', 
    2 => 'https://images.unsplash.com/photo-1513104890138-7c749659a591?w=300', 
    3 => 'https://images.unsplash.com/photo-1625944525533-473f1a3d54e7?w=300',
    4 => 'https://images.unsplash.com/photo-1512621776951-a57141f2eefd?w=300', 
    5 => 'https://images.unsplash.com/photo-1621996346565-e3dbc646d9a9?w=300', 
    6 => 'https://images.unsplash.com/photo-1556679343-c7306c1976bc?w=300', 
];
?>
<section class="hero">
    <div class="hero-images">
        <div class="hero-image"></div>
        <div class="hero-image"></div>
        <div class="hero-image"></div>
    </div>
</section>


<section class="menu-section">
    <div class="container">
        <h2 class="section-title">THỰC ĐƠN</h2>
        
        <?php if (!isset($_SESSION['user_id'])): ?>
            <p style="text-align: center; color: #ff6b6b; margin-bottom: 20px;">
                <i class="fas fa-info-circle"></i> 
                Vui lòng <a href="<?php echo $base_url_path; ?>public/login" style="color: #ff6b6b; text-decoration: underline;">đăng nhập</a> để xem chi tiết thực đơn
            </p>
        <?php endif; ?>
        
        <div class="menu-categories">
            <?php 
            if (!empty($categories)): 
                foreach ($categories as $category):
                    $categoryImage = isset($categoryImages[$category['id_danh_muc_mon']]) 
                        ? $categoryImages[$category['id_danh_muc_mon']] 
                        : 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?w=300';
            ?>
            <a href="<?php echo $base_url_path; ?>public/category.php?id=<?php echo $category['id_danh_muc_mon']; ?>" style="text-decoration: none;">
                <div class="category-card">
                    <div class="category-icon" style="background-image: url('<?php echo $categoryImage; ?>')"></div>
                    <h3><?php echo htmlspecialchars($category['ten_danh_muc']); ?></h3>
                    <?php if (!empty($category['mo_ta'])): ?>
                        <p class="category-desc"><?php echo htmlspecialchars($category['mo_ta']); ?></p>
                    <?php endif; ?>
                </div>
            </a>
            <?php 
                endforeach; 
            else:
            ?>
            <p>Hiện chưa có danh mục nào để hiển thị.</p>
            <?php endif; ?>
        </div>
    </div>
</section>


<section class="popular-section">
    <div class="container">
        <h2 class="section-title">PHỔ BIẾN NHẤT</h2>
        <div class="dish-grid">
            <?php 
            if (!empty($popularProducts)): 
                foreach ($popularProducts as $product):

            ?>
            
            <div class="dish-card">
                <div class="dish-image" style="background-image: url('<?php echo htmlspecialchars($product['hinh_anh']); ?>')"></div>
                <div class="dish-info">
                    <p class="dish-name"><?php echo htmlspecialchars($product['ten_mon']); ?></p>
                    <div class="dish-footer">
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