<?php
$pageTitle = "Quản lý Menu | Hệ thống Nhà hàng";
$activePage = "menu";
include 'view/admin/layout/header.php';
include 'view/admin/layout/sidebar.php';
?>

<main class="main-content">
    <header class="page-header">
        <div class="page-title-group">
            <h1>Quản lý Menu</h1>
            <p>Thêm, sửa, ẩn món ăn và nhóm món</p>
        </div>
        
        <di class="action-buttons">
            <button class="action-btn">
                <span class="material-icons-outlined">add</span>
                Thêm nhóm món
            </button>
            <button class="action-btn">
                <span class="material-icons-outlined">add</span>
                Thêm món ăn
            </button>
        </di
    </header>

    <section class="menu-list-section card">
        <div class="list-header">
            <h2>Danh sách món ăn</h2>
            <p>Tổng cộng 3 món</p>
        </div>
        
        <!-- Nội dung danh sách món ăn sẽ được thêm vào đây -->
    </section>
</main>

<?php include 'view/admin/layout/footer.php'; ?>