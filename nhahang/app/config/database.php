
<?php

define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', ''); 
// Update this to match the actual database name you imported.
// Common names: 'wd20302_n5_local' or 'wd20302_n5_local (2)'
define('DB_NAME', 'wd20302_n5_local'); 
/**
 * Hàm khởi tạo và trả về đối tượng kết nối PDO
 * @return PDO
 */
function getConnection() {
   
    $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4";
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, 
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,     
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];
    
    try {
        $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
        return $pdo;
    } catch (\PDOException $e) {
        // Nếu không kết nối được bằng tên mặc định, thử các tên khả dĩ khác (tạm thời)
        $alt_names = [
            'wd20302_n5_local(2)',
            'wd20302_n5_local (2)'
        ];
        foreach ($alt_names as $alt) {
            try {
                $alt_dsn = "mysql:host=" . DB_HOST . ";dbname=" . $alt . ";charset=utf8mb4";
                $pdo = new PDO($alt_dsn, DB_USER, DB_PASS, $options);
                return $pdo;
            } catch (\PDOException $ignore) {
                // tiếp tục thử tên tiếp theo
            }
        }

        die("Lỗi kết nối CSDL: " . $e->getMessage() . ".\nHãy kiểm tra tên database trong `app/config/database.php` và đảm bảo bạn đã import file SQL vào MySQL.");
    }
}
?>