 <aside class="sidebar">
            <div class="sidebar-header">
                <img src="img/logoN5.png" alt="logoN5" class="avatar">
                <div>
                    <div class="system-name">Hệ thống</div>
                    <div class="sub-text">Quản lý nhà hàng</div>
                </div>
            </div>

            <nav class="sidebar-nav">
                <a href="admin.php?page=dashboard" class="nav-item <?= ($activePage == 'dashboard') ? 'active' : '' ?>">
                    <span class="material-icons-outlined">grid_view</span>
                    Tổng quan
                </a>
                <a href="admin.php?page=quanlydatban" class="nav-item <?= ($activePage == 'quanlydatban') ? 'active' : '' ?>">
                    <span class="material-icons-outlined">calendar_month</span>
                    Quản lý đặt bàn
                </a>
                <a href="admin.php?page=menu" class="nav-item <?= ($activePage == 'menu') ? 'active' : '' ?>">
                    <span class="material-icons-outlined">restaurant_menu</span>
                    Quản lý menu
                </a>
                <a href="admin.php?page=chinhanh" class="nav-item <?= ($activePage == 'chinhanh') ? 'active' : '' ?>">
                    <span class="material-icons-outlined">storefront</span>
                    Quản lý chi nhánh
                </a>
                <a href="admin.php?page=admin" class="nav-item <?= ($activePage == 'admin') ? 'active' : '' ?>">
                    <span class="material-icons-outlined">person</span>
                    Quản lý admin
                </a>
                <a href="admin.php?page=doanhthu" class="nav-item <?= ($activePage == 'doanhthu') ? 'active' : '' ?>">
                    <span class="material-icons-outlined">bar_chart</span>
                    Thống kê doanh thu
                </a>
                <a href="admin.php?page=cauhinh" class="nav-item <?= ($activePage == 'cauhinh') ? 'active' : '' ?>">
                    <span class="material-icons-outlined">settings</span>
                    Cấu hình hệ thống
                </a>
            </nav>

            <div class="sidebar-divider"></div>

            <div class="sidebar-demo">
                <a href="admin.php?page=formDemo" class="nav-item demo-item <?= ($activePage == 'formDemo') ? 'active' : '' ?>">
                    <span class="material-icons-outlined">article</span>
                    Form khách hàng <span class="sub-text">(Demo)</span>
                </a>
            </div>

            <div class="sidebar-footer">
    <div class="login-info">Đăng nhập với <br> <strong><?= $_SESSION['admin']['ten'] ?? 'Admin' ?></strong></div>
    
 <a href="admin.php?action=logout" class="logout-btn">
    <span class="material-icons-outlined">logout</span>
    Đăng xuất
</a>
</div>
        </aside>
