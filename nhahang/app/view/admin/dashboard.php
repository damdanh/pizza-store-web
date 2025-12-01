<?php
$pageTitle = "Dashboard | Hệ thống Nhà hàng";
$activePage = "dashboard";
include 'views/layouts/header.php';
include 'views/layouts/sidebar.php';
?>

<main class="main-content">
    <header class="dashboard-header">
        <h1>Dashboard</h1>
        <p>Tổng quan về quản lý nhà hàng</p>
    </header>

    <section class="kpi-cards">
        <div class="card kpi-card">
            <div class="kpi-title">Tổng đặt bàn</div>
            <span class="kpi-icon blue"><span class="material-icons-outlined">event</span></span>
            <div class="kpi-data">0</div>
            <div class="kpi-sub-text">0 chờ xác nhận</div>
        </div>

        <div class="card kpi-card">
            <div class="kpi-title">Món ăn</div>
            <span class="kpi-icon orange"><span class="material-icons-outlined">restaurant</span></span>
            <div class="kpi-data">0</div>
            <div class="kpi-sub-text">0 chờ xác nhận</div>
        </div>

        <div class="card kpi-card">
            <div class="kpi-title">Chi nhánh</div>
            <span class="kpi-icon green"><span class="material-icons-outlined">storefront</span></span>
            <div class="kpi-data">0</div>
            <div class="kpi-sub-text">0 chờ xác nhận</div>
        </div>

        <div class="card kpi-card">
            <div class="kpi-title">Doanh thu hôm nay</div>
            <span class="kpi-icon purple"><span class="material-icons-outlined">attach_money</span></span>
            <div class="kpi-data">0</div>
            <div class="kpi-sub-text">0 chờ xác nhận</div>
        </div>
    </section>

    <section class="activity-notifications">
        <div class="card activity-card">
            <h2>Hoạt động gần đây</h2>
            <p class="sub-text">Chức năng này sẽ hiển thị các hoạt động gần đây của hệ thống</p>
        </div>

        <div class="card notification-card">
            <h2>Thông báo</h2>
            <p class="sub-text">Các thông báo quan trọng sẽ được hiển thị tại đây</p>
        </div>
    </section>
</main>

<?php include 'views/layouts/footer.php'; ?>
