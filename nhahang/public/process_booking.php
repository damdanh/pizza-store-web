<?php
session_start();
require_once '../app/config/database.php';
require_once '../app/model/BookingModel.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die("Yêu cầu không hợp lệ.");
}

try {
    $pdo = getConnection();
    $bookingModel = new BookingModel($pdo);

    $people = (int)($_POST['people'] ?? 1);
    $name   = trim($_POST['name'] ?? '');
    $phone  = trim($_POST['phone'] ?? '');
    $email  = trim($_POST['email'] ?? '');
    $date   = $_POST['date'] ?? date('Y-m-d');
    $time   = $_POST['time'] ?? '19:00:00';
    $branch = $_POST['branch'] ?? '';
    $notes  = trim($_POST['notes'] ?? '');
    $cart   = $_SESSION['cart'] ?? [];

    if (empty($name) || empty($phone)) {
        die("Vui lòng nhập đầy đủ thông tin!");
    }

    $bookingId = $bookingModel->createBooking([
        'name'   => $name,
        'phone'  => $phone,
        'email'  => $email,
        'people' => $people,
        'date'   => $date,
        'time'   => $time,
        'branch' => $branch,
        'notes'  => $notes
    ]);

    $total = 0;

    foreach ($cart as $item) {

        if (empty($item['id_mon'])) {
            continue;
        }

        $bookingModel->addBookingItem(
            $bookingId,
            (int)$item['id_mon'],
            (int)$item['so_luong'],
            (float)$item['gia']
        );

        $total += $item['gia'] * $item['so_luong'];
    }

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
}
