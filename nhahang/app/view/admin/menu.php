<style>
    /* ================================== 0. Global Reset & Variables ================================== */
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        /* Sử dụng font hệ thống cho hiệu suất tốt */
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen, Ubuntu, Cantarell, "Open Sans", "Helvetica Neue", sans-serif;
    }

    :root {
        --sidebar-width: 280px;
        --main-bg: #f5f7f9; /* Màu nền nhẹ hơn */
        --white: #ffffff;
        --text-dark: #212529; /* Đen đậm hơn */
        --text-sub: #6c757d; /* Xám trung tính */
        --border-color: #e9ecef; /* Đường viền nhẹ */
        --primary-color: #007bff; /* Màu xanh dương chủ đạo */
        --nav-hover: #e9ecef; /* Nền hover nhẹ nhàng */
        --black-btn: #343a40; /* Nút hành động (đen) */
        --black-btn-hover: #1d2124;
    }

    body {
        background-color: var(--main-bg);
        color: var(--text-dark);
        line-height: 1.6;
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
        overflow-y: auto; /* Cho phép cuộn nếu nội dung sidebar dài */
    }

    .sidebar-header {
        display: flex;
        align-items: center;
        padding: 0 20px 20px;
        margin-bottom: 10px;
        border-bottom: 1px solid var(--border-color); /* Thêm đường phân cách */
    }

    .avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        margin-right: 10px;
        object-fit: cover;
        border: 2px solid var(--border-color); /* Thêm viền nhẹ */
    }

    .system-name {
        font-weight: 700;
        font-size: 18px;
        line-height: 1.2;
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
        transition: background-color 0.2s, color 0.2s;
    }

    .nav-item:hover {
        background-color: var(--nav-hover);
        color: var(--primary-color);
    }

    .nav-item.active {
        background-color: var(--nav-hover);
        font-weight: 600;
        color: var(--primary-color);
        border-right: 3px solid var(--primary-color);
    }

    .nav-item span.material-icons-outlined {
        margin-right: 15px;
        font-size: 20px;
        color: inherit; /* Kế thừa màu từ nav-item */
    }

    .sidebar-divider {
        border-top: 1px solid var(--border-color);
        margin: 15px 0;
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
        color: var(--text-dark);
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
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075); /* Box shadow rõ hơn */
    }

    /* Tiêu đề trang (Page Header) */
    .page-header {
        margin-bottom: 30px;
        display: flex;
        justify-content: space-between;
        align-items: center; /* Căn giữa theo chiều dọc */
    }

    .page-title-group {
        flex-grow: 1;
    }

    .page-title-group h1 {
        font-size: 30px;
        font-weight: 700;
        margin-bottom: 5px;
    }

    .page-title-group p {
        color: var(--text-sub);
        font-size: 15px;
    }

    /* Nhóm nút hành động */
    .action-buttons {
        display: flex;
        gap: 10px;
        flex-shrink: 0;
    }

    /* Kiểu cơ bản cho .action-btn (là button hoặc a) */
    .action-btn {
        padding: 10px 15px;
        background-color: var(--black-btn);
        color: var(--white);
        border: none;
        border-radius: 4px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        display: flex;
        align-items: center;
        text-decoration: none; 
        transition: background-color 0.2s;
    }

    .action-btn:hover {
        background-color: var(--black-btn-hover);
    }

    /* 📌 STYLE CHO THẺ <a> BÊN TRONG <BUTTON> (Theo cấu trúc gốc của bạn) */
    .action-btn > a.material-icons-outlined {
        /* Đảm bảo thẻ <a> bên trong nút được hiển thị đúng */
        display: flex; 
        align-items: center;
        justify-content: center;
        color: var(--white); /* Màu trắng cho biểu tượng */
        font-size: 20px;
        margin-right: 5px; 
        padding: 0;
        text-decoration: none;
    }
    
    /* 📌 STYLE CHO THẺ <a> BÊN TRONG <BUTTON> - Nếu bạn muốn cả chữ và icon nằm trong 1 thẻ <a> duy nhất */
    .action-buttons button a {
        display: flex;
        align-items: center;
        text-decoration: none;
        color: var(--white);
        /* Thiết lập lại margin cho biểu tượng bên trong thẻ a */
    }
    /* Sửa lỗi hiển thị biểu tượng khi nằm trong thẻ <a> */
    .action-buttons button a.material-icons-outlined {
        margin-right: 5px;
        font-size: 20px;
        /* Nếu thẻ <a> chỉ chứa icon, style này sẽ áp dụng */
    }

    /* --- Khu vực Danh sách và Bảng --- */

    .menu-list-section {
        padding: 20px;
    }

    .list-header {
        margin-bottom: 20px;
        border-bottom: 1px solid var(--border-color);
        padding-bottom: 15px;
    }
    
    .list-header h2 {
        font-size: 20px;
        font-weight: 600;
        margin-bottom: 5px;
    }

    .list-header p {
        font-size: 14px;
        color: var(--text-sub);
    }

    /* --- 3. Table Styling --- */
    .data-table {
        width: 100%;
        border-collapse: collapse; /* Gộp đường viền */
    }

    .data-table th, 
    .data-table td {
        padding: 12px 15px;
        text-align: left;
        border-bottom: 1px solid var(--border-color);
        font-size: 14px;
    }

    .data-table th {
        background-color: var(--nav-hover); /* Màu nền cho tiêu đề */
        font-weight: 600;
        color: var(--text-dark);
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .data-table tbody tr:hover {
        background-color: #fafafa; /* Highlight hàng khi hover */
    }

    /* Tùy chỉnh cột hành động */
    .action-cell {
        width: 100px; /* Giới hạn chiều rộng cho cột hành động */
        text-align: center;
    }
    
    .action-icon {
        color: var(--text-sub);
        margin: 0 5px;
        text-decoration: none;
        transition: color 0.2s;
        display: inline-flex; /* Quan trọng để căn giữa biểu tượng */
        align-items: center;
    }

    .action-icon:hover {
        color: var(--primary-color);
    }
    
    .action-icon .material-icons-outlined {
        font-size: 18px;
    }

</style>
<?php
$dish_count = count($dssp ?? []); 

$base_image_path = 'app/public/img/'; 
$dishes_list = $dssp ?? [];
?>
?>
<main class="main-content">
    <header class="page-header">
        <div class="page-title-group">
            <h1>Quản lý Menu</h1>
            <p>Thêm, sửa, ẩn món ăn và nhóm món</p>
        </div>
        
        <div class="action-buttons">
            <a href="admin.php?page=menu&action=add_category" class="action-btn">
                <span class="material-icons-outlined" style="margin-right: 5px;">category</span>
                Thêm nhóm món
            </a>
            <a href="admin.php?page=menu&action=add" class="action-btn">
                <span class="material-icons-outlined" style="margin-right: 5px;">add</span>
                Thêm món ăn
            </a>
        </div>
    </header>

    <section class="menu-list-section card">
        <div class="list-header">
            <h2>Danh sách món ăn</h2>
            <p>Tổng cộng **<?php echo $dish_count; ?>** món</p>
        </div>
        
        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th style="width: 5%;">ID</th>
                        <th style="width: 10%;">Ảnh</th>
                        <th style="width: 30%;">Tên Món</th>
                        <th style="width: 15%;">Nhóm Món</th>
                        <th style="width: 15%;">Giá</th>
                        <th style="width: 15%;">Trạng Thái</th>
                        <th class="action-cell">Hành Động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($dishes_list)): ?>
                        <?php foreach ($dishes_list as $dish): ?>
                        <tr>
                            <td><?php echo $dish['id_mon']; ?></td>
                            <!-- <td>
                                <img src="/nhahang/app/public/img/<?php echo htmlspecialchars($dish['hinh_anh']); ?>" 
                                     alt="<?php echo htmlspecialchars($dish['ten_mon']); ?>" 
                                     style="width: 50px; height: 50px; object-fit: cover; border-radius: 4px;">
                            </td> -->
                            <td><?php echo htmlspecialchars($dish['ten_mon']); ?></td>
                            <td><?php echo htmlspecialchars($dish['ten_danh_muc']); ?></td>
                            <td>
                                <strong><?php echo number_format($dish['gia'], 0, ',', '.'); ?> VNĐ</strong>
                            </td>
                            <td>
                                <?php 
                                    $status_class = ($dish['trang_thai'] == 'Còn hàng') ? 'text-success' : 'text-danger';
                                    $status_color = ($dish['trang_thai'] == 'Còn hàng') ? 'green' : 'red';
                                ?>
                                <span style="color: <?php echo $status_color; ?>; font-weight: 500;">
                                    <?php echo $dish['trang_thai']; ?>
                                </span>
                            </td>
                            <td class="action-cell">
                                <a href="admin.php?page=menu&action=edit&id=<?php echo $dish['id_mon']; ?>" class="action-icon" title="Sửa">
                                    <span class="material-icons-outlined">edit</span>
                                </a>
                                <a href="admin.php?page=menu&action=delete&id=<?php echo $dish['id_mon']; ?>" class="action-icon" title="Xóa"
                                   onclick="return confirm('Xác nhận xóa món ăn <?php echo htmlspecialchars($dish['ten_mon']); ?>?');" style="color: #dc3545;">
                                    <span class="material-icons-outlined">delete</span>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" style="text-align: center; color: var(--text-sub); padding: 20px;">
                                <span class="material-icons-outlined" style="font-size: 20px; display: block; margin-bottom: 5px;">info</span>
                                Hiện tại không có món ăn nào trong menu. Vui lòng thêm món mới.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </section>
</main>

<?php include 'views/layouts/footer.php'; ?>

