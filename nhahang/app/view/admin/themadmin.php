<style>
        /* Biến CSS (CSS Variables) để dễ quản lý màu sắc, kích thước */
        :root {
            --sidebar-width: 280px;
            --main-bg: #f5f7fa; /* Màu nền chính của nội dung (Hơi xám hơn) */
            --white: #ffffff;
            --text-dark: #333; /* Màu chữ chính */
            --text-sub: #777; /* Màu chữ phụ, mô tả */
            --border-color: #e0e0e0;
            --primary-color: #1a73e8; /* Màu xanh nhấn chính */
            --primary-hover: #1562c5;
            --nav-hover: #eaf1fb; /* Màu nền khi hover hoặc active trên nav item */
            --success-color: #34a853;
            --danger-color: #dc3545; /* Thêm màu đỏ cho thông báo lỗi */
            --danger-bg: #f8d7da;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
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
            border-bottom: 1px solid var(--border-color);
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
            transition: background-color 0.2s, border-right 0.2s;
        }

        .nav-item:hover {
            background-color: var(--nav-hover);
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
            color: #444;
        }

        .nav-item.active span.material-icons-outlined {
            color: var(--primary-color);
        }

        /* Đường phân cách */
        .sidebar-divider {
            border-top: 1px solid var(--border-color);
            margin: 10px 20px;
        }

        /* Phần footer của sidebar */
        .sidebar-footer {
            padding: 10px 20px 0;
            border-top: 1px solid var(--border-color);
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
            margin-left: var(--sidebar-width);
            padding: 30px;
            flex-grow: 1;
        }

        /* Kiểu chung cho các card */
        .card {
            background-color: var(--white);
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            border: 1px solid var(--border-color);
        }
        
        /* Alert Message (Thông báo) */
        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border: 1px solid transparent;
            border-radius: 8px;
            font-weight: 500;
        }
        .alert.error {
            color: var(--danger-color);
            background-color: var(--danger-bg);
            border-color: #f5c6cb;
        }


        /* Tiêu đề của trang */
        .page-header {
            margin-bottom: 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .page-header h1 {
            font-size: 28px;
            font-weight: 700;
            color: #2c3e50;
        }

        .page-header p {
            color: var(--text-sub);
            font-size: 16px;
        }

        .back-btn {
            background: none;
            border: none;
            color: var(--text-sub);
            font-size: 14px;
            cursor: pointer;
            display: flex;
            align-items: center;
            padding: 8px 15px;
            border-radius: 4px;
            text-decoration: none; /* đảm bảo nó trông như nút nhưng vẫn là link */
            transition: color 0.2s, background-color 0.2s;
        }

        .back-btn:hover {
            color: var(--primary-color);
            background-color: var(--nav-hover);
        }

        .back-btn span {
            margin-right: 5px;
            font-size: 18px;
        }

        /* --- Form Styling --- */
        .form-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 20px;
        }

        .form-group {
            margin-bottom: 5px;
        }

        .form-group.col-2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 8px;
            color: var(--text-dark);
        }

        .form-input, .form-select {
            width: 100%;
            padding: 12px;
            border: 1px solid var(--border-color);
            border-radius: 6px;
            font-size: 14px;
            color: var(--text-dark);
            background-color: #fcfcfc;
            transition: border-color 0.2s, box-shadow 0.2s;
            box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.03);
        }

        .form-input:focus, .form-select:focus {
            border-color: var(--primary-color);
            outline: none;
            box-shadow: 0 0 0 3px rgba(26, 115, 232, 0.1);
        }

        /* Checkbox/Switch */
        .form-switch {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px 0;
            border-top: 1px solid var(--border-color);
            margin-top: 15px;
        }
        
        .switch {
          position: relative;
          display: inline-block;
          width: 45px;
          height: 24px;
        }

        .switch input { 
          opacity: 0;
          width: 0;
          height: 0;
        }

        .slider {
          position: absolute;
          cursor: pointer;
          top: 0;
          left: 0;
          right: 0;
          bottom: 0;
          background-color: #ccc;
          transition: .4s;
          border-radius: 24px;
        }

        .slider:before {
          position: absolute;
          content: "";
          height: 16px;
          width: 16px;
          left: 4px;
          bottom: 4px;
          background-color: white;
          transition: .4s;
        }

        input:checked + .slider {
          background-color: var(--success-color);
        }

        input:focus + .slider {
          box-shadow: 0 0 1px var(--success-color);
        }

        input:checked + .slider:before {
          transform: translateX(21px);
        }

        /* Round sliders */
        .slider.round {
          border-radius: 24px;
        }

        .slider.round:before {
          border-radius: 50%;
        }

        /* --- Footer và Actions --- */
        .form-actions {
            display: flex;
            justify-content: flex-end; /* Đẩy nút sang phải */
            gap: 15px;
            padding-top: 20px;
            border-top: 1px solid var(--border-color);
            margin-top: 20px;
        }

        .action-btn {
            padding: 10px 20px;
            font-size: 15px;
            border-radius: 6px;
            cursor: pointer;
            transition: background-color 0.2s, box-shadow 0.2s;
            font-weight: 500;
            border: none;
        }

        .btn-cancel {
            background-color: #f0f0f0;
            color: var(--text-dark);
            border: 1px solid #ccc;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .btn-cancel:hover {
            background-color: #e0e0e0;
        }

        .btn-primary {
            background-color: var(--primary-color);
            color: var(--white);
            box-shadow: 0 2px 4px rgba(26, 115, 232, 0.3);
        }

        .btn-primary:hover {
            background-color: var(--primary-hover);
        }

        /* --- Responsive Design (Thiết kế đáp ứng) --- */
        @media (max-width: 992px) {
            .sidebar {
                width: 70px; /* Thu gọn sidebar */
            }
            .sidebar-header, .sidebar-footer {
                padding: 0 15px 20px;
            }
            .system-name, .sub-text, .logout-btn span:not(.material-icons-outlined) {
                display: none; /* Ẩn chữ */
            }
            .nav-item {
                justify-content: center;
                padding: 15px 0;
            }
            .nav-item span.material-icons-outlined {
                margin-right: 0;
            }
            .main-content {
                margin-left: 70px; /* Đẩy nội dung sang phải 70px */
                padding: 20px;
            }
            .form-group.col-2 {
                grid-template-columns: 1fr; /* Stack các cột lại */
            }
        }

        @media (max-width: 600px) {
            .sidebar {
                display: none; /* Ẩn sidebar trên mobile để ưu tiên nội dung */
            }
            .main-content {
                margin-left: 0;
                padding: 15px;
            }
        }
    </style>
