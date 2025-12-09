<style>
/* ... (GIỮ NGUYÊN CSS) ... */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        /* Biến CSS (CSS Variables) để dễ quản lý màu sắc, kích thước */
        :root {
            --sidebar-width: 280px;
            --main-bg: #f9f9f9; /* Màu nền chính của nội dung */
            --white: #ffffff;
            --text-dark: #333; /* Màu chữ chính */
            --text-sub: #777; /* Màu chữ phụ, mô tả */
            --border-color: #eee;
            --primary-color: #1a73e8; /* Màu xanh nhấn chính */
            --nav-hover: #f0f0f0; /* Màu nền khi hover hoặc active trên nav item */
        }

        body {
            background-color: var(--main-bg);
            color: var(--text-dark);
        }

        /* Container tổng thể, dùng flexbox để chia 2 cột */
        .container {
            display: flex;
            min-height: 100vh; /* Đảm bảo chiều cao tối thiểu bằng màn hình */
        }

        /* --- 1. Sidebar Styling (Thanh điều hướng bên trái) --- */
        .sidebar {
            width: var(--sidebar-width);
            background-color: var(--white);
            border-right: 1px solid var(--border-color);
            padding: 20px 0; /* Padding trên dưới, không có padding ngang (vì nav-item có rồi) */
            display: flex;
            flex-direction: column; /* Các phần tử con xếp dọc */
            position: fixed; /* Giữ sidebar cố định khi cuộn */
            top: 0;
            left: 0;
            bottom: 0;
            z-index: 100; /* Đảm bảo sidebar luôn ở trên cùng */
        }

        /* Phần header của sidebar (avatar và tên hệ thống) */
        .sidebar-header {
            display: flex;
            align-items: center;
            padding: 0 20px 20px; /* Padding ngang 20px, dưới 20px */
            margin-bottom: 10px;
        }

        .avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-right: 10px;
            object-fit: cover; /* Đảm bảo ảnh avatar hiển thị đẹp */
        }

        .system-name {
            font-weight: 600;
            font-size: 16px;
        }

        .sub-text {
            color: var(--text-sub);
            font-size: 12px;
        }

        /* Phần điều hướng chính của sidebar */
        .sidebar-nav {
            flex-grow: 1; /* Cho phép nav chiếm hết không gian còn lại giữa header và footer */
        }

        .nav-item {
            display: flex;
            align-items: center;
            padding: 12px 20px; /* Padding cho mỗi mục điều hướng */
            text-decoration: none; /* Bỏ gạch chân link */
            color: var(--text-dark);
            font-size: 14px;
            transition: background-color 0.2s; /* Hiệu ứng chuyển động mượt mà khi hover */
        }

        .nav-item:hover {
            background-color: var(--nav-hover);
        }

        /* Trạng thái active (mục đang được chọn) */
        .nav-item.active {
            background-color: var(--nav-hover);
            font-weight: 600;
            border-right: 3px solid var(--primary-color); /* Đường kẻ xanh ở bên phải */
        }

        .nav-item span.material-icons-outlined {
            margin-right: 15px; /* Khoảng cách giữa icon và chữ */
            font-size: 20px;
            color: #444; /* Màu icon */
        }

        /* Đường phân cách */
        .sidebar-divider {
            border-top: 1px solid var(--border-color);
            margin: 10px 0;
        }

        /* Mục demo */
        .sidebar-demo {
            padding-bottom: 10px;
        }

        /* Phần footer của sidebar (thông tin đăng nhập và nút đăng xuất) */
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

        /* --- 2. Main Content Styling (Nội dung chính của trang) --- */
        .main-content {
            margin-left: var(--sidebar-width); /* Đẩy nội dung sang phải bằng chiều rộng sidebar */
            padding: 30px; /* Padding xung quanh nội dung */
            flex-grow: 1; /* Cho phép nội dung chiếm hết không gian còn lại */
        }

        /* Kiểu chung cho các card (khối nội dung có nền trắng, bo góc, đổ bóng) */
        .card {
            background-color: var(--white);
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05); /* Shadow nhẹ nhàng */
        }

        /* Tiêu đề của trang (ví dụ: Quản lý đặt bàn & Pre-order) */
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

        /* Form styling */
        .form-title {
            font-size: 20px;
            font-weight: 600;
            margin-bottom: 20px;
            border-bottom: 1px solid var(--border-color);
            padding-bottom: 10px;
        }

        .form-row {
            display: flex;
            gap: 20px;
            margin-bottom: 15px;
        }

        .form-group {
            flex: 1;
        }

        .form-group-label {
            display: block;
            margin-bottom: 5px;
            font-size: 14px;
            font-weight: 500;
        }

        .form-group-label span {
            color: red;
        }

        .form-input, .form-select, .form-textarea {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid var(--border-color);
            border-radius: 4px;
            font-size: 14px;
            transition: border-color 0.2s;
        }

        .form-input:focus, .form-select:focus, .form-textarea:focus {
            border-color: var(--primary-color);
            outline: none;
        }

        .form-textarea {
            resize: vertical;
            min-height: 100px;
        }

        .form-actions {
            margin-top: 30px;
            text-align: right;
        }

        .btn-continue {
            padding: 12px 25px;
            background-color: var(--primary-color);
            color: var(--white);
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 15px;
            font-weight: 600;
            transition: background-color 0.2s;
        }

        .btn-continue:hover {
            background-color: #165ab7; /* Màu tối hơn */
        }

