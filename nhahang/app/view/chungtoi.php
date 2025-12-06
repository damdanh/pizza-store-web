<?php
$base_url_path = '/WD20302-PRO1014_N5/nhahang/'; 
$title = $title ?? 'PIZZA & PASTA - Nhà Hàng Online'; 
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <title><?php echo htmlspecialchars($title); ?></title>
    
    <link rel="stylesheet" href="<?php echo $base_url_path; ?>public/user/css/chungtoi.css">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"> 
</head>
<body>
<!-- Chef Introduction Section -->
<section class="chef-intro">
        <div class="chef-container">
            <div class="chef-content">
                <h2>CHEF VINCENZO</h2>
                <h3>Bếp Trưởng Điều Hành & Chuyên gia Ẩm thực Ý</h3>
                <p>Ẩm thực Ý là bản hòa tấu của hương vị, nơi mỗi chiếc Pizza hay đĩa Pasta đều mang trong mình câu chuyện và niềm đam mê. Tại **PIZZA & PASTA**, Chef Vincenzo cam kết mang đến trải nghiệm **ẩm thực Ý đích thực** với nguồn nguyên liệu tươi ngon nhất và công thức truyền thống được gìn giữ. Chúng tôi không chỉ phục vụ món ăn, chúng tôi phục vụ văn hóa và tình yêu ẩm thực từ trái tim nước Ý, sẵn sàng làm hài lòng cả những thực khách khó tính nhất.</p>
            </div>
            <div class="chef-image">
                <img src="https://images.unsplash.com/photo-1577219491135-ce391730fb2c?w=600" alt="Chef Vincenzo - Bếp Trưởng">
            </div>
        </div>
    </section>

    <!-- Welcome Section -->
    <section class="welcome-section">
        <h2>Nơi hương vị Ý gặp gỡ đam mê ẩm thực</h2>
        <div class="restaurant-image">
            <img src="https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?w=1200" alt="Không gian nhà hàng Pizza & Pasta">
        </div>
    </section>

    <!-- Blog Section -->
    <section class="menu-section">
        <div class="container">
            <h2 class="section-title">GÓC ẨM THỰC Ý</h2>
            <div class="blog-grid">
                <div class="blog-card">
                    <div class="blog-image" style="background-image: url('https://images.unsplash.com/photo-1592861956120-e524fc739696?w=400')"></div>
                </div>
                <div class="blog-card">
                    <div class="blog-image" style="background-image: url('https://images.unsplash.com/photo-1513104890138-7c749659a591?w=400')"></div>
                </div>
                <div class="blog-card">
                    <div class="blog-image" style="background-image: url('https://images.unsplash.com/photo-1565299624946-b28f40a0ae38?w=400')"></div>
                </div>
                <div class="blog-card">
                    <div class="blog-image" style="background-image: url('https://images.unsplash.com/photo-1574071318508-1cdbab80d002?w=400')"></div>
                </div>
                <div class="blog-card selected">
                    <div class="blog-image" style="background-image: url('https://images.unsplash.com/photo-1571997478779-2adcbbe9ab2f?w=400')"></div>
                </div>
                <div class="blog-card">
                    <div class="blog-image" style="background-image: url('https://images.unsplash.com/photo-1555939594-58d7cb561ad1?w=400')"></div>
                </div>
            </div>
        </div>
    </section>

    <!-- Community Section -->
    <section class="community-section">
        <div class="container">
            <h2>THAM GIA CỘNG ĐỒNG CỦA CHÚNG TÔI</h2>
            <p>Đăng ký để nhận thông tin khuyến mại mới nhất của các Thực Đơn, Ưu Đãi, Tin Tức và các Bài Nhật ký mới nhất của chúng tôi</p>
            <form class="subscribe-form">
                <input type="text" placeholder="Tên">
                <input type="text" placeholder="Họ">
                <input type="email" placeholder="Địa chỉ Email của bạn">
                <button type="submit">ĐĂNG KÝ</button>
            </form>
            <p class="subscribe-note">Mọi thông tin được nhập vào trong Hộp thư sẽ được bảo mật theo chính sách của chúng tôi<br>Bạn có thể hủy đăng ký vào bất cứ lúc nào.</p>
        </div>
    </section>
</body>
</html>