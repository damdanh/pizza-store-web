<?php
// file: profile.php (ĐÃ LOẠI BỎ LOGIC ĐÁNH GIÁ VÀ GIAO DIỆN)
// Tên file: profile.php
$base_url_path = '/WD20302-PRO1014_N5/nhahang/';

// ==== SAFE LOAD DATA (Giữ nguyên) ====
$customer   = is_array($customer) && !empty($customer) ? $customer : ['ten' => 'Khách hàng', 'ngay_tao' => date('Y-m-d'), 'id_khach_hang' => 0];
$membership = is_array($membership) && !empty($membership) ? $membership : ['hang_thanh_vien' => 'thuong', 'tong_chi_tieu' => 0];
// Dữ liệu orders đã được giả định là có sẵn từ Controller
$orders     = is_array($orders) ? $orders : [];
$reviews    = is_array($reviews) ? $reviews : [];

// ======== TẠO CẤU HÌNH HẠNG THÀNH VIÊN ========
$rankStyles = [
    'kimcuong' => ['color' => '#00c6ff', 'icon' => '💎'],
    'vang'     => ['color' => '#ffcc00', 'icon' => '🥇'],
    'bac'      => ['color' => '#c0c0c0', 'icon' => '🥈'],
    'dong'     => ['color' => '#cd7f32', 'icon' => '🥉'], // THÊM HẠNG ĐỒNG
    'thuong'   => ['color' => '#8d8d8d', 'icon' => '⭐'],
];

// Lấy hạng thành viên, nếu không tồn tại hoặc null, mặc định là 'thuong'
$rank = $membership['hang_thanh_vien'] ?? 'thuong';
// Kiểm tra rank có hợp lệ không, nếu không, dùng mặc định
if (!isset($rankStyles[$rank])) {
    $rank = 'thuong';
}

$rankColor = $rankStyles[$rank]['color'];
$rankIcon  = $rankStyles[$rank]['icon'];

// Biến $accountModel đã được truyền từ Controller và không còn dùng trong View

// Xóa hàm giả định kiểm tra ngày (vì không cần logic đánh giá)
?>

<link rel="stylesheet" href="<?php echo $base_url_path; ?>public/user/css/profile.css">
<style>
    /* Xóa các styles liên quan đến đánh giá (star-rating, note-input, submit-note-btn) */
    .review-action-container {
        display: flex;
        flex-direction: column;
        align-items: center;
        max-width: 250px;
        margin: 0 auto;
        padding: 5px;
    }
</style>


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
                    <span class="stat-label">Đơn hàng/Đặt bàn</span>
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
                    'dong'     => ['Tích điểm x1.5', 'Ưu đãi sinh nhật'],
                    'thuong'   => ['Tích điểm cơ bản', 'Ưu đãi mùa vụ']
                ];

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
    </div>


    <div id="orders" class="tab-content active">
        <?php if (empty($orders)): ?>
            <p>Chưa có đơn hàng hoặc đơn đặt bàn nào.</p>
        <?php else: ?>
        <table class="order-table">
            <thead>
                <tr>
                    <th>Mã</th>
                    <th>Ngày đặt</th>
                    <th>Tổng tiền</th> <th>Trạng thái</th>
                    </tr>
            </thead>

            <tbody>
                <?php foreach ($orders as $order): ?>
                    <?php 
                        $orderId = $order['id_don_hang'] ?? 0;
                        $isBooking = ($order['loai_don'] ?? '') === 'booking';
                        $ngayDat = $order['ngay_dat'] ?? date('Y-m-d');
                        $displayTotal = $order['tong_tien_hien_thi'] ?? 0;
                        
                        // Giá trị cọc (total) được lưu trong tong_tien
                        $deposit = $order['tong_tien'] ?? 0;
                    ?>
                    <tr>
                        <td>#<?= $orderId ?></td>
                        <td><?= date('d/m/Y', strtotime($ngayDat)) ?></td>
                        <td style="font-weight: 600; color: <?= $isBooking ? '#27ae60' : '#2c3e50' ?>;">
                            <?= number_format($displayTotal, 0, ',', '.') ?> VNĐ
                            <?php if ($isBooking): ?>
                                <small style="display: block; font-weight: normal; color: #7f8c8d;">
                                    (Tổng món: <?= number_format($displayTotal, 0, ',', '.') ?>đ)
                                </small>
                                <small style="display: block; font-weight: normal; color: #e67e22;">
                                    Đã cọc: <?= number_format($deposit, 0, ',', '.') ?>đ
                                </small>
                            <?php endif; ?>
                        </td>
                        <td>
                            <span style="font-weight: bold;">
                                <?= htmlspecialchars($order['trang_thai'] ?? 'Không rõ') ?>
                            </span>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php endif; ?>
    </div>


    <div id="reviews" class="tab-content">
        <p>Tính năng đánh giá đang được bảo trì.</p>
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