<?php
$pageTitle = "Đặt bàn trực tuyến | Hệ thống Nhà hàng";
$activePage = "formDemo";
include 'views/layouts/header.php';
include 'views/layouts/sidebar.php';
?>

<main class="main-content">
    <header class="page-header">
        <h1>Đặt bàn trực tuyến</h1>
        <p>Đặt bàn nhanh chóng và trực tuyến</p>
    </header>
    
    <section class="card">
        <div class="step-indicator">
            <div class="step-number active">1</div>
            <div class="step-number">2</div>
            <div class="step-number">3</div>
        </div>
        
        <form>
            <div class="form-title">Thông tin đặt bàn</div>
            
            <div class="form-row">
                <div class="form-group">
                    <label class="form-group-label" for="ten">Họ và tên <span>*</span></label>
                    <input type="text" id="ten" class="form-input" value="Nguyễn Văn A">
                </div>
                <div class="form-group">
                    <label class="form-group-label" for="sdt">Số điện thoại <span>*</span></label>
                    <input type="tel" id="sdt" class="form-input" value="0123456789">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-group-label" for="email">Email <span>*</span></label> 
                    <input type="email" id="email" class="form-input" value="email@example.com">
                </div>
                <div class="form-group">
                    <label class="form-group-label" for="chinhanh">Chi nhánh <span>*</span></label>
                    <select id="chinhanh" class="form-select">
                        <option disabled selected>Chọn chi nhánh</option>
                        <option>Chi nhánh 1</option>
                        <option>Chi nhánh 2</option>
                    </select>
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label class="form-group-label" for="ngay">Ngày <span>*</span></label>
                    <input type="text" id="ngay" class="form-input" placeholder="dd/mm/yy">
                </div>
                <div class="form-group">
                    <label class="form-group-label" for="gio">Giờ <span>*</span></label>
                    <input type="text" id="gio" class="form-input" placeholder="--:-- --">
                </div>
                <div class="form-group">
                    <label class="form-group-label" for="songuoi">Số người <span>*</span></label>
                    <input type="number" id="songuoi" class="form-input" value="2">
                </div>
            </div>
            
            <div class="form-group">
                <label class="form-group-label" for="ghichu">Ghi chú</label>
                <textarea id="ghichu" class="form-textarea" placeholder="Yêu cầu đặc biệt...."></textarea>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-continue">
                    Tiếp tục - chọn món (Tùy chọn)
                </button>
            </div>
        </form>
    </section>
</main>

<?php include 'views/layouts/footer.php'; ?>