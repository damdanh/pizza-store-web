<?php
session_start();
require_once '../app/config/database.php';
require_once '../app/model/BookingModel.php';

// ====== CHẶN DOUBLE SUBMIT ======
if (isset($_SESSION['last_booking_time'])) {
    $timeSinceLastBooking = time() - $_SESSION['last_booking_time'];
    if ($timeSinceLastBooking < 3) {
        die("Vui lòng đợi trước khi đặt bàn lại!");
    }
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die("Yêu cầu không hợp lệ");
}

$pdo = getConnection();
$bookingModel = new BookingModel($pdo);

// ====== LẤY DỮ LIỆU FORM ======
$tables = (int)($_POST['tables'] ?? 1); // Số bàn
$name   = trim($_POST['name'] ?? '');
$phone  = trim($_POST['phone'] ?? '');
$email  = trim($_POST['email'] ?? '');
$date   = $_POST['date'] ?? date('Y-m-d');
$time   = $_POST['time'] ?? '19:00:00';
$branch = $_POST['branch'] ?? '';
$notes  = trim($_POST['notes'] ?? '');

// Validate
if (empty($name) || empty($phone) || empty($branch)) {
    die("Vui lòng điền đầy đủ thông tin bắt buộc!");
}

// ====== TÍNH PHÍ ======
$cart = $_SESSION['cart'] ?? [];
$totalMonChuaVAT = 0; // Tổng tiền món (chưa VAT)

foreach ($cart as $item) {
    if (isset($item['gia'], $item['so_luong'])) {
        $totalMonChuaVAT += $item['gia'] * $item['so_luong'];
    }
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
        'id'      => $bookingId,
        'name'    => $name,
        'phone'   => $phone,
        'email'   => $email,
        'people'  => $people,
        'date'    => $date,
        'time'    => $time,
        'branch'  => $branch,
        'notes'   => $notes,
        'cart'    => $cart,
        'total'   => $total
    ];

    unset($_SESSION['cart']);


    header("Location: /WD20302-PRO1014_N5/nhahang/public/xac-nhan");
    exit;

} catch (Exception $e) {

    die("Lỗi xử lý đặt bàn: " . $e->getMessage());

    die("Lỗi: " . $e->getMessage());

}


$orderCode = "DATBAN" . date('YmdHis') . rand(100, 999);

$bankBin = "970416";
$accountNo = "34251757";
$accountName = "VU TIEN DAT";

$qrUrl = "https://img.vietqr.io/image/{$bankBin}-{$accountNo}-compact2.png"
       . "?amount=" . (int)$tongCuoiCung
       . "&addInfo=" . urlencode($orderCode)
       . "&accountName=" . urlencode($accountName);

$_SESSION['pending_booking'] = [
    'order_code' => $orderCode,
    'amount'     => $tongCuoiCung,
    'tien_mon_chua_vat' => $totalMonChuaVAT,
    'vat'        => $vat,
    'tien_mon_co_vat' => $totalMonCoVAT,
    'phi_ban'    => $phiBan,
    'phi_dich_vu' => $phiDichVu,
    'name'       => $name,
    'phone'      => $phone,
    'email'      => $email,
    'tables'     => $tables,
    'date'       => $date,
    'time'       => $time,
    'branch'     => $branch,
    'notes'      => $notes,
    'cart'       => $cart
];

$_SESSION['qr_code'] = $qrUrl;
$_SESSION['last_booking_time'] = time();

header("Location: xac-nhan");
exit;