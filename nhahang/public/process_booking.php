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

// ====== TÍNH PHÍ (LOGIC MỚI: GIÁ MENU ĐÃ CÓ VAT) ======
$cart = $_SESSION['cart'] ?? [];
$tongGiaMenuCoVAT = 0; // Tổng tiền món (CÓ VAT) - Đây là Tổng giá trị giỏ hàng

foreach ($cart as $item) {
    if (isset($item['gia'], $item['so_luong'])) {
        // TÍNH TỔNG GIÁ TRỊ CỦA CÁC MÓN (ĐÃ BAO GỒM VAT 8%)
        $tongGiaMenuCoVAT += $item['gia'] * $item['so_luong'];
    }
}

// Phí bàn
define('GIA_MOT_BAN', 50000);
$phiBan = $tables * GIA_MOT_BAN;

// Tính tổng CẦN THANH TOÁN
if ($tongGiaMenuCoVAT > 0) {
    
    // === 1. TÍNH CÁC THÀNH PHẦN RIÊNG LẺ (Dùng cho hiển thị) ===
    $totalMonCoVAT = $tongGiaMenuCoVAT; // Tổng tiền món thực tế
    
    // Tổng món CHƯA VAT (Bóc tách VAT 8% ra khỏi tổng tiền)
    $totalMonChuaVAT = $totalMonCoVAT / 1.08; 
    
    // VAT 8% (Phần VAT thực tế trong Tổng giá menu)
    $vat = $totalMonCoVAT - $totalMonChuaVAT; 
    
    // Phí dịch vụ 20% tính trên tổng CÓ VAT
    $phiDichVu = $totalMonCoVAT * 0.20; 
    
    // Total Amount (Tiền cọc cần thanh toán ngay: Phí bàn + Phí dịch vụ)
    $tongCuoiCung = $phiBan + $phiDichVu; 
    
    // === 2. TÍNH TIỀN CÒN LẠI PHẢI THANH TOÁN SAU (LOGIC MỚI LƯU DB) ===
    // Tiền còn lại phải trả = Tổng món có VAT - Tiền cọc đã trả
    $tienThanhToanSauDB = $totalMonCoVAT - $tongCuoiCung;
    
    // --- LÀM TRÒN ---
    // Nên làm tròn tất cả các giá trị tiền tệ trước khi lưu vào session
    $totalMonChuaVAT = round($totalMonChuaVAT, 0); 
    $vat = round($vat, 0); 
    $totalMonCoVAT = round($totalMonCoVAT, 0);
    $phiDichVu = round($phiDichVu, 0); 
    $tongCuoiCung = round($tongCuoiCung, 0); 
    $tienThanhToanSauDB = round($tienThanhToanSauDB, 0);

} else {
    // KHÔNG CÓ MÓN: Chỉ tính phí bàn
    $vat = 0;
    $totalMonCoVAT = 0;
    $tongCuoiCung = $phiBan;
    $phiDichVu = 0;
    $totalMonChuaVAT = 0;
    $tienThanhToanSauDB = 0;
}

// ====== CASE 1: KHÔNG CÓ MÓN ======
if (empty($cart) || $totalMonCoVAT <= 0) { // Sửa điều kiện thành totalMonCoVAT
    try {
        $bookingId = $bookingModel->createBooking([
            'name' => $name,
            'phone' => $phone,
            'email' => $email,
            'soluongban' => $tables, // Sửa: Dùng soluongban để khớp Model
            'date' => $date,
            'time' => $time,
            'branch' => $branch,
            'notes' => $notes,
            'user_id' => $_SESSION['user_id'] ?? null,
            'total' => $tongCuoiCung, 
            'tien_thanh_toan_sau_db' => 0 // Tiền thanh toán sau bằng 0
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
            'paid' => true,
            'tien_thanh_toan_sau_db' => 0 // Thêm key này vào session
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
    'tien_thanh_toan_sau_db' => $tienThanhToanSauDB, // KEY QUAN TRỌNG ĐÃ ĐƯỢC THÊM VÀ TÍNH ĐÚNG
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