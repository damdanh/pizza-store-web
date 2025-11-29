<?php
$pageTitle = "Cấu hình Hệ thống | Hệ thống Nhà hàng";
$activePage = "cauhinh";
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