<?php
<<<<<<< HEAD
session_start();
require_once '../app/config/database.php';
require_once '../app/model/BookingModel.php';


if (isset($_SESSION['force_confirm_processed'])) {
    header("Location: /WD20302-PRO1014_N5/nhahang/public/xac-nhan");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_SESSION['pending_booking'])) {
    header("Location: /WD20302-PRO1014_N5/nhahang/public/dat-ban");
=======
/**
 * File: public/force_confirm.php
 * Hợp nhất logic xác nhận thanh toán và lưu booking cuối cùng vào DB.
 * Tích hợp logic cập nhật chi tiêu thành viên và theo dõi ID booking tạm thời.
 */

session_start();
// Bật hiển thị lỗi chi tiết (giống trong file gốc)
error_reporting(E_ALL); 
ini_set('display_errors', 1);

// Yêu cầu các file cần thiết
require_once '../app/config/database.php';
require_once '../app/model/BookingModel.php';
// Yêu cầu thêm AccountModel cho logic cập nhật chi tiêu (từ file gốc)
require_once '../app/model/AccountModel.php'; 
// ProductModel không được sử dụng rõ ràng trong cả hai file, nên ta loại bỏ để giữ code sạch

// Kiểm tra cờ xử lý trước để tránh chạy lại (từ file gốc)
if (isset($_SESSION['force_confirm_processed'])) {
    // Chuyển hướng đến trang đang chờ xử lý (từ file (1).php)
    header("Location: dang-cho-xu-ly"); 
    exit;
}

// Kiểm tra điều kiện POST và pending_booking (từ file gốc)
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_SESSION['pending_booking'])) {
    // Nếu không có dữ liệu, chuyển hướng về trang đặt bàn
    header("Location: dat-ban");
>>>>>>> feat_Lộc
    exit;
}

$pending = $_SESSION['pending_booking'];

