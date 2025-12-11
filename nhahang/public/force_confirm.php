<?php
session_start();
require_once '../app/config/database.php';
require_once '../app/model/BookingModel.php';


if (isset($_SESSION['force_confirm_processed'])) {
    header("Location: /WD20302-PRO1014_N5/nhahang/public/xac-nhan");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_SESSION['pending_booking'])) {
    header("Location: /WD20302-PRO1014_N5/nhahang/public/dat-ban");
    exit;
}

$pending = $_SESSION['pending_booking'];

try {
    $pdo = getConnection();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $bookingModel = new BookingModel($pdo);
    
    // Nếu có user_id trong session, gán vào booking.
    $userId = $_SESSION['user_id'] ?? null;

    // LẤY GIÁ TRỊ TIỀN THANH TOÁN SAU MỚI TỪ SESSION PENDING
    $tienThanhToanSauDB = $pending['tien_thanh_toan_sau_db'] ?? 0;

    // ====== 1. TẠO BOOKING CHÍNH THỨC ======
    $bookingId = $bookingModel->createBooking([
        'name'    => $pending['name'],
        'phone'   => $pending['phone'],
        'email'   => $pending['email'] ?? null,
        'soluongban'  => $pending['tables'] ?? null, // Lưu số bàn
        'date'    => $pending['date'],
        'time'    => $pending['time'],
        'branch'  => $pending['branch'],
        'notes'   => $pending['notes'] ?? '',
        'user_id' => $userId, // TRUYỀN USER ID VÀO
        'total'   => $pending['amount'], // LƯU TỔNG TIỀN ĐÃ THANH TOÁN (PHÍ BOOKING + DỊCH VỤ)
        'tien_thanh_toan_sau_db' => $tienThanhToanSauDB // KEY MỚI: Tiền thanh toán sau (Tổng món - Tiền cọc)
    ]);

    if (!$bookingId) {
        throw new Exception("Không thể tạo booking trong database");
    }

    error_log("✅ Đã tạo booking ID: {$bookingId}");

    // ====== 2. THÊM CÁC MÓN ĂN ======
    $itemsAdded = 0;

    foreach ($pending['cart'] as $item) {
        if (!isset($item['id_mon']) || !isset($item['so_luong']) || !isset($item['gia'])) {
            error_log("⚠️ Item thiếu data: " . json_encode($item));
            continue;
        }

        if (!is_numeric($item['so_luong']) || !is_numeric($item['gia'])) {
            error_log("⚠️ Item có giá trị không hợp lệ: " . json_encode($item));
            continue;
        }

        $success = $bookingModel->addBookingItem(
            $bookingId,
            (int)$item['id_mon'],
            (int)$item['so_luong'],
            (float)$item['gia']
        );

        if ($success) {
            $itemsAdded++;
        } else {
            error_log("⚠️ Không thêm được item: " . json_encode($item));
        }
    }

    error_log("✅ Đã thêm {$itemsAdded} món vào booking {$bookingId}");

    // ====== 3. CẬP NHẬT TỔNG CHI TIÊU & HẠNG THÀNH VIÊN (LOGIC MỚI: Dùng tổng tiền món) ======
    if ($userId) {
        require_once '../app/model/AccountModel.php';
        $accountModel = new AccountModel($pdo);
        
        // LẤY TỔNG GIÁ TRỊ MÓN ĂN (CÓ VAT) - TỔNG TIỀN MÓN THỰC TẾ
        $totalFoodValue = $pending['tien_mon_co_vat']; 
        
        // Thực hiện cập nhật
        $accountModel->capNhatTongChiTieu($userId, $totalFoodValue);
        error_log("✅ Cập nhật chi tiêu cho user {$userId} với TỔNG GIÁ TRỊ MÓN ĂN: {$totalFoodValue}.");
    }
    // =====================================================================
    
    // ====== 4. LƯU SESSION THÀNH CÔNG ======
    $_SESSION['booking'] = [
        'id'         => $bookingId,
        'name'       => $pending['name'],
        'phone'      => $pending['phone'],
        'email'      => $pending['email'] ?? '',
        'tables'     => $pending['tables'],
        'date'       => $pending['date'],
        'time'       => $pending['time'],
        'branch'     => $pending['branch'],
        'notes'      => $pending['notes'] ?? '',
        'cart'       => $pending['cart'],
        'tien_mon_chua_vat' => $pending['tien_mon_chua_vat'],
        'vat'        => $pending['vat'],
        'tien_mon_co_vat' => $pending['tien_mon_co_vat'],
        'phi_ban'    => $pending['phi_ban'],
        'phi_dich_vu' => $pending['phi_dich_vu'],
        'total'      => $pending['amount'],
        'paid'       => true,
        'order_code' => $pending['order_code'],
        'tien_thanh_toan_sau_db' => $tienThanhToanSauDB // THÊM KEY MỚI VÀO SESSION BOOKING
    ];

    // ====== 5. XÓA DỮ LIỆU TẠM ======
    $_SESSION['force_confirm_processed'] = time();
    unset($_SESSION['pending_booking']);
    unset($_SESSION['qr_code']);
    unset($_SESSION['cart']);

    error_log("✅ Hoàn thành xử lý booking {$bookingId}");

    // ====== 6. CHUYỂN VỀ TRANG XÁC NHẬN ======
    header("Location: /WD20302-PRO1014_N5/nhahang/public/xac-nhan");
    exit;

} catch (PDOException $e) {
    error_log("❌ PDO Error: " . $e->getMessage());
    error_log("Stack trace: " . $e->getTraceAsString());
    
    if (ini_get('display_errors')) {
        die("<pre style='background:#f8d7da;padding:20px;border:2px solid #dc3545;border-radius:8px;'>
            <h3>❌ Lỗi Database</h3>
            <p><strong>Message:</strong> " . htmlspecialchars($e->getMessage()) . "</p>
            <p><strong>File:</strong> " . $e->getFile() . " (Line " . $e->getLine() . ")</p>
            <hr>
            <p><strong>Pending Data:</strong></p>
            <pre>" . print_r($pending, true) . "</pre>
        </pre>");
    }
    
    header("Location: /WD20302-PRO1014_N5/nhahang/public/dat-ban?error=db");
    exit;

} catch (Exception $e) {
    error_log("❌ General Error: " . $e->getMessage());
    
    if (ini_get('display_errors')) {
        die("<pre style='background:#fff3cd;padding:20px;border:2px solid #ffc107;border-radius:8px;'>
            <h3>⚠️ Lỗi xử lý</h3>
            <p>" . htmlspecialchars($e->getMessage()) . "</p>
        </pre>");
    }
    
    header("Location: /WD20302-PRO1014_N5/nhahang/public/dat-ban?error=1");
    exit;
}