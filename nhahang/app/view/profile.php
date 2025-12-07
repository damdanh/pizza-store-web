<?php
// Tên file: profile.php
$base_url_path = '/WD20302-PRO1014_N5/nhahang/';

// ==== SAFE LOAD DATA (Đã điều chỉnh để an toàn hơn) ====
$customer   = is_array($customer) && !empty($customer) ? $customer : ['ten' => 'Khách hàng', 'ngay_tao' => date('Y-m-d'), 'id_khach_hang' => 0];
$membership = is_array($membership) && !empty($membership) ? $membership : ['hang_thanh_vien' => 'thuong', 'tong_chi_tieu' => 0];
$orders     = is_array($orders) ? $orders : [];
$reviews    = is_array($reviews) ? $reviews : [];

// ======== TẠO CẤU HÌNH HẠNG THÀNH VIÊN ========
$rankStyles = [
    'kimcuong' => ['color' => '#00c6ff', 'icon' => '💎'],
    'vang'     => ['color' => '#ffcc00', 'icon' => '🥇'],
    'bac'      => ['color' => '#c0c0c0', 'icon' => '🥈'],
    'thuong'   => ['color' => '#8d8d8d', 'icon' => '🥉'],
];

// Lấy hạng thành viên, nếu không tồn tại hoặc null, mặc định là 'thuong'
$rank = $membership['hang_thanh_vien'] ?? 'thuong';
// Kiểm tra rank có hợp lệ không, nếu không, dùng mặc định
if (!isset($rankStyles[$rank])) {
    $rank = 'thuong';
}

$rankColor = $rankStyles[$rank]['color'];
$rankIcon  = $rankStyles[$rank]['icon'];
?>

<link rel="stylesheet" href="<?php echo $base_url_path; ?>public/user/css/profile.css">

<div class="account-container">

    <?php if (!empty($_SESSION['success'])): ?>
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i> <?= $_SESSION['success']; unset($_SESSION['success']); ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($_SESSION['error'])): ?>
        <div class="alert alert-error">
            <i class="fas fa-exclamation-circle"></i> <?= $_SESSION['error']; unset($_SESSION['error']); ?>
        </div>
    <?php endif; ?>


    <section class="membership-card">

        <div class="membership-header"
             style="background: linear-gradient(135deg, <?= $rankColor ?>, <?= $rankColor ?>dd );">

            <div class="rank-badge">
                <span class="rank-icon"><?= $rankIcon ?></span>
                <h2><?= ucfirst($rank) ?></h2>
            </div>

            <div class="member-info">
                <h3><?= htmlspecialchars($customer['ten'] ?? 'Khách hàng') ?></h3>
                <p>Thành viên từ: 
                    <?php 
                    $ngay_tao = $customer['ngay_tao'] ?? date('Y-m-d');
                    echo date('d/m/Y', strtotime($ngay_tao)); 
                    ?>
                </p>
            </div>
        </div>

        <div class="membership-stats">
            <div class="stat-item">
                <i class="fas fa-shopping-bag"></i>
                <div>
                    <span class="stat-value"><?= count($orders) ?></span>
                    <span class="stat-label">Đơn hàng</span>
                </div>
            </div>

            <div class="stat-item">
                <i class="fas fa-wallet"></i>
                <div>
                    <span class="stat-value"><?= number_format($membership['tong_chi_tieu'] ?? 0) ?> VNĐ</span>
                    <span class="stat-label">Tổng chi tiêu</span>
                </div>
            </div>
        </div>

        <div class="membership-benefits">
            <h3>Ưu đãi đặc biệt</h3>

            <ul>
                <?php
                $benefits = [
                    'kimcuong' => ['Ưu tiên đặt bàn', 'Giảm giá 15%', 'Quà tặng đặc biệt'],
                    'vang'     => ['Giảm giá 10%', 'Ưu tiên cuối tuần'],
                    'bac'      => ['Giảm giá 5%', 'Tích điểm x2'],
                    'thuong'   => ['Tích điểm cơ bản', 'Ưu đãi mùa vụ']
                ];

                // Đã kiểm tra $rank ở trên, đảm bảo truy cập an toàn
                $currentBenefits = $benefits[$rank] ?? $benefits['thuong'];

                foreach ($currentBenefits as $ud) {
                    echo "<li><i class='fas fa-check'></i> $ud</li>";
                }
                ?>
            </ul>
        </div>

    </section>


    <div class="tabs">
        <button class="tab-btn active" data-tab="orders">Lịch sử đơn hàng</button>
        <button class="tab-btn" data-tab="reviews">Đánh giá của tôi</button>
    </div>


    <div id="orders" class="tab-content active">
        <?php if (empty($orders)): ?>
            <p>Chưa có đơn hàng nào.</p>
        <?php else: ?>
        <table class="order-table">
            <thead>
                <tr>
                    <th>Mã đơn</th>
                    <th>Ngày đặt</th>
                    <th>Tổng tiền</th>
                    <th>Trạng thái</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($orders as $order): ?>
                    <tr>
                        <td>#<?= $order['id_don_hang'] ?? 'N/A' ?></td>
                        <td><?= date('d/m/Y', strtotime($order['ngay_dat'] ?? date('Y-m-d'))) ?></td>
                        <td><?= number_format($order['tong_tien'] ?? 0) ?> VNĐ</td>
                        <td><?= htmlspecialchars($order['trang_thai'] ?? 'Không rõ') ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php endif; ?>
    </div>


    <div id="reviews" class="tab-content">
        <?php if (empty($reviews)): ?>
            <p>Chưa có đánh giá nào.</p>
        <?php else: ?>
            <?php foreach ($reviews as $review): ?>
                <div class="review-item">
                    <div class="stars"><?= str_repeat('⭐', $review['sao'] ?? 0) ?></div>
                    <p><?= htmlspecialchars($review['nhan_xet'] ?? 'Không có nhận xét') ?></p>
                    <small>Đơn hàng #<?= $review['id_don_hang'] ?? 'N/A' ?> - <?= date('d/m/Y H:i', strtotime($review['ngay_danh_gia'] ?? date('Y-m-d H:i'))) ?></small>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

</div>


<script>
const tabBtns = document.querySelectorAll('.tab-btn');
const tabContents = document.querySelectorAll('.tab-content');

tabBtns.forEach(btn => {
    btn.addEventListener('click', () => {
        tabBtns.forEach(b => b.classList.remove('active'));
        tabContents.forEach(c => c.classList.remove('active'));

        btn.classList.add('active');
        document.getElementById(btn.dataset.tab).classList.add('active');
    });
});
</script>