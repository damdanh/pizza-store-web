<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['pending_booking'])) {
    echo json_encode(['status' => 'expired']);
    exit;
}

$pending = $_SESSION['pending_booking'];

// ======= GỌI API =======
$apiUrl = "https://api.vietqr.io/v2/lookup";

$postData = [
    "accountNo" => "34251757",
    "bankCode"  => "ACB",
    "amount"    => $pending['amount'],
    "description" => $pending['order_code']
];

$ch = curl_init($apiUrl);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);

$response = curl_exec($ch);
curl_close($ch);

$data = json_decode($response, true);

// ======= CÓ GIAO DỊCH → LƯU DB =======
if (!empty($data['data'])) {

    require_once '../app/config/database.php';
    require_once '../app/model/BookingModel.php';
    
    $pdo = getConnection();
    $model = new BookingModel($pdo);
    
    // Nếu có user_id trong session, gán vào booking.
    $userId = $_SESSION['user_id'] ?? null;
    
    // LẤY GIÁ TRỊ TIỀN THANH TOÁN SAU MỚI TỪ SESSION PENDING
    $tienThanhToanSauDB = $pending['tien_thanh_toan_sau_db'] ?? 0;

    $id = $model->createBooking([
        'name'   => $pending['name'],
        'phone'  => $pending['phone'],
        'email'  => $pending['email'] ?? null,
        'soluongban' => $pending['tables'], 
        'booking_date'   => $pending['date'],
        'booking_time'   => $pending['time'],
        'branch' => $pending['branch'],
        'notes'  => $pending['notes'] ?? '',
        'user_id' => $userId, // TRUYỀN USER ID VÀO
        'total'   => $pending['amount'], // LƯU TỔNG TIỀN ĐÃ THANH TOÁN
        'tien_thanh_toan_sau_db' => $tienThanhToanSauDB // KEY MỚI: Tiền thanh toán sau (Tổng món - Tiền cọc)
    ]);
    

    foreach ($pending['cart'] as $i) {
        $model->addBookingItem($id, $i['id_mon'], $i['so_luong'], $i['gia']);
    }

    // ===== PHẦN MỚI: CẬP NHẬT TỔNG CHI TIÊU VÀ HẠNG THÀNH VIÊN (LOGIC MỚI: Dùng tổng tiền món) =====
    if ($userId) {
        require_once '../app/model/AccountModel.php';
        $accountModel = new AccountModel($pdo);
        
        // LẤY TỔNG GIÁ TRỊ MÓN ĂN (CÓ VAT) - TỔNG TIỀN MÓN THỰC TẾ
        $totalFoodValue = $pending['tien_mon_co_vat']; 
        
        $accountModel->capNhatTongChiTieu($userId, $totalFoodValue);
    }
    // ===============================================================

    $_SESSION['booking'] = [
        'id' => $id,
        'name' => $pending['name'],
        'phone' => $pending['phone'],
        'tables' => $pending['tables'], 
        'date' => $pending['date'],
        'time' => $pending['time'],
        'branch' => $pending['branch'],
        'total' => $pending['amount'],
        'paid' => true,
        'order_code' => $pending['order_code'],
        'tien_thanh_toan_sau_db' => $tienThanhToanSauDB // THÊM KEY MỚI VÀO SESSION BOOKING
    ];
    
    // Xóa session cart
    unset($_SESSION['pending_booking'], $_SESSION['qr_code'], $_SESSION['cart']); 
    
    echo json_encode(['status' => 'success']);
    exit;
}

echo json_encode(['status' => 'waiting']);