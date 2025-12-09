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
            --black-btn: #222; /* Màu nút hành động */
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
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
        }

        .page-title-group {
            flex-grow: 1;
        }

        .page-title-group h1 {
            font-size: 28px;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .page-title-group p {
            color: var(--text-sub);
            font-size: 16px;
        }

        /* Nút hành động đơn */
        .action-button-single {
            flex-shrink: 0;
        }
        
        .action-btn {
            padding: 10px 15px;
            background-color: var(--black-btn);
            color: var(--white);
            border: none;
            border-radius: 4px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            display: flex;
            align-items: center;
            transition: background-color 0.2s;
        }

        .action-btn:hover {
            background-color: var(--black-btn-hover);
        }

        /* Khu vực Nội dung chính (Trạng thái rỗng) */
        .empty-state-content {
            min-height: 250px; /* Chiều cao tối thiểu cho card */
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
        }
        
        .empty-state-content p {
            color: var(--text-sub);
            font-size: 16px;
        }
</style>
<?php
$pageTitle = "Quản lý Chi Nhánh | Hệ thống Nhà hàng";
$activePage = "chinhanh";
include 'views/layouts/header.php';
include 'views/layouts/sidebar.php';
?>

<main class="main-content">
    <header class="page-header">
        <div class="page-title-group">
            <h1>Quản lý chi nhánh</h1>
            <p>Cập nhật thông tin và quản lý các chi nhánh</p>
        </div>
        
            <div class="action-button-single">
                <button class="action-btn" onclick="document.getElementById('add-branch-form').scrollIntoView({behavior:'smooth'})">
                    Thêm Chi Nhánh
                </button>
            </div>
    </header>

        <?php if (!empty($_GET['msg'])): ?>
            <div class="card" style="margin-bottom:16px; border-left:4px solid #2ecc71; padding:12px;"><?= htmlspecialchars($_GET['msg']) ?></div>
        <?php endif; ?>

        <section class="card">
            <?php if (!empty($branches) && is_array($branches)): ?>
                <table style="width:100%; border-collapse:collapse;">
                    <thead>
                        <tr>
                            <th style="text-align:left;padding:8px;border-bottom:1px solid #eee">ID</th>
                            <th style="text-align:left;padding:8px;border-bottom:1px solid #eee">Tên chi nhánh</th>
                            <th style="text-align:left;padding:8px;border-bottom:1px solid #eee">Địa chỉ</th>
                            <th style="text-align:left;padding:8px;border-bottom:1px solid #eee">Giờ mở</th>
                            <th style="text-align:left;padding:8px;border-bottom:1px solid #eee">Giờ đóng</th>
                            <th style="text-align:right;padding:8px;border-bottom:1px solid #eee">Số bàn</th>
                            <th style="text-align:right;padding:8px;border-bottom:1px solid #eee">Sức chứa</th>
                            <th style="text-align:right;padding:8px;border-bottom:1px solid #eee">Bàn còn trống</th>
                            <th style="text-align:right;padding:8px;border-bottom:1px solid #eee">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($branches as $b): ?>
                                    <tr>
                                            <td style="padding:8px;border-bottom:1px solid #f5f5f5"><?= htmlspecialchars($b['id']) ?></td>
                                            <td style="padding:8px;border-bottom:1px solid #f5f5f5"><?= htmlspecialchars($b['ten_chi_nhanh']) ?></td>
                                            <td style="padding:8px;border-bottom:1px solid #f5f5f5"><?= htmlspecialchars($b['dia_chi']) ?></td>
                                            <td style="padding:8px;border-bottom:1px solid #f5f5f5"><?= htmlspecialchars($b['gio_mo_cua']) ?></td>
                                            <td style="padding:8px;border-bottom:1px solid #f5f5f5"><?= htmlspecialchars($b['gio_dong_cua']) ?></td>
                                            <td style="padding:8px;border-bottom:1px solid #f5f5f5;text-align:right"><?= htmlspecialchars($b['so_luong_ban']) ?></td>
                                            <td style="padding:8px;border-bottom:1px solid #f5f5f5;text-align:right"><?= htmlspecialchars($b['suc_chua']) ?></td>
                                            <td style="padding:8px;border-bottom:1px solid #f5f5f5;text-align:right"><?= htmlspecialchars($b['ban_con_trong']) ?></td>
                                            <td style="padding:8px;border-bottom:1px solid #f5f5f5;text-align:right">
                                                <a href="admin.php?page=chinhanh&action=edit&id=<?= $b['id'] ?>" class="action-link">Sửa</a>
                                                |
                                                <a href="admin.php?page=chinhanh&action=delete&id=<?= $b['id'] ?>" class="action-link" onclick="return confirm('Bạn có chắc chắn muốn xóa chi nhánh <?= htmlspecialchars($b['ten_chi_nhanh']) ?> không?')">Xóa</a>
                                            </td>
                                    </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <div class="empty-state-content">
                    <p>Chưa có chi nhánh nào. Nhấn "Thêm chi nhánh" để bắt đầu</p>
                </div>
            <?php endif; ?>
        </section>

        <section class="card" id="add-branch-form" style="margin-top:20px;">
            <h3><?= !empty($branch_edit) ? 'Cập nhật chi nhánh' : 'Thêm chi nhánh mới' ?></h3>
            <?php if (!empty($error)): ?>
                <div style="color:#b71c1c; margin-bottom:8px;"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>
            <form method="post" action="admin.php?page=chinhanh">
                <input type="hidden" name="save_branch" value="1">
                <?php if (!empty($branch_edit)): ?>
                    <input type="hidden" name="branch_id" value="<?= htmlspecialchars($branch_edit['id']) ?>">
                <?php endif; ?>
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">
                    <div>
                        <label>Tên chi nhánh</label>
                        <input type="text" name="ten_chi_nhanh" required style="width:100%;padding:8px;margin-top:6px;" value="<?= htmlspecialchars($branch_edit['ten_chi_nhanh'] ?? '') ?>">
                    </div>
                    <div>
                        <label>Địa chỉ</label>
                        <input type="text" name="dia_chi" required style="width:100%;padding:8px;margin-top:6px;" value="<?= htmlspecialchars($branch_edit['dia_chi'] ?? '') ?>">
                    </div>
                    <div>
                        <label>Giờ mở cửa</label>
                        <input type="time" name="gio_mo_cua" required style="width:100%;padding:8px;margin-top:6px;" value="<?= htmlspecialchars($branch_edit['gio_mo_cua'] ?? '') ?>">
                    </div>
                    <div>
                        <label>Giờ đóng cửa</label>
                        <input type="time" name="gio_dong_cua" required style="width:100%;padding:8px;margin-top:6px;" value="<?= htmlspecialchars($branch_edit['gio_dong_cua'] ?? '') ?>">
                    </div>
                    <div>
                        <label>Số lượng bàn</label>
                        <input type="number" name="so_luong_ban" min="0" value="<?= htmlspecialchars($branch_edit['so_luong_ban'] ?? 10) ?>" style="width:100%;padding:8px;margin-top:6px;">
                    </div>
                    <div>
                        <label>Sức chứa</label>
                        <input type="number" name="suc_chua" min="0" value="<?= htmlspecialchars($branch_edit['suc_chua'] ?? 50) ?>" style="width:100%;padding:8px;margin-top:6px;">
                    </div>
                    <div>
                        <label>Khung giờ (hiển thị)</label>
                        <input type="text" name="khung_gio" placeholder="08:00-22:00" style="width:100%;padding:8px;margin-top:6px;" value="<?= htmlspecialchars($branch_edit['khung_gio'] ?? '') ?>">
                    </div>
                    <div>
                        <label>Bàn còn trống</label>
                        <input type="number" name="ban_con_trong" min="0" value="<?= htmlspecialchars($branch_edit['ban_con_trong'] ?? 0) ?>" style="width:100%;padding:8px;margin-top:6px;">
                    </div>
                </div>
                <div style="margin-top:12px;">
                    <button type="submit" class="action-btn"><?= !empty($branch_edit) ? 'Cập nhật chi nhánh' : 'Lưu chi nhánh' ?></button>
                    <?php if (!empty($branch_edit)): ?>
                        <a href="admin.php?page=chinhanh" style="margin-left:8px;" class="action-link">Hủy</a>
                    <?php endif; ?>
                </div>
            </form>
        </section>
</main>

<?php include 'views/layouts/footer.php'; ?>