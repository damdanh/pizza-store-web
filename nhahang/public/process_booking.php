<?php
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../app/config/database.php';   // ĐÃ ĐÚNG ĐƯỜNG DẪN

try {
    $pdo = getConnection();

    $name   = trim($_POST['name'] ?? '');
    $phone  = trim($_POST['phone'] ?? '');
    $email  = trim($_POST['email'] ?? '');
    $people = (int)($_POST['people'] ?? 2);
    $date   = $_POST['date'] ?? '2025-12-15';
    $time   = $_POST['time'] ?? '19:00';
    $branch = $_POST['branch'] ?? 'Pizza & Pasta - 24 Nguyễn Thị Nghĩa';
    $notes  = trim($_POST['notes'] ?? '');

    if (empty($name) || empty($phone)) {
        die('Vui lòng nhập tên và số điện thoại');
    }

    // ĐÃ SỬA DÒNG NÀY – CHỈ CÒN 8 CỘT TƯƠNG ỨNG 8 DẤU ?
    $sql = "INSERT INTO bookings 
            (name, phone, email, people, booking_date, booking_time, branch, notes, created_at) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([$name, $phone, $email, $people, $date, $time, $branch, $notes]);

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

    header('Location: ../app/view/xacnhandatban.php');
exit;

} catch (Exception $e) {
    die('Lỗi: ' . $e->getMessage());
}
?>