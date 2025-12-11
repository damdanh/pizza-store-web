<?php
session_start();
require_once '../app/config/database.php';
require_once '../app/model/BookingModel.php';

// Chặn double submit
if (isset($_SESSION['last_booking_time']) && (time() - $_SESSION['last_booking_time']) < 3) {
    die("Vui lòng đợi trước khi đặt bàn lại!");
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die("Yêu cầu không hợp lệ");
}

$pdo = getConnection();
$bookingModel = new BookingModel($pdo);

// LẤY DỮ LIỆU
$soluongban = max(1, (int)($_POST['tables'] ?? 1)); // SỬA TẠI ĐÂY
$name   = trim($_POST['name'] ?? '');
$phone  = trim($_POST['phone'] ?? '');
$email  = trim($_POST['email'] ?? '');
$date   = $_POST['date'] ?? date('Y-m-d');
$time   = $_POST['time'] ?? '19:00:00';
$branch = trim($_POST['branch'] ?? '');
$notes  = trim($_POST['notes'] ?? '');

// Validate
if (empty($name) || empty($phone) || empty($branch)) {
    die("Vui lòng điền đầy đủ thông tin bắt buộc!");
}

// TÍNH TIỀN MÓN
$cart = $_SESSION['cart'] ?? [];
$tongGiaMenuCoVAT = 0;

foreach ($cart as $item) {
    if (isset($item['gia'], $item['so_luong']) && is_numeric($item['gia']) && is_numeric($item['so_luong'])) {
        $tongGiaMenuCoVAT += $item['gia'] * $item['so_luong'];
    }
}

define('GIA_MOT_BAN', 50000);
$phiBan = $soluongban * GIA_MOT_BAN; // DÙNG $soluongban

if ($tongGiaMenuCoVAT > 0) {
    $totalMonChuaVAT = $tongGiaMenuCoVAT / 1.08;
    $vat = $tongGiaMenuCoVAT - $totalMonChuaVAT;
    $phiDichVu = $tongGiaMenuCoVAT * 0.20;
    $tongCuoiCung = $phiBan + $phiDichVu;
    $tienThanhToanSauDB = $tongGiaMenuCoVAT - $tongCuoiCung;
} else {
    $vat = 0;
    $totalMonChuaVAT = 0;
    $phiDichVu = 0;
    $tongCuoiCung = $phiBan;
    $tienThanhToanSauDB = 0;
}

// Làm tròn
$totalMonChuaVAT = round($totalMonChuaVAT);
$vat = round($vat);
$tongGiaMenuCoVAT = round($tongGiaMenuCoVAT);
$phiDichVu = round($phiDichVu);
$tongCuoiCung = round($tongCuoiCung);
$tienThanhToanSauDB = round($tienThanhToanSauDB);

// Nếu tổng = 0 → lưu luôn (hiếm)
// if ($tongCuoiCung <= 0) {
//     $bookingId = $bookingModel->createBooking([
//         'name' => $name, 'phone' => $phone, 'email' => $email,
//         'soluongban' => $soluongban, 'date' => $date, 'time' => $time,
//         'branch' => $branch, 'notes' => $notes
//     ]);
//     $_SESSION['booking'] = ['id' => $bookingId, 'paid' => true, 'total' => 0];
//     unset($_SESSION['cart']);
//     header("Location: xac-nhan");
//     exit;
// }

// TẠO QR + PENDING
$orderCode = "DATBAN" . date('YmdHis') . rand(100,999);
$qrUrl = "https://img.vietqr.io/image/970416-34251757-compact2.png?amount={$tongCuoiCung}&addInfo=" . urlencode($orderCode) . "&accountName=" . urlencode("VU TIEN DAT");
// chờ thanh toán
$_SESSION['pending_booking'] = [
    'order_code' => $orderCode,
    'amount' => $tongCuoiCung,
    'tien_mon_chua_vat' => $totalMonChuaVAT,
    'vat' => $vat,
    'tien_mon_co_vat' => $tongGiaMenuCoVAT,
    'phi_ban' => $phiBan,
    'phi_dich_vu' => $phiDichVu,
    'tien_thanh_toan_sau_db' => $tienThanhToanSauDB,
    'name' => $name, 'phone' => $phone, 'email' => $email,
    'tables' => $soluongban, // Dùng tables để hiển thị
    'date' => $date, 'time' => $time, 
    'branch' => $branch,
     'notes' => $notes,
    'cart' => $cart
];

$_SESSION['qr_code'] = $qrUrl;
$_SESSION['last_booking_time'] = time();

header("Location: xac-nhan");
exit;
?>