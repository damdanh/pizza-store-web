<?php
$pageTitle = "Quản lý đặt bàn & Pre-order | Hệ thống Nhà hàng";
$activePage = "quanlydatban";
include 'views/layouts/header.php';
include 'views/layouts/sidebar.php';
?>

<main class="main-content">
    <header class="page-header">
        <h1>Quản lý đặt bàn & Pre-order</h1>
        <p>Xem và xác nhận đơn đặt bàn</p>
    </header>

    <section class="filter-section card">
        <div class="filter-controls">
            <input type="text" class="filter-input" placeholder="Tìm kiếm">
            
            <input type="text" class="filter-input" placeholder="Trạng Thái">
            
            <input type="text" class="filter-input" placeholder="Chi Nhánh">

            <button class="refresh-btn">Làm mới</button>
        </div>
    </section>

    <section class="content-table-area card">
        <div class="empty-state">
            Không tìm thấy đơn đặt bàn nào
        </div>
    </section>
</main>

<?php include 'views/layouts/footer.php'; ?>
