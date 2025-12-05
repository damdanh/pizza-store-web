<?php
session_start();
require_once __DIR__ . '/../app/config/database.php';

try {
    $pdo = getConnection();

    $name   = trim($_POST['name'] ?? '');
    $phone  = trim($_POST['phone'] ?? '');
    $email  = trim($_POST['email'] ?? '');
    $people = (int)($_POST['people'] ?? 1);
    $date   = $_POST['date'] ?? '';
    $time   = $_POST['time'] ?? '';
    $branch = $_POST['branch'] ?? '';
    $notes  = trim($_POST['notes'] ?? '');

    if ($name === '' || $phone === '') {
        die("Vui lòng nhập đầy đủ thông tin bắt buộc.");
    }

    $stmt = $pdo->prepare("
        INSERT INTO bookings (name, phone, email, people, booking_date, booking_time, branch, notes, created_at)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())
    ");

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

    header("Location: /WD20302-PRO1014_N5/nhahang/public/xac-nhan");
    exit;

} catch (Exception $e) {
    die("Lỗi: " . $e->getMessage());
}