</style>
<?php
$pageTitle = "Đặt bàn trực tuyến | Hệ thống Nhà hàng";
$activePage = "formDemo"; // Đảm bảo đúng active page
include 'views/layouts/header.php';
include 'views/layouts/sidebar.php';

// Lấy dữ liệu đã gửi nếu có lỗi (đã được Controller truyền vào)
$prev_data = $prev_data ?? []; 
?>

<main class="main-content">
    <header class="page-header">
        <h1>Đặt bàn trực tuyến</h1>
        <p>Đặt bàn nhanh chóng và trực tuyến</p>
        <?php if (isset($error)): ?>
            <p style="color: red; font-weight: bold; margin-top: 10px;"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>
    </header>
    
    <section class="card">
        <form action="admin.php?page=formDemo" method="POST"> 
            <div class="form-title">Thông tin đặt bàn</div>
            
            <div class="form-row">
                <div class="form-group">
                    <label class="form-group-label" for="ten">Họ và tên <span>*</span></label>
                    <input type="text" id="ten" name="ten" class="form-input" required 
                       value="<?php echo htmlspecialchars($prev_data['ten'] ?? 'Nguyễn Văn A'); ?>">
                </div>
                <div class="form-group">
                    <label class="form-group-label" for="sdt">Số điện thoại <span>*</span></label>
                    <input type="tel" id="sdt" name="sdt" class="form-input" required 
                       value="<?php echo htmlspecialchars($prev_data['sdt'] ?? '0123456789'); ?>">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-group-label" for="email">Email <span>*</span></label> 
                    <input type="email" id="email" name="email" class="form-input" required 
                       value="<?php echo htmlspecialchars($prev_data['email'] ?? 'email@example.com'); ?>">
                </div>
                <div class="form-group">
                    <label class="form-group-label" for="chinhanh">Chi nhánh <span>*</span></label>
                    <select id="chinhanh" name="chinhanh" class="form-select" required>
                        <option disabled selected value="">Chọn chi nhánh</option>
                        <?php 
                           $selectedBranchId = $prev_data['chinhanh'] ?? null; 
                           if (!empty($ds_chinhanh) && is_array($ds_chinhanh)): 
                        ?>
                            <?php foreach ($ds_chinhanh as $cn): ?>
                                <option 
                                     value="<?php echo htmlspecialchars($cn['id']); ?>"
                                     <?php if ((int)$cn['id'] === (int)$selectedBranchId) echo 'selected'; ?>
                                >
                                    <?php echo htmlspecialchars($cn['ten_chi_nhanh']); ?>
                                </option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label class="form-group-label" for="ngay">Ngày <span>*</span></label>
                    <input type="text" id="ngay" name="ngay" class="form-input" required placeholder="dd/mm/yy"
                       value="<?php echo htmlspecialchars($prev_data['ngay'] ?? ''); ?>">
                </div>
                <div class="form-group">
                    <label class="form-group-label" for="gio">Giờ <span>*</span></label>
                    <input type="text" id="gio" name="gio" class="form-input" required placeholder="--:-- --"
                       value="<?php echo htmlspecialchars($prev_data['gio'] ?? ''); ?>">
                </div>
                <div class="form-group">
                    <label class="form-group-label" for="songuoi">Số người <span>*</span></label>
                    <input type="number" id="songuoi" name="songuoi" class="form-input" required min="1" 
                       value="<?php echo htmlspecialchars($prev_data['songuoi'] ?? '2'); ?>">
                </div>
            </div>
            
            <div class="form-group">
                <label class="form-group-label" for="ghichu">Ghi chú</label>
                <textarea id="ghichu" name="ghichu" class="form-textarea" placeholder="Yêu cầu đặc biệt...."><?php echo htmlspecialchars($prev_data['ghichu'] ?? ''); ?></textarea>
            </div>

            <div class="form-actions">
                <button type="submit" name="submit_booking" class="btn-continue"> 
                    Đặt bàn
                </button>
            </div>
        </form>
    </section>
</main>

<?php include 'views/layouts/footer.php'; ?>