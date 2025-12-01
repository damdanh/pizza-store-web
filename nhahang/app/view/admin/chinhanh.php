<?php
$pageTitle = "Quản lý Chi Nhánh | Hệ thống Nhà hàng";
$activePage = "chinhanh";
include 'view/admin/layout/header.php';
include 'view/admin/layout/sidebar.php';
?>

<main class="main-content">
    <header class="page-header">
        <div class="page-title-group">
            <h1>Quản lý chi nhánh</h1>
            <p>Cập nhật thông tin và quản lý các chi nhánh</p>
        </div>
        
        <div class="action-button-single">
            <button class="action-btn">
                Thêm Chi Nhánh
            </button>
        </div>
    </header>

    <section class="card empty-state-content">
        <p>Chưa có chi nhánh nào. Nhấn "Thêm chi nhánh" để bắt đầu</p>
    </section>
</main>

<?php include 'view/admin/layout/footer.php'; ?>