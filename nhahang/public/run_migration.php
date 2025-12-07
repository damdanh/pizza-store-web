<?php
// Public migration runner (use only locally).
// - Requires a secret key and POST submission to execute.
// - After running, DELETE this file to avoid exposure.

$SECRET_KEY = 'run-mig-2025-9f4e'; // <-- keep secret, delete file after use

// Simple helper to render HTML form
function render_form($message = '') {
    global $SECRET_KEY;
    echo "<!doctype html><html><head><meta charset=\"utf-8\"><title>Run Migration</title>
    <style>body{font-family:Segoe UI,Arial;margin:40px;background:#f7f7f8} .card{background:#fff;padding:20px;border-radius:8px;box-shadow:0 3px 8px rgba(0,0,0,0.06);max-width:720px} input[type=text]{width:100%;padding:8px;margin:8px 0} button{padding:8px 12px} .warn{background:#fff3cd;border:1px solid #ffeeba;padding:10px;margin-bottom:12px;border-radius:6px}</style>
    </head><body><div class=card>
    <h2>Run Migration: add is_hidden to mon_an</h2>";
    if ($message) echo "<div style=\"margin-bottom:12px;color:#333\">".htmlspecialchars($message)."</div>";
    echo "<div class=warn><strong>Warning:</strong> This script will ALTER your database. Run only on local dev or when you have backup. Delete this file after use.</div>
    <form method=\"post\"> 
      <label>Secret key</label>
      <input type=\"text\" name=\"key\" placeholder=\"Enter secret key\" required>
      <div style=\"margin-top:10px\"> 
        <button type=\"submit\">Run Migration (POST)</button>
      </div>
    </form>
    <hr>
    <div style=\"font-size:13px;color:#555;\">If you prefer CLI, run: <code>php \"c:\\xampp-1\\htdocs\\WD20302-PRO1014_N5(tri)\\nhahang\\database\\run_migration.php\"</code></div>
    </div></body></html>";
}

// Only accept POST to execute
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    render_form();
    exit;
}

$key = $_POST['key'] ?? '';
if ($key !== $SECRET_KEY) {
    render_form('Invalid secret key.');
    exit;
}

// Run migration
require_once __DIR__ . '/../app/config/database.php';
try {
    $pdo = getConnection();
    $stmt = $pdo->query("SHOW COLUMNS FROM `mon_an` LIKE 'is_hidden'");
    $exists = $stmt->fetch(PDO::FETCH_ASSOC) !== false;
    if ($exists) {
        echo "<p style=\"font-family:Segoe UI,Arial; margin:20px;\"><strong>Skipped:</strong> Cột 'is_hidden' đã tồn tại.</p>";
        echo "<p style=\"margin:20px;\">Hãy xóa file <code>nhahang/public/run_migration.php</code> sau khi hoàn tất.</p>";
        exit;
    }

    $sql = "ALTER TABLE `mon_an` ADD COLUMN `is_hidden` TINYINT(1) NOT NULL DEFAULT 0 AFTER `trang_thai`";
    $pdo->exec($sql);
    echo "<p style=\"font-family:Segoe UI,Arial; margin:20px; color:green\"><strong>Success:</strong> Đã thêm cột 'is_hidden' vào bảng 'mon_an'.</p>";
    echo "<p style=\"margin:20px;\">Hãy xóa file <code>nhahang/public/run_migration.php</code> để bảo mật.</p>";
} catch (PDOException $e) {
    echo "<p style=\"font-family:Segoe UI,Arial; margin:20px; color:#c00\"><strong>Error:</strong> " . htmlspecialchars($e->getMessage()) . "</p>";
    echo "<p style=\"margin:20px;\">Bạn có thể chạy SQL thủ công trong phpMyAdmin nếu cần.</p>";
}
