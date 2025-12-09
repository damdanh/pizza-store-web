<style>
/* ... (GIỮ NGUYÊN CSS TỪ ĐẦU) ... */

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

        /* --- Filter Section Styling (Thanh tìm kiếm/lọc) --- */
        .filter-section {
            padding: 15px 20px; 
            margin-bottom: 20px;
        }

        .filter-controls {
            display: flex;
            gap: 15px; 
            align-items: center; 
        }

        .filter-input {
            flex-grow: 1; 
            padding: 10px 12px;
            border: 1px solid var(--border-color);
            border-radius: 4px;
            font-size: 14px;
            color: var(--text-dark);
            background-color: #f7f7f7; 
        }

        .filter-input::placeholder {
            color: var(--text-sub);
        }

        .refresh-btn {
            padding: 10px 20px;
            background-color: var(--white);
            color: var(--text-dark);
            border: 1px solid var(--border-color);
            border-radius: 4px;
            font-size: 14px;
            cursor: pointer;
            transition: background-color 0.2s;
            white-space: nowrap; 
        }

        .refresh-btn:hover {
            background-color: var(--nav-hover);
        }

        /* --- Content Table Area Styling (Khu vực hiển thị dữ liệu/bảng) --- */
        .content-table-area {
            min-height: 400px;
            /* Bỏ căn giữa để bảng hiển thị từ trên xuống */
            /* display: flex; 
            align-items: center; 
            justify-content: center; */
            padding: 20px; /* Thêm padding nếu cần thiết */
        }

        .empty-state {
            font-size: 16px;
            color: var(--text-sub);
            padding: 50px;
            text-align: center;
        }

        /* Style cho bảng đặt bàn */
        .booking-table {
            width: 100%;
            border-collapse: collapse;
            table-layout: auto; 
        }
        .booking-table th, .booking-table td {
            border: 1px solid var(--border-color);
            padding: 12px 15px;
            text-align: left;
            font-size: 14px;
            vertical-align: middle;
        }
        .booking-table th {
            background-color: var(--nav-hover);
            font-weight: 600;
            color: var(--text-dark);
        }
        .booking-table tr:nth-child(even) {
            background-color: #fcfcfc;
        }
        .btn-detail {
            padding: 5px 10px;
            background-color: var(--primary-color);
            color: var(--white);
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
            display: block; /* Đặt thành block để mỗi nút chiếm một dòng */
            text-align: center;
            margin-bottom: 5px; /* Thêm margin để tách các nút */
        }
        
        /* Thêm style cho nút Xác nhận và Xóa */
        .btn-confirm {
            padding: 5px 10px;
            background-color: #28a745; /* Màu xanh lá cho xác nhận */
            color: var(--white);
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
            display: block;
            text-align: center;
            margin-bottom: 5px;
        }

        .btn-delete {
            padding: 5px 10px;
            background-color: #dc3545; /* Màu đỏ cho xóa */
            color: var(--white);
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
            display: block;
            text-align: center;
            margin-bottom: 5px;
        }


        .status-badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
        }
        .status-pending { background-color: #ffc107; color: #333; } /* Vàng (Chờ xác nhận) */
        .status-confirmed { background-color: #28a745; color: white; } /* Xanh lá (Đã xác nhận) */
        .status-cancelled { background-color: #dc3545; color: white; } /* Đỏ (Đã hủy) */
        .status-completed { background-color: #007bff; color: white; } /* Xanh dương (Đã hoàn tất) */


</style>
<?php
$pageTitle = "Quản lý đặt bàn & Pre-order | Hệ thống Nhà hàng";
$activePage = "quanlydatban";
include 'views/layouts/header.php';
include 'views/layouts/sidebar.php';

// Giả sử $ds_datban, $message, $error đã được AdminController truyền vào
?>

<main class="main-content">
    <header class="page-header">
        <h1>Quản lý đặt bàn & Pre-order</h1>
        <p>Xem và xác nhận đơn đặt bàn</p>
        
        <?php if (isset($message) && !empty($message)): // Hiển thị thông báo thành công từ Controller ?>
            <div style="padding: 10px; background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; border-radius: 4px; margin-top: 15px; font-weight: bold;">
                <?php echo htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>
        
        <?php if (isset($error) && !empty($error)): // Hiển thị lỗi từ Controller ?>
            <div style="padding: 10px; background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; border-radius: 4px; margin-top: 15px; font-weight: bold;">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>
    </header>

    <section class="filter-section card">
        <div class="filter-controls">
            <input type="text" class="filter-input" placeholder="Tìm kiếm theo Tên/SĐT">
            <input type="text" class="filter-input" placeholder="Trạng Thái">
            <input type="text" class="filter-input" placeholder="Chi Nhánh">
            <button class="refresh-btn">Làm mới</button>
        </div>
    </section>

    <section class="content-table-area card">
        <?php if (!empty($ds_datban) && is_array($ds_datban)): ?>
            
            <table class="booking-table">
                <thead>
                    <tr>
                        <th style="width: 5%;">ID</th>
                        <th style="width: 15%;">Tên Khách Hàng</th>
                        <th style="width: 10%;">SĐT</th>
                        <th style="width: 20%;">Chi Nhánh</th>
                        <th style="width: 15%;">Thời Gian</th>
                        <th style="width: 5%;">SL</th>
                        <th style="width: 10%;">Trạng Thái</th>
                        <th style="width: 10%;">Tổng tiền</th>
                        <th style="width: 10%;">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    // Hàm đơn giản để chuyển trạng thái số thành chữ và CSS class
                    function getStatusDisplay($statusId) {
                        $statusId = (int)$statusId; 
                        $statuses = [
                            0 => ['text' => 'Chờ xác nhận', 'class' => 'status-pending'],
                            1 => ['text' => 'Đã xác nhận', 'class' => 'status-confirmed'],
                            2 => ['text' => 'Đã hủy', 'class' => 'status-cancelled'],
                            3 => ['text' => 'Đã hoàn tất', 'class' => 'status-completed'],
                        ];
                        return $statuses[$statusId] ?? ['text' => 'Không rõ', 'class' => ''];
                    }
                    ?>

                    <?php foreach ($ds_datban as $datban): ?>
                        <?php $status = getStatusDisplay($datban['status'] ?? 0); // Giả sử có cột 'status' ?>
                        <tr>
                            <td><?php echo htmlspecialchars($datban['id']); ?></td>
                            <td><?php echo htmlspecialchars($datban['name']); ?></td>
                            <td><?php echo htmlspecialchars($datban['phone']); ?></td>
                            <td><?php echo htmlspecialchars($datban['branch']); ?></td>
                            <td>
                                <?php echo htmlspecialchars(date('d/m/Y', strtotime($datban['booking_date']))); ?><br>
                                **<?php echo htmlspecialchars(date('H:i', strtotime($datban['booking_time']))); ?>**
                            </td>
                            <td><?php echo htmlspecialchars($datban['soluongban'] ?? 0); ?></td> 
                            <td><span class="status-badge <?php echo $status['class']; ?>"><?php echo $status['text']; ?></span></td>
                            <td><?php echo number_format((float)($datban['total'] ?? 0), 0, ',', '.') . '₫'; ?></td> 
                            <td>
                                <?php if ((int)($datban['status'] ?? 0) === 0): ?>
                                    <a href="admin.php?page=quanlydatban&action=confirm&id=<?php echo $datban['id']; ?>" class="btn-confirm" onclick="return confirm('Bạn có chắc chắn muốn XÁC NHẬN đơn đặt bàn #<?php echo $datban['id']; ?> này?');">
                                        Xác nhận
                                    </a>
                                <?php endif; ?>
                                
                                <!-- <a href="admin.php?page=datban_detail&id=<?php echo $datban['id']; ?>" class="btn-detail">Chi tiết</a> -->
                                
                                <a href="admin.php?page=quanlydatban&action=delete&id=<?php echo $datban['id']; ?>" class="btn-delete" onclick="return confirm('Bạn có chắc chắn muốn XÓA đơn đặt bàn #<?php echo $datban['id']; ?> này? Đây là hành động không thể hoàn tác.');">
                                    Xóa
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="empty-state">
                <?php if (isset($error) && !empty($error)): ?>
                    <?php echo htmlspecialchars($error); ?>
                <?php else: ?>
                    Không tìm thấy đơn đặt bàn nào.
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </section>
</main>
<?php include 'views/layouts/footer.php'; ?>