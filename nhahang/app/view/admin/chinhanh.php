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
            <button class="action-btn">
                Thêm Chi Nhánh
            </button>
        </div>
    </header>

    <section class="card empty-state-content">
        <p>Chưa có chi nhánh nào. Nhấn "Thêm chi nhánh" để bắt đầu</p>
    </section>
</main>

<?php include 'views/layouts/footer.php'; ?>