<main class="main-content">
    <header class="page-header">
        <div class="page-title-group">
            <h1><?= isset($admin_edit) ? 'Cập nhật tài khoản Admin' : 'Thêm tài khoản Admin mới' ?></h1>
            <p>Điền thông tin chi tiết của tài khoản quản trị</p>
        </div>
    </header>

    <?php 
    // Hiển thị thông báo lỗi (error) hoặc thành công (msg)
    if (!empty($message)): 
        $is_error = strpos($message, 'Lỗi') !== false || isset($_GET['error']);
    ?>
    <div style="padding: 10px; background-color: <?= $is_error ? '#f8d7da' : '#d4edda' ?>; color: <?= $is_error ? '#721c24' : '#155724' ?>; border: 1px solid <?= $is_error ? '#f5c6cb' : '#c3e6cb' ?>; border-radius: 4px; margin-bottom: 20px;">
        <?= htmlspecialchars($message) ?>
    </div>
    <?php endif; ?>

    <section class="card">
        <form action="admin.php?page=admin&action=<?= isset($admin_edit) ? 'update_process' : 'add_process' ?>" method="POST">
            
            <?php if (isset($admin_edit)): ?>
                <input type="hidden" name="id_admin" value="<?= htmlspecialchars($admin_edit['id_admin']) ?>">
            <?php endif; ?>

            <div style="margin-bottom: 15px;">
                <label for="ten" style="display: block; margin-bottom: 5px; font-weight: 500;">Tên Admin (*)</label>
                <input type="text" id="ten" name="ten" 
                       value="<?= htmlspecialchars($admin_edit['ten'] ?? $old_data['ten'] ?? '') ?>" 
                       style="width: 100%; padding: 10px; border: 1px solid var(--border-color); border-radius: 4px;" 
                       required>
            </div>

            <div style="margin-bottom: 15px;">
                <label for="email" style="display: block; margin-bottom: 5px; font-weight: 500;">Email (*)</label>
                <input type="email" id="email" name="email" 
                       value="<?= htmlspecialchars($admin_edit['email'] ?? $old_data['email'] ?? '') ?>" 
                       style="width: 100%; padding: 10px; border: 1px solid var(--border-color); border-radius: 4px;" 
                       required>
            </div>

            <div style="margin-bottom: 15px;">
                <label for="vai_tro" style="display: block; margin-bottom: 5px; font-weight: 500;">Vai trò (*)</label>
                <select id="vai_tro" name="vai_tro" 
                        style="width: 100%; padding: 10px; border: 1px solid var(--border-color); border-radius: 4px;" 
                        required>
                    <?php $current_role = $admin_edit['vai_tro'] ?? $old_data['vai_tro'] ?? ''; ?>
                    <option value="">-- Chọn vai trò --</option>
                    <option value="1" <?= $current_role == '1' ? 'selected' : '' ?>>1</option>                </select>
            </div>

            <div style="margin-bottom: 15px;">
                <label for="mat_khau" style="display: block; margin-bottom: 5px; font-weight: 500;">Mật khẩu <?= isset($admin_edit) ? '(Để trống nếu không đổi)' : '(*)' ?></label>
                <input type="password" id="mat_khau" name="mat_khau" 
                       style="width: 100%; padding: 10px; border: 1px solid var(--border-color); border-radius: 4px;" 
                       <?= !isset($admin_edit) ? 'required' : '' ?>>
            </div>

            <div style="margin-bottom: 20px;">
                <label for="confirm_mat_khau" style="display: block; margin-bottom: 5px; font-weight: 500;">Xác nhận Mật khẩu <?= isset($admin_edit) ? '(Để trống nếu không đổi)' : '(*)' ?></label>
                <input type="password" id="confirm_mat_khau" name="confirm_mat_khau" 
                       style="width: 100%; padding: 10px; border: 1px solid var(--border-color); border-radius: 4px;" 
                       <?= !isset($admin_edit) ? 'required' : '' ?>>
            </div>
            
            <div style="margin-bottom: 20px; display: flex; align-items: center;">
                <?php $current_status = $admin_edit['trang_thai_hoat_dong'] ?? $old_data['trang_thai_hoat_dong'] ?? 1; ?>
                <input type="hidden" name="trang_thai_hoat_dong" value="0">
                <input type="checkbox" id="trang_thai_hoat_dong" name="trang_thai_hoat_dong" value="1" 
                       <?= $current_status == 1 ? 'checked' : '' ?> 
                       style="margin-right: 10px; width: auto;">
                <label for="trang_thai_hoat_dong" style="font-weight: 500;">Kích hoạt tài khoản</label>
            </div>


            <button type="submit" class="action-btn" style="background-color: var(--primary-color); padding: 12px 20px;">
                <?= isset($admin_edit) ? 'Cập Nhật Admin' : 'Thêm Admin' ?>
            </button>
            <a href="admin.php?page=admin" class="action-btn" style="background-color: #777; margin-left: 10px;">Hủy</a>
        </form>
    </section>
</main>