<style>


* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

:root {
    --sidebar-width: 280px;
    --main-bg: #f9f9f9;
    --white: #ffffff;
    --text-dark: #333;
    --text-sub: #777;
    --border-color: #eee;
    --primary-color: #1a73e8;
    --nav-hover: #f0f0f0;
}

body {
    background-color: var(--main-bg);
    color: var(--text-dark);
}

.container {
    display: flex;
    min-height: 100vh;
}

/* --- 1. Sidebar Styling --- */
.sidebar {
    width: var(--sidebar-width);
    background-color: var(--white);
    border-right: 1px solid var(--border-color);
    padding: 20px 0;
    display: flex;
    flex-direction: column;
    position: fixed; /* Giữ sidebar cố định */
    top: 0;
    left: 0;
    bottom: 0;
}

.sidebar-header {
    display: flex;
    align-items: center;
    padding: 0 20px 20px;
    margin-bottom: 10px;
}

.avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    margin-right: 10px;
}

.system-name {
    font-weight: 600;
    font-size: 16px;
}

.sub-text {
    color: var(--text-sub);
    font-size: 12px;
}

.sidebar-nav {
    flex-grow: 1; /* Cho phép nav chiếm hết không gian giữa header và footer */
}

.nav-item {
    display: flex;
    align-items: center;
    padding: 12px 20px;
    text-decoration: none;
    color: var(--text-dark);
    font-size: 14px;
    transition: background-color 0.2s;
}

.nav-item:hover {
    background-color: var(--nav-hover);
}

.nav-item.active {
    background-color: var(--nav-hover);
    font-weight: 600;
    border-right: 3px solid var(--primary-color);
}

.nav-item span.material-icons-outlined {
    margin-right: 15px;
    font-size: 20px;
    color: #444; /* Màu icon */
}

.sidebar-divider {
    border-top: 1px solid var(--border-color);
    margin: 10px 0;
}

.sidebar-demo {
    padding-bottom: 10px;
}

.sidebar-footer {
    padding: 10px 20px 0;
    border-top: 1px solid var(--border-color);
}

.login-info {
    font-size: 12px;
    color: var(--text-sub);
    margin-bottom: 10px;
}

.logout-btn {
    width: 100%;
    padding: 10px;
    border: 1px solid var(--border-color);
    background-color: var(--white);
    color: var(--text-dark);
    font-size: 14px;
    border-radius: 4px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: background-color 0.2s, border-color 0.2s;
}

.logout-btn:hover {
    background-color: var(--nav-hover);
    border-color: #ccc;
}

.logout-btn span.material-icons-outlined {
    margin-right: 8px;
    font-size: 18px;
}


/* --- 2. Main Content Styling --- */
.main-content {
    margin-left: var(--sidebar-width); /* Đẩy nội dung sang phải */
    padding: 30px;
    flex-grow: 1;
}

.dashboard-header {
    margin-bottom: 30px;
}

.dashboard-header h1 {
    font-size: 28px;
    font-weight: 600;
    margin-bottom: 5px;
}

.dashboard-header p {
    color: var(--text-sub);
    font-size: 16px;
}

/* Card General Styling */
.card {
    background-color: var(--white);
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05); /* Shadow nhẹ như trong Figma */
}

/* KPI Cards Section */
.kpi-cards {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 20px;
    margin-bottom: 30px;
}

.kpi-card {
    position: relative;
}

.kpi-title {
    font-size: 14px;
    color: var(--text-sub);
    margin-bottom: 10px;
}

.kpi-icon {
    position: absolute;
    top: 20px;
    right: 20px;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}

.kpi-icon span.material-icons-outlined {
    color: var(--white);
    font-size: 20px;
}

.kpi-icon.blue { background-color: #4285F4; } /* Tông xanh dương */
.kpi-icon.orange { background-color: #EA4335; } /* Tông cam đỏ */
.kpi-icon.green { background-color: #34A853; } /* Tông xanh lá */
.kpi-icon.purple { background-color: #9333ea; } /* Tông tím */


.kpi-data {
    font-size: 24px;
    font-weight: 700;
    margin-bottom: 5px;
}

.kpi-sub-text {
    font-size: 12px;
    color: var(--text-sub);
}

/* Activity and Notification Section */
.activity-notifications {
    display: grid;
    grid-template-columns: 2fr 1fr; /* Hoạt động (2 phần) và Thông báo (1 phần) */
    gap: 20px;
}

.activity-card, .notification-card {
    min-height: 250px; /* Chiều cao tối thiểu cho dễ nhìn */
}

.activity-notifications h2 {
    font-size: 18px;
    font-weight: 600;
    margin-bottom: 5px;
}

.activity-notifications p.sub-text {
    font-size: 14px;
    color: var(--text-sub);
}
</style>
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
            <div class="kpi-data"><?= isset($totalProducts) ? htmlspecialchars($totalProducts) : '0' ?></div>
            <div class="kpi-sub-text"></div>
        </div>

        <div class="card kpi-card">
            <div class="kpi-title">Chi nhánh</div>
            <span class="kpi-icon green"><span class="material-icons-outlined">storefront</span></span>
            <div class="kpi-data"><?= isset($totalBranches) ? htmlspecialchars($totalBranches) : '0' ?></div>
            <div class="kpi-sub-text"></div>
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