try {
<<<<<<< HEAD
    $pdo = getConnection();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $bookingModel = new BookingModel($pdo);
    
    // Nếu có user_id trong session, gán vào booking.
    $userId = $_SESSION['user_id'] ?? null;

    // ====== 1. TẠO BOOKING CHÍNH THỨC ======
    $bookingId = $bookingModel->createBooking([
        'name'    => $pending['name'],
        'phone'   => $pending['phone'],
        'email'   => $pending['email'] ?? null,
        'soluongban'  => $pending['tables'], 
        'date'    => $pending['date'],
        'time'    => $pending['time'],
        'branch'  => $pending['branch'],
        'notes'   => $pending['notes'] ?? '',
        'user_id' => $userId, // TRUYỀN USER ID VÀO
        'total'   => $pending['amount'] // LƯU TỔNG TIỀN ĐÃ THANH TOÁN (PHÍ BOOKING + DỊCH VỤ)
    ]);
=======
    // Thiết lập kết nối PDO (từ file gốc)
    $pdo = getConnection();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Khởi tạo Model
    // Lưu ý: Phiên bản BookingModel hợp nhất không cần tham số $pdo trong constructor
    $bookingModel = new BookingModel(); 
    $accountModel = new AccountModel($pdo); 
    
    $userId = $_SESSION['user_id'] ?? null;
    
    // LẤY GIÁ TRỊ TIỀN THANH TOÁN SAU MỚI TỪ SESSION PENDING (đã được fix >= 0 trong process_booking.php)
    $tienThanhToanSauDB = $pending['tien_thanh_toan_sau_db'] ?? 0;

    // ====== 1. TẠO BOOKING CHÍNH THỨC ======
    
    // Sử dụng cấu trúc dữ liệu đầy đủ nhất cho createBooking (từ cả hai file)
    $dataToCreate = [
        'name'    => $pending['name'],
        'phone'   => $pending['phone'],
        'email'   => $pending['email'] ?? null,
        'soluongban'  => $pending['tables'] ?? null, 
        'booking_date'    => $pending['date'],
        'booking_time'    => $pending['time'],
        'branch'  => $pending['branch'],
        'notes'   => $pending['notes'] ?? '',
        'id_khach_hang' => $userId, // Đổi user_id thành id_khach_hang
        'total'   => $pending['amount'], 
        'tien_thanh_toan_sau' => $tienThanhToanSauDB, // Tên key phải khớp với tham số trong Model
        'status' => 0 // Mặc định là đơn chờ xử lý
    ];
    
    // Gọi Model tạo booking
    $bookingId = $bookingModel->createBooking($dataToCreate);
>>>>>>> feat_Lộc

    if (!$bookingId) {
        throw new Exception("Không thể tạo booking trong database");
    }

    error_log("✅ Đã tạo booking ID: {$bookingId}");
<<<<<<< HEAD

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
=======
    
    // ====== 2. THÊM CÁC MÓN ĂN (Sử dụng logic kiểm tra chi tiết của file gốc) ======
    $itemsAdded = 0;

    if (isset($pending['cart']) && is_array($pending['cart'])) {
        foreach ($pending['cart'] as $item) {
            // Kiểm tra tính hợp lệ của dữ liệu món ăn
            if (!isset($item['id_mon']) || !isset($item['so_luong']) || !isset($item['gia']) ||
                !is_numeric($item['so_luong']) || !is_numeric($item['gia'])
            ) {
                error_log("⚠️ Item có dữ liệu không hợp lệ và đã bị bỏ qua: " . json_encode($item));
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
                error_log("⚠️ Không thêm được item vào DB: " . json_encode($item));
            }
>>>>>>> feat_Lộc
        }
    }

    error_log("✅ Đã thêm {$itemsAdded} món vào booking {$bookingId}");

<<<<<<< HEAD
    // ====== 3. CẬP NHẬT TỔNG CHI TIÊU & HẠNG THÀNH VIÊN (LOGIC MỚI: Dùng tổng tiền món) ======
    if ($userId) {
        require_once '../app/model/AccountModel.php';
        $accountModel = new AccountModel($pdo);
        
        // LẤY TỔNG GIÁ TRỊ MÓN ĂN (CÓ VAT) - THEO YÊU CẦU MỚI
        $totalFoodValue = $pending['tien_mon_co_vat']; 
        
        // Thực hiện cập nhật
=======
    // ====== 3. CẬP NHẬT TỔNG CHI TIÊU & HẠNG THÀNH VIÊN (Logic từ file gốc) ======
    if ($userId && isset($pending['tien_mon_co_vat'])) {
        $totalFoodValue = $pending['tien_mon_co_vat']; 
        
>>>>>>> feat_Lộc
        $accountModel->capNhatTongChiTieu($userId, $totalFoodValue);
        error_log("✅ Cập nhật chi tiêu cho user {$userId} với TỔNG GIÁ TRỊ MÓN ĂN: {$totalFoodValue}.");
    }
    // =====================================================================
    
<<<<<<< HEAD
    // ====== 4. LƯU SESSION THÀNH CÔNG ======
    $_SESSION['booking'] = [
        'id'         => $bookingId,
=======
    // ====== 4. LƯU SESSION THÀNH CÔNG (Sử dụng các trường dữ liệu chi tiết của file gốc) ======
    $_SESSION['booking'] = [
        'id'         => $bookingId,
        'order_code' => $pending['order_code'],
>>>>>>> feat_Lộc
        'name'       => $pending['name'],
        'phone'      => $pending['phone'],
        'email'      => $pending['email'] ?? '',
        'tables'     => $pending['tables'],
        'date'       => $pending['date'],
        'time'       => $pending['time'],
        'branch'     => $pending['branch'],
        'notes'      => $pending['notes'] ?? '',
        'cart'       => $pending['cart'],
<<<<<<< HEAD
        'tien_mon_chua_vat' => $pending['tien_mon_chua_vat'],
        'vat'        => $pending['vat'],
        'tien_mon_co_vat' => $pending['tien_mon_co_vat'],
        'phi_ban'    => $pending['phi_ban'],
        'phi_dich_vu' => $pending['phi_dich_vu'],
        'total'      => $pending['amount'],
        'paid'       => true,
        'order_code' => $pending['order_code']
    ];

    // ====== 5. XÓA DỮ LIỆU TẠM ======
    $_SESSION['force_confirm_processed'] = time();
=======
        'tien_mon_chua_vat' => $pending['tien_mon_chua_vat'] ?? 0,
        'vat'        => $pending['vat'] ?? 0,
        'tien_mon_co_vat' => $pending['tien_mon_co_vat'] ?? 0,
        'phi_ban'    => $pending['phi_ban'] ?? 0,
        'phi_dich_vu' => $pending['phi_dich_vu'] ?? 0,
        'total'      => $pending['amount'],
        'paid'       => true,
        'tien_thanh_toan_sau_db' => $tienThanhToanSauDB // Key quan trọng (giá trị đã được fix >= 0)
    ];

    // *** QUAN TRỌNG: LƯU ID ĐỂ TRANG DANG-CHO-XU-LY ĐỌC *** (Từ file (1).php)
    $_SESSION['checking_booking_id'] = $bookingId;

    // ====== 5. XÓA DỮ LIỆU TẠM ======
    $_SESSION['force_confirm_processed'] = time(); // Dùng timestamp (từ file gốc)
>>>>>>> feat_Lộc
    unset($_SESSION['pending_booking']);
    unset($_SESSION['qr_code']);
    unset($_SESSION['cart']);

    error_log("✅ Hoàn thành xử lý booking {$bookingId}");

<<<<<<< HEAD
    // ====== 6. CHUYỂN VỀ TRANG XÁC NHẬN ======
    header("Location: /WD20302-PRO1014_N5/nhahang/public/xac-nhan");
    exit;

} catch (PDOException $e) {
    error_log("❌ PDO Error: " . $e->getMessage());
    error_log("Stack trace: " . $e->getTraceAsString());
    
=======
    // ====== 6. CHUYỂN VỀ TRANG ĐANG CHỜ XỬ LÝ ====== (Từ file (1).php)
    header("Location: dang-cho-xu-ly");
    exit;

} catch (PDOException $e) {
    // Xử lý lỗi PDO chi tiết (từ file gốc)
    error_log("❌ PDO Error: " . $e->getMessage());
>>>>>>> feat_Lộc
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
<<<<<<< HEAD
    
    header("Location: /WD20302-PRO1014_N5/nhahang/public/dat-ban?error=db");
    exit;

} catch (Exception $e) {
    error_log("❌ General Error: " . $e->getMessage());
    
=======
    header("Location: dat-ban?error=db");
    exit;

} catch (Exception $e) {
    // Xử lý lỗi chung (từ file gốc)
    error_log("❌ General Error: " . $e->getMessage());
>>>>>>> feat_Lộc
    if (ini_get('display_errors')) {
        die("<pre style='background:#fff3cd;padding:20px;border:2px solid #ffc107;border-radius:8px;'>
            <h3>⚠️ Lỗi xử lý</h3>
            <p>" . htmlspecialchars($e->getMessage()) . "</p>
        </pre>");
    }
<<<<<<< HEAD
    
    header("Location: /WD20302-PRO1014_N5/nhahang/public/dat-ban?error=1");
=======
    header("Location: dat-ban?error=1");
>>>>>>> feat_Lộc
    exit;
}