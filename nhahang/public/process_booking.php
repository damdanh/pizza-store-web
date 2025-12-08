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

// Phí bàn
define('GIA_MOT_BAN', 50000);
$phiBan = $tables * GIA_MOT_BAN;

// Tính tổng CẦN THANH TOÁN
if ($totalMonChuaVAT > 0) {
    // CÓ MÓN: Tính VAT 8% + Phí dịch vụ 20%
    $vat = $totalMonChuaVAT * 0.08; // VAT 8%
    $totalMonCoVAT = $totalMonChuaVAT + $vat; // Tổng món + VAT
    $phiDichVu = $totalMonCoVAT * 0.20; // Phí dịch vụ 20% tính trên tổng có VAT
    $tongCuoiCung = $phiBan + $phiDichVu; // CHỈ trả phí bàn + phí dịch vụ
} else {
    // KHÔNG CÓ MÓN: Chỉ tính phí bàn
    $vat = 0;
    $totalMonCoVAT = 0;
    $tongCuoiCung = $phiBan;
    $phiDichVu = 0;
}

// ====== CASE 1: KHÔNG CÓ MÓN ======
if (empty($cart) || $totalMonChuaVAT <= 0) {
    try {
        $bookingId = $bookingModel->createBooking([
            'name' => $name,
            'phone' => $phone,
            'email' => $email,
            'people' => $tables, // Lưu số bàn vào cột people
            'date' => $date,
            'time' => $time,
            'branch' => $branch,
            'notes' => $notes
        ]);

        if (!$bookingId) {
            throw new Exception("Không thể tạo booking");
        }

        $_SESSION['booking'] = [
            'id' => $bookingId,
            'name' => $name,
            'phone' => $phone,
            'email' => $email,
            'date' => $date,
            'time' => $time,
            'tables' => $tables,
            'branch' => $branch,
            'notes' => $notes,
            'cart' => [],
            'tien_mon_chua_vat' => 0,
            'vat' => 0,
            'tien_mon_co_vat' => 0,
            'phi_ban' => $phiBan,
            'phi_dich_vu' => 0,
            'total' => $phiBan,
            'paid' => true
        ];

        $_SESSION['last_booking_time'] = time();
        unset($_SESSION['cart']);
        header("Location: xac-nhan");
        exit;

    } catch (Exception $e) {
        error_log("Lỗi đặt bàn: " . $e->getMessage());
        die("Đã xảy ra lỗi, vui lòng thử lại!");
    }
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