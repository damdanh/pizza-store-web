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
        

.config-card-title {
    display: flex;
    align-items: center;
    font-size: 16px;
    font-weight: 600;
    margin-bottom: 5px; /* Giảm margin bottom vì subtext nằm ngay dưới */
}

/* Các trường Form */
.form-group {
    margin-bottom: 15px;
}

.form-group-label {
    font-size: 14px;
    font-weight: 500;
    color: var(--text-dark);
    margin-bottom: 5px;
    display: block;
}

.form-input-text {
    width: 100%;
    padding: 10px 12px;
    border: 1px solid var(--border-color);
    border-radius: 4px;
    font-size: 14px;
    color: var(--text-dark);
    background-color: #f7f7f7; /* Màu nền input */
    transition: border-color 0.2s;
}

.form-input-text:focus {
    border-color: var(--primary-color);
    outline: none;
    box-shadow: 0 0 0 2px rgba(26, 115, 232, 0.2);
}

/* --- Alert Box Styling --- */

.alert-box a {
    text-decoration: none;
    font-weight: 500;
}
</style>
<?php
include 'views/layouts/header.php';
include 'views/layouts/sidebar.php';
?>
<main class="main-content">
    <header class="page-header">
        <h1>Cấu hình hệ thống</h1>
        <p>Cấu hình các thông số toàn cục của nhà hàng</p>
    </header>

    <section class="card">
        <div class="config-card-title">
            <span class="material-icons-outlined">settings</span>
            Thông tin doanh nghiệp
        </div>
        <p class="config-card-title p">Cấu hình thông tin cơ bản</p>

        <div class="form-group">
            <label class="form-group-label" for="tennhahang">Tên nhà hàng</label>
            <input type="text" id="tennhahang" class="form-input-text" value="Nhà hàng ABC">
        </div>
        
        <div class="form-group">
            <label class="form-group-label" for="sodienthoai">Số điện thoại</label>
            <input type="text" id="sodienthoai" class="form-input-text" value="0123456789">
        </div>

        <div class="form-group">
            <label class="form-group-label" for="email">Email</label>
            <input type="email" id="email" class="form-input-text" value="contact@gmail.com">
        </div>
    </section>
    
    <section class="card">
        <div class="config-card-title">
            <span class="material-icons-outlined">event_note</span>
            Cấu hình đặt bàn
        </div>
        <p class="config-card-title p">Thiết lập các thông số về đặt bàn</p>

        <div class="form-group">
            <label class="form-group-label" for="soluongtoida">Số lượng đặt bàn tối đa (mặc định)</label>
            <input type="number" id="soluongtoida" class="form-input-text" value="20">
            <span class="form-input-hint">Số bàn tối đa mà mỗi chi nhánh có thể tiếp nhận (có thể tùy chỉnh cho từng chi nhánh)</span>
        </div>
        
        <div class="form-group">
            <label class="form-group-label" for="thoigianhuy">Thời gian cho phép hủy đặt bàn (giờ)</label>
            <input type="number" id="thoigianhuy" class="form-input-text" value="24">
            <span class="form-input-hint">Khách hàng có thể hủy đặt bàn trước ít nhất bao nhiêu giờ</span>
        </div>
    </section>

    <section class="card">
        <div class="config-card-title">
            <span class="material-icons-outlined">email</span>
            Thông báo & Email
        </div>
        <p class="config-card-title p">Cấu hình gửi email thông báo</p>

        <div class="alert-box">
            <p>
                <strong>Lưu ý:</strong> Để gửi email xác nhận/hủy bàn cho khách hàng, bạn cần cấu hình email server trong Supabase.
            </p>
            <p>
                Tham khảo tài liệu tại: 
                <a href="https://supabase.com/docs/guides/auth/email/server" target="_blank">Supabase Email Configuration</a>
            </p>
        </div>
    </section>  
</main>
<?php include 'views/layouts/footer.php'; ?>