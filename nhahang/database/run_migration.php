<?php
// run_migration.php
// Chạy migration an toàn để thêm cột is_hidden vào bảng mon_an nếu chưa tồn tại.
// Cách dùng:
// - Trình duyệt: http://localhost/WD20302-PRO1014_N5/nhahang/database/run_migration.php
// - CLI (PowerShell): php "c:\xampp-1\htdocs\WD20302-PRO1014_N5(tri)\nhahang\database\run_migration.php"

require_once __DIR__ . '/../../app/config/database.php';

try {
    $pdo = getConnection();

    // Kiểm tra xem bảng mon_an có cột is_hidden không
    $stmt = $pdo->query("SHOW COLUMNS FROM `mon_an` LIKE 'is_hidden'");
    $exists = $stmt->fetch(PDO::FETCH_ASSOC) !== false;

    if ($exists) {
        echo "Cột 'is_hidden' đã tồn tại trong bảng 'mon_an'. Không cần thay đổi.\n";
        exit(0);
    }

    // Thực hiện ALTER TABLE để thêm cột
    $sql = "ALTER TABLE `mon_an` ADD COLUMN `is_hidden` TINYINT(1) NOT NULL DEFAULT 0 AFTER `trang_thai`";
    $pdo->exec($sql);

    echo "Đã thêm cột 'is_hidden' vào bảng 'mon_an' thành công.\n";
    echo "Bạn có thể refresh trang admin để thử tính năng ẩn/hiện món.\n";
    exit(0);
} catch (PDOException $e) {
    echo "Lỗi khi chạy migration: " . $e->getMessage() . "\n";
    exit(1);
}
