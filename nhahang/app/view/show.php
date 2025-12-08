<?php
if (!class_exists('CategoryModel')) {
    require_once __DIR__ . '/../model/CategoryModel.php';
}
$categoryModel = new CategoryModel();
$allCategories = $categoryModel->getAllCategories();
$categoryImages = [
    1 => 'https://images.unsplash.com/photo-1528735602780-2552fd46c7af?w=300', 
    2 => 'https://images.unsplash.com/photo-1513104890138-7c749659a591?w=300', 
    3 => 'https://images.unsplash.com/photo-1625944525533-473f1a3d54e7?w=300',
    4 => 'https://images.unsplash.com/photo-1512621776951-a57141f2eefd?w=300', 
    5 => 'https://images.unsplash.com/photo-1621996346565-e3dbc646d9a9?w=300', 
    6 => 'https://images.unsplash.com/photo-1556679343-c7306c1976bc?w=300', 
];
?>

<div class="container">
    <div class="breadcrumb">
        <a href="<?php echo $base_url_path; ?>public/">Trang chủ</a>
        <span>/</span>
        <span class="active-item"><?php echo htmlspecialchars($category['ten_danh_muc']); ?></span>
    </div>
    
    <h1 class="section-title">Thực Đơn</h1>
    
    <div class="menu-categories">
        <?php foreach ($allCategories as $cat): 
            $catImage = isset($categoryImages[$cat['id_danh_muc_mon']]) 
                ? $categoryImages[$cat['id_danh_muc_mon']] 
                : '<?php echo $base_url_path; ?>public/user/img/default-category.jpg';
            $activeClass = ($cat['id_danh_muc_mon'] == $category['id_danh_muc_mon']) ? 'active' : '';
        ?>
            <a href="<?php echo $base_url_path; ?>public/category.php?id=<?php echo $cat['id_danh_muc_mon']; ?>" class="category-link <?php echo $activeClass; ?>">
                <div class="category-card">
                    <img src="<?php echo htmlspecialchars($catImage); ?>" alt="<?php echo htmlspecialchars($cat['ten_danh_muc']); ?>" class="category-img">
                    <div class="category-name"><?php echo htmlspecialchars($cat['ten_danh_muc']); ?></div>
                </div>
            </a>
        <?php endforeach; ?>
    </div>
    


    <div class="main-grid">
        <div class="products-section">
            <h2 class="category-header-title"><?php echo htmlspecialchars($category['ten_danh_muc']); ?></h2>
            
            <?php if (!empty($category['mo_ta'])): ?>
                <p class="category-description">
                    <?php echo htmlspecialchars($category['mo_ta']); ?>
                </p>
            <?php endif; ?>

            <?php if (!empty($products)): ?>
                <div class="products-grid">
                    <?php foreach ($products as $product): ?>
                        <div class="product-card" data-product-id="<?php echo htmlspecialchars($product['id_mon']); ?>">
                            
                         

                            <img src="<?php echo htmlspecialchars($product['hinh_anh']); ?>" alt="<?php echo htmlspecialchars($product['ten_mon']); ?>" class="product-img">
                            
                            <div class="product-info">
                                <a href="<?php echo $base_url_path; ?>public/product_detail.php?id=<?php echo htmlspecialchars($product['id_mon']); ?>" class="product-name">
                                    <?php echo htmlspecialchars($product['ten_mon']); ?>
                                </a>
                                
                             
                                
                                <div class="product-actions">
                                    <a href="<?php echo $base_url_path; ?>public/product_detail.php?id=<?php echo htmlspecialchars($product['id_mon']); ?>" class="detail-btn">
                                    </a>
                                    <button class="add-to-cart-btn" data-product-id="<?php echo htmlspecialchars($product['id_mon']); ?>">
                                        +
                                    </button>
                                    <div class="product-price">
                                        <?php echo number_format($product['gia'], 0, ',', '.'); ?> vnđ
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

            <?php else: ?>
                <div class="empty-state">
                    <img src="https://img.icons8.com/clouds/200/000000/empty-box.png" alt="Empty" class="empty-image">
                    <h3>Chưa có món ăn nào trong danh mục này</h3>
                    <a href="<?php echo $base_url_path; ?>public/" class="back-home-link">
                        Quay về trang chủ
                    </a>
                </div>
            <?php endif; ?>
        </div>


<aside class="cart-sidebar"> 
            <h2 class="cart-title">GIỎ HÀNG CỦA TÔI</h2>
            
            <div class="cart-empty" id="cart-empty-message">
                <div class="cart-icon">
                    <i class="fas fa-shopping-cart"></i>
                </div>
                <p class="cart-empty-text">Giỏ hàng của bạn đang trống</p>
            </div>
            
            <div class="cart-items-list" id="cart-items-container" style="display:none;">
                </div>

            <div class="cart-summary" id="cart-summary" style="display:none;">
                <div class="summary-line">
                    <span>Tạm tính:</span>
                    <span id="subtotal-price">0 vnđ</span> </div>
              
                <div class="summary-total">
                    <span>Tổng cộng:</span>
                    <span id="total-price">0 vnđ</span> </div>
            </div>

            <div class="cart-buttons-area" id="cart-actions" style="display:none;">
                <!-- <button class="checkout-btn">ĐẶT HÀNG</button> -->
            </div>
        </aside>
<script>
const BASE_URL = '/WD20302-PRO1014_N5/nhahang/';
</script>
<script src="<?php echo $base_url_path; ?>public/user/cart.js"></script>
    </div>
</div>