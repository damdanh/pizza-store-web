
<?php
$pageTitle = "Quản lý Tài khoản Admin | Hệ thống Nhà hàng";
$activePage = "admin";
include 'views/layouts/header.php';
include 'views/layouts/sidebar.php';
?>

<main class="main-content">
    <header class="page-header">
        <div class="page-title-group">
            <h1>Quản lý tài khoản Admin</h1>
            <p>Thêm, sửa, ẩn các tài khoản quản trị</p>
        </div>

        <div class="action-button-single">
            <button class="action-btn">
                Thêm Admin
            </button>
        </div>
    </header>

    <section class="card admin-list-section">
        <div class="list-header">
            <h2>Danh sách Admin</h2>
            <p>Tổng cộng 4 tài khoản</p>
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
                <tr>
                    <td>Danh</td>
                    <td><a href="mailto:danhdam200@gmail.com">danhdam200@gmail.com</a></td>
                    <td>admin</td>
                    <td>19/11/2025</td>
                    <td>
                        <a href="#" class="action-link">Sửa</a>
                    </td>
                </tr>
                <tr>
                    <td>Trị</td>
                    <td><a href="mailto:thanhtri@gmail.com">thanhtri@gmail.com</a></td>
                    <td>admin</td>
                    <td>19/11/2025</td>
                    <td>
                        <a href="#" class="action-link">Sửa</a>
                    </td>
                </tr>
                <tr>
                    <td>Đạt</td>
                    <td><a href="mailto:tiendat@gmail.com">tiendat@gmail.com</a></td>
                    <td>admin</td>
                    <td>19/11/2025</td>
                    <td>
                        <a href="#" class="action-link">Sửa</a>
                    </td>
                </tr>
                <tr>
                    <td>Lộc</td>
                    <td><a href="mailto:tanloc@gmail.com">tanloc@gmail.com</a></td>
                    <td>admin</td>
                    <td>19/11/2025</td>
                    <td>
                        <a href="#" class="action-link">Sửa</a>
                    </td>
                </tr>
            </tbody>
        </table>
    </section>
</main>

<?php include 'views/layouts/footer.php'; ?>
