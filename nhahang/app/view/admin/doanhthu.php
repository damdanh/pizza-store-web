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
        --black-btn: #222;
        --black-btn-hover: #000;
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
        position: fixed;
        top: 0;
        left: 0;
        bottom: 0;
        z-index: 100;
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
        object-fit: cover;
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
        flex-grow: 1;
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
        color: #444;
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
        margin-left: var(--sidebar-width);
        padding: 30px;
        flex-grow: 1;
    }

    .card {
        background-color: var(--white);
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
    }

    /* Tiêu đề trang (Page Header) */
    .page-header {
        margin-bottom: 30px;
    }

    .page-header h1 {
        font-size: 28px;
        font-weight: 600;
        margin-bottom: 5px;
    }

    .page-header p {
        color: var(--text-sub);
        font-size: 16px;
    }

    /* Bộ lọc thời gian/chi nhánh */
    .filter-controls-revenue {
        display: flex;
        gap: 15px;
        margin-bottom: 20px;
    }

    .filter-controls-revenue>* {
        flex-grow: 1;
        max-width: 250px;
        /* Giới hạn chiều rộng cho các bộ lọc */
    }

    .date-input,
    .branch-select {
        padding: 10px 12px;
        border: 1px solid var(--border-color);
        border-radius: 4px;
        font-size: 14px;
        color: var(--text-dark);
        background-color: var(--white);
        cursor: pointer;
    }

    /* Khu vực Biểu đồ/Số liệu */
    .revenue-stats {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        /* 3 cột cho các thẻ KPI nhỏ */
        gap: 20px;
        margin-bottom: 30px;
    }

    .stat-card {
        padding: 20px;
        border-left: 5px solid var(--primary-color);
        /* Đường kẻ nhấn */
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .stat-value {
        font-size: 24px;
        font-weight: 700;
    }

    .stat-label {
        color: var(--text-sub);
        font-size: 14px;
    }

    .chart-area {
        min-height: 400px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        color: var(--text-sub);
        /* Nếu bạn dùng thư viện biểu đồ (Chart.js), mã biểu đồ sẽ nằm ở đây */
    }
</style>
<?php
$pageTitle = "Thống kê Doanh thu | Hệ thống Nhà hàng";
$activePage = "doanhthu";
include 'views/layouts/header.php';
include 'views/layouts/sidebar.php';
?>

<main class="main-content">
    <header class="page-header">
        <h1>Thống kê Doanh thu</h1>
        <p>Xem tổng quan về doanh thu và lợi nhuận của hệ thống</p>
    </header>

    <div class="filter-controls-revenue">
        <input type="date" class="date-input" value="2025-11-01">
        <input type="date" class="date-input" value="2025-11-27">
        <select class="branch-select">
            <option>Tất cả chi nhánh</option>
            <option>Chi nhánh 1</option>
            <option>Chi nhánh 2</option>
        </select>
    </div>

    <section class="revenue-stats">
        <div class="card stat-card">
            <div>

                <div class="stat-value">500,000,000 VNĐ</div>
                <div class="stat-label">Tổng Doanh thu</div>
            </div>
            <span class="material-icons-outlined" style="color: #34A853;">paid</span>
        </div>

        <div class="card stat-card">
            <div>
                <div class="stat-value">50,000,000 VNĐ</div>
                <div class="stat-label">Lợi nhuận ròng</div>
            </div>
            <span class="material-icons-outlined" style="color: #4285F4;">trending_up</span>
        </div>

        <div class="card stat-card">
            <div>
                <div class="stat-value">10</div>
                <div class="stat-label">Tổng đơn hàng</div>
            </div>
            <span class="material-icons-outlined" style="color: #EA4335;">shopping_cart</span>
        </div>
    </section>

    <section class="card chart-area">
        <canvas id="revenueChart" width="100%" style="max-width:1000px"></canvas>
    </section>

    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Dữ liệu giả định (mẫu) — giữ nguyên
    const labels = [
        '2025-11-21', '2025-11-22', '2025-11-23', '2025-11-24', '2025-11-25', '2025-11-26', '2025-11-27'
    ];

    const revenueData = [12000000, 15000000, 10000000, 18000000, 22000000, 20000000, 25000000]; // VNĐ
    const profitData = [4000000, 5000000, 3000000, 6000000, 7000000, 6500000, 9000000]; // VNĐ

    const ctx = document.getElementById('revenueChart').getContext('2d');
    const revenueChart = new Chart(ctx, {
        // *** THAY ĐỔI LỚN NHẤT: type: 'bar' ***
        type: 'bar', 
        data: {
            labels: labels,
            datasets: [
                {
                    label: 'Doanh thu (VNĐ)',
                    data: revenueData,
                    // Đối với biểu đồ cột, chúng ta dùng backgroundColor thay vì borderColor cho màu chính
                    backgroundColor: '#4285F4', 
                    borderColor: '#4285F4',
                    borderWidth: 1,
                    // Bỏ thuộc tính tension và fill không cần thiết cho biểu đồ cột
                },
                {
                    label: 'Lợi nhuận (VNĐ)',
                    data: profitData,
                    backgroundColor: '#34A853',
                    borderColor: '#34A853',
                    borderWidth: 1,
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                x: {
                    display: true,
                    title: { display: true, text: 'Ngày' },
                    // Cài đặt để các cột cùng ngày đứng cạnh nhau
                    stacked: false, 
                },
                y: {
                    display: true,
                    title: { display: true, text: 'VNĐ' },
                    // Cài đặt để các cột cùng ngày đứng cạnh nhau
                    stacked: false, 
                    ticks: {
                        callback: function (value) {
                            // Định dạng tiền tệ VNĐ
                            return value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".") + ' VNĐ';
                        }
                    }
                }
            },
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function (context) {
                            let v = context.parsed.y || 0;
                            // Định dạng tooltip thành tiền tệ VNĐ
                            return context.dataset.label + ': ' + v.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".") + ' VNĐ';
                        }
                    }
                },
                legend: { position: 'top' }
            }
        }
    });
</script>
</main>

<?php include 'views/layouts/footer.php'; ?>