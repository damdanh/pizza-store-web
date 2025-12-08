<?php
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../app/config/database.php';   // ĐÃ ĐÚNG ĐƯỜNG DẪN

try {
    $pdo = getConnection();

    $name   = trim($_POST['name'] ?? '');
    $phone  = trim($_POST['phone'] ?? '');
    $email  = trim($_POST['email'] ?? '');
    $people = (int)($_POST['people'] ?? 2);
    $date   = $_POST['date'] ?? '2025-12-15';
    $time   = $_POST['time'] ?? '19:00';
    $branch = $_POST['branch'] ?? 'Pizza & Pasta - 24 Nguyễn Thị Nghĩa';
    $notes  = trim($_POST['notes'] ?? '');

    if (empty($name) || empty($phone)) {
        die('Vui lòng nhập tên và số điện thoại');
    }

    // ĐÃ SỬA DÒNG NÀY – CHỈ CÒN 8 CỘT TƯƠNG ỨNG 8 DẤU ?
    // Chèn vào bảng `dat_ban` (sử dụng `id_khach_hang` nếu user đã đăng nhập)
    $user_id = $_SESSION['user_id'] ?? null;

    // Hợp nhất ngày + giờ thành một DATETIME phù hợp cho cột `ngay_dat_ban`
    $datetime = date('Y-m-d H:i:s', strtotime($date . ' ' . $time));

    $sql = "INSERT INTO dat_ban (id_khach_hang, id_ban, ngay_dat_ban, so_luong_nguoi, ghi_chu, phu_phi, tong_gia, trang_thai_dat_ban) 
            VALUES (:id_khach_hang, NULL, :ngay_dat_ban, :so_luong, :ghi_chu, 0.00, 0.00, 'Chờ xác nhận')";

    $stmt = $pdo->prepare($sql);
    $params = [
        'id_khach_hang' => $user_id,
        'ngay_dat_ban'  => $datetime,
        'so_luong'      => $people,
        'ghi_chu'       => $notes
    ];
    $stmt->execute($params);

    // Lưu vào session để hiển thị xác nhận cho user
    $_SESSION['booking'] = [
        'id'      => $pdo->lastInsertId(),
        'name'    => $name,
        'phone'   => $phone,
        'email'   => $email,
        'people'  => $people,
        'date'    => $date,
        'time'    => $time,
        'branch'  => $branch,
        'notes'   => $notes
    ];

    header('Location: ../app/view/xacnhandatban.php');
exit;

} catch (Exception $e) {
    die('Lỗi: ' . $e->getMessage());
}
?>