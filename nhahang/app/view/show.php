<?php
$base_url_path = '/WD20302-PRO1014_N5/nhahang/';
?>

<!-- Breadcrumb -->
<section class="breadcrumb-section" style="padding: 20px 0; background: #f8f9fa;">
    <div class="container">
        <nav style="font-size: 14px;">
            <a href="<?php echo $base_url_path; ?>public/" style="color: #666; text-decoration: none;">Trang chủ</a>
            <span style="margin: 0 10px; color: #999;">/</span>
            <span style="color: #333; font-weight: 500;"><?php echo htmlspecialchars($category['ten_danh_muc']); ?></span>
        </nav>
    </div>
</section>

<!-- Category Header -->
<section class="category-header" style="padding: 40px 0; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
    <div class="container">
        <h1 style="color: white; font-size: 36px; margin: 0;"><?php echo htmlspecialchars($category['ten_danh_muc']); ?></h1>
        <?php if (!empty($category['mo_ta'])): ?>
            <p style="color: rgba(255,255,255,0.9); margin-top: 10px; font-size: 16px;">
                <?php echo htmlspecialchars($category['mo_ta']); ?>
            </p>
        <?php endif; ?>
        <p style="color: rgba(255,255,255,0.8); margin-top: 15px;">
            Có <?php echo count($products); ?> món ăn trong danh mục này
        </p>
    </div>
</section>

<!-- Products Grid -->
<section class="products-section" style="padding: 60px 0;">
    <div class="container">
        <?php if (!empty($products)): ?>
            <div class="dish-grid">
                <?php foreach ($products as $product): ?>
                    <div class="dish-card">
                        <div class="dish-image" style="background-image: url('<?php echo htmlspecialchars($product['hinh_anh']); ?>')"></div>
                        <div class="dish-info">
                            <p class="dish-name"><?php echo htmlspecialchars($product['ten_mon']); ?></p>
                            <?php if (!empty($product['mo_ta'])): ?>
                                <p class="dish-description" style="font-size: 13px; color: #666; margin: 10px 0; line-height: 1.4; max-height: 40px; overflow: hidden;">
                                    <?php echo htmlspecialchars(mb_substr($product['mo_ta'], 0, 80)) . '...'; ?>
                                </p>
                            <?php endif; ?>
                            <div class="dish-footer">
                                <button class="add-btn">+</button>
                                <p class="dish-price"><?php echo number_format($product['gia'], 0, ',', '.'); ?> vnđ</p>
                            </div>
                            <?php if ($product['trang_thai'] != 'Còn hàng'): ?>
                                <div class="out-of-stock" style="position: absolute; top: 10px; right: 10px; background: #ff4444; color: white; padding: 5px 10px; border-radius: 5px; font-size: 12px;">
                                    <?php echo htmlspecialchars($product['trang_thai']); ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div style="text-align: center; padding: 60px 20px;">
                <img src="https://img.icons8.com/clouds/200/000000/empty-box.png" alt="Empty" style="opacity: 0.5;">
                <h3 style="color: #666; margin-top: 20px;">Chưa có món ăn nào trong danh mục này</h3>
                <a href="<?php echo $base_url_path; ?>public/" style="display: inline-block; margin-top: 20px; padding: 12px 30px; background: #667eea; color: white; text-decoration: none; border-radius: 5px;">
                    Quay về trang chủ
                </a>
            </div>
        <?php endif; ?>
    </div>
</section>

<!-- Related Categories -->
<section class="related-categories" style="padding: 40px 0; background: #f8f9fa;">
    <div class="container">
        <h2 style="text-align: center; margin-bottom: 30px;">Danh mục khác</h2>
        <div class="menu-categories">
            <?php
            // Lấy danh sách danh mục khác (không bao gồm danh mục hiện tại)
            $categoryModel = new CategoryModel();
            $allCategories = $categoryModel->getAllCategories();
            $otherCategories = array_filter($allCategories, function($cat) use ($category) {
                return $cat['id_danh_muc_mon'] != $category['id_danh_muc_mon'];
            });
            
            $categoryImages = [
                1 => 'https://images.unsplash.com/photo-1528735602780-2552fd46c7af?w=300',
                2 => 'https://images.unsplash.com/photo-1513104890138-7c749659a591?w=300',
                3 => 'https://images.unsplash.com/photo-1625944525533-473f1a3d54e7?w=300',
                4 => 'https://images.unsplash.com/photo-1512621776951-a57141f2eefd?w=300',
                5 => 'https://images.unsplash.com/photo-1621996346565-e3dbc646d9a9?w=300',
                6 => 'https://images.unsplash.com/photo-1556679343-c7306c1976bc?w=300',
            ];
            
            foreach (array_slice($otherCategories, 0, 5) as $cat):
                $catImage = isset($categoryImages[$cat['id_danh_muc_mon']]) 
                    ? $categoryImages[$cat['id_danh_muc_mon']] 
                    : 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?w=300';
            ?>
                <a href="<?php echo $base_url_path; ?>public/category.php?id=<?php echo $cat['id_danh_muc_mon']; ?>" style="text-decoration: none;">
                    <div class="category-card">
                        <div class="category-icon" style="background-image: url('<?php echo $catImage; ?>')"></div>
                        <h3><?php echo htmlspecialchars($cat['ten_danh_muc']); ?></h3>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>