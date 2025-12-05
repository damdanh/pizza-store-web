<style>
    /* --- 3. Form Styling (Thêm Món/Nhóm món) --- */
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
            --form-bg: #f5f5f5; /* Màu nền xám nhạt cho input/textarea */
            --step-active-color: #ff9800; /* Màu cam cho bước hoạt động */
            --step-inactive-color: #ccc; /* Màu xám cho bước chưa hoạt động */
            --button-primary-bg: #888; /* Màu xám cho nút chính (Tiếp tục) */
            --button-primary-hover: #777;
        }

        body {
            background-color: var(--main-bg);
            color: var(--text-dark);
        }

        .container {
            display: flex;
            min-height: 100vh;
        }

        /* --- 1. Sidebar Styling (Giữ nguyên) --- */
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
        
        /* ... Các CSS Header, Nav, Footer của Sidebar (giữ nguyên) ... */
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
        
        /* Đánh dấu mục Form khách hàng (Demo) */
        .demo-item.active {
             background-color: var(--nav-hover);
             font-weight: 600;
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
            padding: 30px; /* Padding lớn hơn cho form */
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            max-width: 800px; /* Giới hạn chiều rộng của form */
            margin: 0 auto;
        }

        /* Tiêu đề trang */
        .page-header {
            margin-bottom: 30px;
            text-align: center;
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

        .step-indicator {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 25px;
        }

        .step-number {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 14px;
            margin-left: 10px;
            color: var(--white);
            background-color: var(--step-inactive-color);
        }

        .step-number.active {
            background-color: var(--step-active-color);
        }

.form-group {
    margin-bottom: 20px;
}

.form-group label {
    font-weight: 600;
    display: block;
    margin-bottom: 8px;
    font-size: 14px;
    color: var(--text-dark);
}

.form-group input[type="text"],
.form-group input[type="number"],
.form-group input[type="file"],
.form-group select,
.form-group textarea {
    width: 100%;
    padding: 10px 12px;
    border: 1px solid var(--border-color);
    border-radius: 4px;
    font-size: 14px;
    color: var(--text-dark);
    background-color: var(--white);
    transition: border-color 0.2s, box-shadow 0.2s;
    box-sizing: border-box; /* Rất quan trọng */
}

.form-group input:focus,
.form-group select:focus,
.form-group textarea:focus {
    border-color: var(--primary-color);
    outline: none;
    box-shadow: 0 0 0 1px rgba(26, 115, 232, 0.3);
}

.form-group textarea {
    resize: vertical;
}

/* Kiểu dáng cho input file */
.form-group input[type="file"] {
    padding: 8px 10px; /* Nhỏ hơn một chút cho file */
    background-color: var(--nav-hover);
}

/* Căn chỉnh các trường nằm ngang */
.form-row {
    display: flex;
    gap: 20px;
    margin-bottom: 20px;
}

.form-row .form-group {
    flex: 1;
    margin-bottom: 0; /* Loại bỏ margin-bottom vì đã có margin ở .form-row */
}

/* Thông báo nhỏ (ví dụ: giới hạn kích thước file) */
.form-group small {
    color: var(--text-sub);
    font-size: 12px;
    margin-top: 5px;
    display: block;
}

/* Nhóm nút lưu/hành động trong form */
.form-actions {
    margin-top: 30px;
    padding-top: 15px;
    border-top: 1px solid var(--border-color);
    text-align: right;
}

.add-dish-form-section {
    max-width: 900px;
    margin: 30px auto;
    padding: 30px;
    background: #ffffff;
    border-radius: 8px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
}

.add-dish-form-section .form-group {
    margin-bottom: 15px;
}

.add-dish-form-section label {
    font-weight: 600;
    display: block;
    margin-bottom: 6px;
    color: #333;
}

.add-dish-form-section input[type="text"],
.add-dish-form-section input[type="number"],
.add-dish-form-section select,
.add-dish-form-section textarea {
    width: 100%;
    padding: 12px;
    border: 1px solid #ddd;
    border-radius: 6px;
    font-size: 16px;
    box-sizing: border-box;
    transition: border-color 0.3s;
}

.add-dish-form-section input:focus,
.add-dish-form-section select:focus,
.add-dish-form-section textarea:focus {
    border-color: #007bff;
    outline: none;
}

.add-dish-form-section textarea {
    resize: vertical;
}

/* Styling cho trường file (Hình Ảnh) */
.add-dish-form-section input[type="file"] {
    padding: 10px 0; /* Giảm padding trên dưới cho input file */
    border: none;
}

/* Styling cho phần mô tả ảnh cũ */
.add-dish-form-section small {
    display: block;
    margin-top: 5px;
    font-size: 13px;
    color: #6c757d;
}

/* Bố cục 2 cột */
.add-dish-form-section > form > div:first-child,
.add-dish-form-section > form > div:nth-child(2) {
    display: flex;
    gap: 20px;
    margin-bottom: 20px;
}

.add-dish-form-section > form > div > div {
    flex: 1; /* Chia đều các cột */
}

/* Nút Lưu */
.add-dish-form-section .action-btn {
    background-color: #007bff; /* Màu xanh dương cho hành động lưu món ăn */
}

.add-dish-form-section .action-btn:hover {
    background-color: #0056b3;
}

.action-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 10px 20px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 14px;
    font-weight: 500;
    transition: background-color 0.2s, box-shadow 0.2s, opacity 0.2s;
    text-decoration: none; /* Quan trọng nếu dùng cho thẻ <a> */
    white-space: nowrap; /* Ngăn nút bị ngắt dòng */
}

