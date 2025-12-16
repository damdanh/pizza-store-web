<?php
/**
 * File: public/process_booking.php
 * Xử lý form đặt bàn, tính toán chi phí, tạo Session chờ thanh toán (Pending Booking),
 * và chuyển hướng đến trang hiển thị QR code.
 */

session_start();
<<<<<<< HEAD
require_once '../app/config/database.php';
require_once '../app/model/BookingModel.php';

// ====== CHẶN DOUBLE SUBMIT ======
if (isset($_SESSION['last_booking_time'])) {
    $timeSinceLastBooking = time() - $_SESSION['last_booking_time'];
    if ($timeSinceLastBooking < 3) {
        die("Vui lòng đợi trước khi đặt bàn lại!");
=======
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once '../app/config/database.php';

// ================== CHẶN DOUBLE SUBMIT ==================
if (isset($_SESSION['last_booking_time'])) {
    if (time() - $_SESSION['last_booking_time'] < 3) {
        $_SESSION['error_message'] = "Vui lòng đợi 3 giây trước khi đặt bàn lại!";
        header("Location: dat-ban");
        exit;
>>>>>>> feat_Lộc
    }
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die("Yêu cầu không hợp lệ");
}

<<<<<<< HEAD
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

=======
// ================== LẤY DỮ LIỆU FORM (Sử dụng tên key từ file (1) và thêm fallback) ==================
$tables = (int)($_POST['tables'] ?? $_POST['soluongban'] ?? 1);
$name   = trim($_POST['name'] ?? '');
$phone  = trim($_POST['phone'] ?? '');
$email  = trim($_POST['email'] ?? '');
// Hợp nhất tên key: ưu tiên tên đơn giản (date, time) và dùng booking_date/time làm fallback
$date   = $_POST['date'] ?? $_POST['booking_date'] ?? date('Y-m-d'); 
$time   = $_POST['time'] ?? $_POST['booking_time'] ?? '19:00:00';
$branch = trim($_POST['branch'] ?? '');
$notes  = trim($_POST['notes'] ?? '');

// ================== VALIDATE (Dùng SESSION Error Message) ==================
if (empty($name) || empty($phone) || empty($branch)) {
    $_SESSION['error_message'] = "Vui lòng điền đầy đủ thông tin bắt buộc!";
    header("Location: dat-ban");
    exit;
}

// ================== TÍNH TOÁN CHI PHÍ & GIỎ HÀNG ==================
$cart = $_SESSION['cart'] ?? [];
$tongGiaMenuCoVAT = 0;

foreach ($cart as $item) {
    if (isset($item['gia'], $item['so_luong']) && is_numeric($item['gia']) && is_numeric($item['so_luong'])) {
        $tongGiaMenuCoVAT += $item['gia'] * $item['so_luong'];
    }
}

define('GIA_MOT_BAN', 50000);
$phiBan = max(1, $tables) * GIA_MOT_BAN;

if ($tongGiaMenuCoVAT > 0) {
    // 1. Tính toán giá trị chưa VAT (Giả định VAT 8% = 1.08)
    $totalMonChuaVAT = $tongGiaMenuCoVAT / 1.08;
    $vat = $tongGiaMenuCoVAT - $totalMonChuaVAT;
    
    // 2. Tính phí dịch vụ (Giả định 20% trên giá món có VAT)
    $phiDichVu = $tongGiaMenuCoVAT * 0.20;
    
    // 3. Tổng tiền phải trả ngay (Phí bàn + Phí dịch vụ)
    $tongCuoiCung = $phiBan + $phiDichVu; 
    
    // 4. Tiền còn lại phải trả sau (Tổng giá món - Tổng tiền trả ngay)
    $tienThanhToanSauDB = $tongGiaMenuCoVAT - $tongCuoiCung;
    
    // START FIX: Đảm bảo số tiền thanh toán sau không âm
    if ($tienThanhToanSauDB < 0) {
        $tienThanhToanSauDB = 0;
        // Ghi chú: Số dư (188k trong ví dụ của bạn) sẽ được ngầm định hoàn lại/trừ vào chi phí khác tại nhà hàng.
    }
    // END FIX
    
} else {
    // Không có món ăn kèm
    $totalMonChuaVAT = 0;
    $vat = 0;
    $phiDichVu = 0;
    
    // Tổng tiền trả ngay chỉ là phí bàn
    $tongCuoiCung = $phiBan;
    $tienThanhToanSauDB = 0;
}

// ===== LÀM TRÒN =====
$totalMonChuaVAT = round($totalMonChuaVAT);
$vat = round($vat);
$tongGiaMenuCoVAT = round($tongGiaMenuCoVAT);
$phiDichVu = round($phiDichVu);
$tongCuoiCung = round($tongCuoiCung);
$tienThanhToanSauDB = round($tienThanhToanSauDB);


// ================== TẠO QR ==================
$orderCode = "DATBAN" . date('YmdHis') . rand(100, 999);
$bankBin = "970416"; // MB Bank
$accountNo = "34251757";
$accountName = "VU TIEN DAT";

// Tạo URL QR Code
>>>>>>> feat_Lộc
$qrUrl = "https://img.vietqr.io/image/{$bankBin}-{$accountNo}-compact2.png"
       . "?amount=" . (int)$tongCuoiCung
       . "&addInfo=" . urlencode($orderCode)
       . "&accountName=" . urlencode($accountName);

<<<<<<< HEAD
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
=======
// ================== LƯU SESSION CHỜ THANH TOÁN ==================
$_SESSION['pending_booking'] = [
    'order_code' => $orderCode,
    'amount' => $tongCuoiCung, // Tiền cần thanh toán qua QR

    // Dữ liệu chi tiết cho View/Model
    'tien_mon_chua_vat' => $totalMonChuaVAT,
    'vat' => $vat,
    'tien_mon_co_vat' => $tongGiaMenuCoVAT,
    'phi_ban' => $phiBan,
    'phi_dich_vu' => $phiDichVu,
    'tien_thanh_toan_sau_db' => $tienThanhToanSauDB, // Tiền còn lại phải trả sau (Đã FIX >= 0)

    // Dữ liệu form
    'name' => $name,
    'phone' => $phone,
    'email' => $email,
    'tables' => $tables,
    'date' => $date,
    'time' => $time,
    'branch' => $branch,
    'notes' => $notes,
    'cart' => $cart
>>>>>>> feat_Lộc
];

$_SESSION['qr_code'] = $qrUrl;
$_SESSION['last_booking_time'] = time();

<<<<<<< HEAD
=======
// ================== CHUYỂN SANG TRANG QR ==================
>>>>>>> feat_Lộc
header("Location: xac-nhan");
exit;