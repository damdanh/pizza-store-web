
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
            /* --text-sub: #777; */
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

        /* --- Multi-Step Indicator --- */
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

    /* --- 3. Form Styling (Thêm Món/Nhóm món) --- */

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
    <header class="page-header">
        <div class="page-title-group">
            <h1>Thêm Nhóm Món Mới</h1>
            <p>Thêm nhóm món (Category) để phân loại các món ăn.</p>
        </div>
        
        <div class="action-buttons">
            <a href="admin.php?page=menu" class="action-btn" style="background-color: var(--text-sub);">
                <span class="material-icons-outlined">arrow_back</span>
                Quay lại
            </a>
        </div>
    </header>

    <section class="add-category-form-section card">
    <form action="admin.php?page=menu" method="POST"> <div class="form-group">
            <label for="category_name" style="font-weight: 600; display: block; margin-bottom: 5px;">Tên Nhóm Món:</label>
            <input type="text" id="category_name" name="category_name" 
                   placeholder="Ví dụ: Món Khai Vị, Món Chính, Thức Uống" 
                   required 
                   style="width: 100%; padding: 10px; border: 1px solid var(--border-color); border-radius: 4px; font-size: 14px;">
        </div>

        <div class="form-group" style="margin-top: 20px;">
            <label for="category_description" style="font-weight: 600; display: block; margin-bottom: 5px;">Mô tả:</label>
            <textarea id="category_description" name="category_description" 
                      rows="4" 
                      placeholder="Mô tả ngắn gọn về nhóm món này (không bắt buộc)" 
                      style="width: 100%; padding: 10px; border: 1px solid var(--border-color); border-radius: 4px; font-size: 14px; resize: vertical;"></textarea>
        </div>

        <div class="form-group" style="margin-top: 30px; text-align: right;">
            <button type="submit" class="action-btn" name="save_category"> <span class="material-icons-outlined">save</span>
                Lưu Nhóm Món
            </button>
        </div>
    </form>
</section>
</main>