/* Nút Chính (Primary - Dùng cho Save, Submit) */
.action-btn.primary {
    background-color: var(--primary-color);
    color: var(--white);
}

.action-btn.primary:hover {
    background-color: #1660c4; /* Tối hơn Primary Color */
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

/* Nút Thứ Cấp (Secondary - Dùng cho Cancel, Go Back/Quay Lại) */
.action-btn.secondary {
    background-color: var(--white);
    color: var(--text-dark);
    border: 1px solid var(--border-color);
}

.action-btn.secondary:hover {
    background-color: var(--nav-hover);
    border-color: #ccc;
}

/* Định nghĩa lại Nút Lưu Món Ăn (để nó dùng Primary Color) */
.add-dish-form-section .action-btn[name="save_product"] {
    background-color: var(--primary-color); 
    color: var(--white);
}

.add-dish-form-section .action-btn[name="save_product"]:hover {
    background-color: #1660c4;
}

/* Căn chỉnh các nút trong khu vực form-actions */
.form-actions button,
.form-actions a {
    margin-left: 10px; /* Tạo khoảng cách giữa các nút */
}
</style>
<main class="main-content">
    <section class="add-dish-form-section card">
        <form action="admin.php?page=menu" method="POST" enctype="multipart/form-data">
            
            <?php if (isset($sp_edit)): ?>
                <input type="hidden" name="product_id" value="<?php echo $sp_edit['id_mon']; ?>">
                <input type="hidden" name="old_img" value="<?php echo $sp_edit['hinh_anh']; ?>">
            <?php endif; ?>

            <div style="display: flex; gap: 20px; margin-bottom: 20px;">
                <div class="form-group" style="flex: 2;">
                    <label for="ten_mon">Tên Món Ăn:</label>
                    <input type="text" id="ten_mon" name="ten_mon" 
                           placeholder="Ví dụ: Bò Bít Tết Sốt Tiêu Đen" 
                           required 
                           value="<?php echo $sp_edit['ten_mon'] ?? ''; ?>">
                </div>
                <div class="form-group" style="flex: 1;">
                    <label for="gia">Giá (VNĐ):</label>
                    <input type="number" id="gia" name="gia" 
                           placeholder="Ví dụ: 150000" 
                           required 
                           min="0"
                           value="<?php echo $sp_edit['gia'] ?? ''; ?>">
                </div>
            </div>

            <div style="display: flex; gap: 20px; margin-bottom: 20px;">
                <div class="form-group" style="flex: 1;">
                    <label for="category">Nhóm Món:</label>
                    <select id="category" name="category" required>
                        <option value="">-- Chọn Nhóm Món --</option>
                        <?php if (isset($dsdm) && is_array($dsdm)): ?>
                            <?php foreach ($dsdm as $dm): ?>
                                <option value="<?php echo $dm['id_danh_muc_mon']; ?>"
                                    <?php echo (isset($sp_edit) && $sp_edit['id_danh_muc_mon'] == $dm['id_danh_muc_mon']) ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($dm['ten_danh_muc']); ?>
                                </option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>
                <div class="form-group" style="flex: 1;">
                    <label for="trang_thai">Trạng Thái:</label>
                    <select id="trang_thai" name="trang_thai">
                        <?php 
                            $status = $sp_edit['trang_thai'] ?? 'Còn hàng'; // Mặc định là 'Còn hàng'
                        ?>
                        <option value="Còn hàng" <?php echo ($status == 'Còn hàng') ? 'selected' : ''; ?>>Đang bán</option>
                        <option value="Hết hàng" <?php echo ($status == 'Hết hàng') ? 'selected' : ''; ?>>Ngừng bán</option>
                    </select>
                </div>
            </div>

            <div class="form-group" style="margin-bottom: 20px;">
                <label for="mo_ta">Mô tả chi tiết:</label>
                <textarea id="mo_ta" name="mo_ta" rows="5" placeholder="Mô tả các thành phần và hương vị của món ăn" required><?php echo $sp_edit['mo_ta'] ?? ''; ?></textarea>
            </div>

            <div class="form-group" style="margin-bottom: 30px;">
                <label for="img">Hình Ảnh Món Ăn:</label>
                <input type="file" id="img" name="img" accept="image/*">
                <?php if (isset($sp_edit) && $sp_edit['hinh_anh']): ?>
                    <small>Ảnh cũ: <a href="/nhahang/app/public/img/<?php echo $sp_edit['hinh_anh']; ?>" target="_blank"><?php echo $sp_edit['hinh_anh']; ?></a> (Chỉ chọn ảnh mới nếu muốn thay đổi)</small>
                <?php endif; ?>
            </div>

            <div class="form-group" style="text-align: right;">
                <button type="submit" class="action-btn" name="save_product"> <span class="material-icons-outlined">fastfood</span>
                    Lưu Món Ăn
                </button>
            </div>
        </form>
    </section>
</main>