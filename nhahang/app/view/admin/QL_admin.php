

<style>
        /* --- DÁN TOÀN BỘ MÃ CSS CHUNG BẠN ĐÃ CÓ VÀO ĐÂY --- */

        /* Reset cơ bản */
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
            margin: 5px;
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

        /* --- Bảng Dữ liệu --- */
        .admin-list-section {
            padding-top: 0;
            /* Bỏ padding top vì đã có title riêng */
        }

        .list-header {
            margin-bottom: 15px;
        }

        .list-header h2 {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .list-header p {
            font-size: 14px;
            color: var(--text-sub);
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
            /* Bỏ khoảng cách giữa các ô */
            font-size: 14px;
        }

        .data-table th {
            text-align: left;
            padding: 15px 0;
            border-bottom: 1px solid var(--border-color);
            font-weight: 600;
            color: var(--text-dark);
        }

        .data-table td {
            padding: 15px 0;
            border-bottom: 1px solid var(--border-color);
            color: var(--text-dark);
        }

        .data-table tr:last-child td {
            border-bottom: none;
            /* Bỏ border dưới cho hàng cuối */
        }

        .action-link {
            color: var(--primary-color);
            text-decoration: none;
            cursor: pointer;
        }

        /* Điều chỉnh cột Email và Thao tác */
        .data-table td:nth-child(2) {
            /* Cột Email */
            width: 30%;
        }

        .data-table td:last-child {
            /* Cột Thao tác */
            width: 10%;
        }
    
</style>

<main class="main-content">
    <header class="page-header">
        <div class="page-title-group">
            <h1>Quản lý tài khoản Admin</h1>
            <p>Thêm, sửa, ẩn các tài khoản quản trị</p>
        </div>

        <div class="action-button-single">
            <a href="admin.php?page=admin&action=add" class="action-btn">
                Thêm Admin
            </a>
        </div>
    </header>

    <?php if (!empty($message)): ?>
    <div style="padding: 10px; background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; border-radius: 4px; margin-bottom: 20px;">
        <?= htmlspecialchars($message) ?>
    </div>
    <?php endif; ?>

    <section class="card admin-list-section">
        <div class="list-header">
            <h2>Danh sách Admin</h2>
            <p>Tổng cộng <?= count($ds_admin ?? []) ?> tài khoản</p>
        </div>

        <table class="data-table">
            <thead>
                <tr>
                    <th>Tên</th>
                    <th>Email</th>
                    <th>Vai trò</th>
                    <th>Ngày tạo</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($ds_admin)): ?>
                <?php foreach ($ds_admin as $admin): ?>
                <tr>
                    <td><?= htmlspecialchars($admin['ten']) ?></td>
                    <td><a href="mailto:<?= htmlspecialchars($admin['email']) ?>"><?= htmlspecialchars($admin['email']) ?></a></td>
                    <td><?= htmlspecialchars($admin['vai_tro']) ?></td>
                    <td><?= htmlspecialchars(date('d/m/Y', strtotime($admin['ngay_tao'] ?? ''))) ?></td> 
                    <td>
                        <a href="admin.php?page=admin&action=edit&id=<?= $admin['id_admin'] ?>" class="action-link">Sửa</a>
                        |
                        <a href="admin.php?page=admin&action=delete&id=<?= $admin['id_admin'] ?>" 
                           class="action-link"
                           onclick="return confirm('Bạn có chắc chắn muốn xóa tài khoản <?= htmlspecialchars($admin['ten']) ?> không?')">
                           Xóa
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php else: ?>
                <tr>
                    <td colspan="5">Không có tài khoản Admin nào.</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </section>
</main>