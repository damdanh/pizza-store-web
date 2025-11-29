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
                <div class="stat-value">150,000,000 VNĐ</div>
                <div class="stat-label">Lợi nhuận ròng</div>
            </div>
            <span class="material-icons-outlined" style="color: #4285F4;">trending_up</span>
        </div>
        
        <div class="card stat-card">
            <div>
                <div class="stat-value">5,000</div>
                <div class="stat-label">Tổng đơn hàng</div>
            </div>
            <span class="material-icons-outlined" style="color: #EA4335;">shopping_cart</span>
        </div>
    </section>
    
    <section class="card chart-area">
        <p>[Biểu đồ Doanh thu theo thời gian sẽ được hiển thị tại đây]</p>
    </section>
</main>

<?php include 'views/layouts/footer.php'; ?>
