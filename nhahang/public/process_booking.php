<?php
session_start();
require_once __DIR__ . '/../app/config/database.php';

try {
    $pdo = getConnection();

    $name   = trim($_POST['name'] ?? '');
    $phone  = trim($_POST['phone'] ?? '');
    $email  = trim($_POST['email'] ?? '');
    $people = (int)($_POST['people'] ?? 1);
    $date   = $_POST['date'] ?? '';
    $time   = $_POST['time'] ?? '';
    $branch = $_POST['branch'] ?? '';
    $notes  = trim($_POST['notes'] ?? '');

    if ($name === '' || $phone === '') {
        die("Vui lòng nhập đầy đủ thông tin bắt buộc.");
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

    header("Location: /WD20302-PRO1014_N5/nhahang/public/xac-nhan");
    exit;

} catch (Exception $e) {
    die("Lỗi: " . $e->getMessage());
}
