<?php
// app/Utils/EmailService.php

// KẾT NỐI PHPMailer
// Đường dẫn: từ app/Utils/ đi sang app/libs/
require __DIR__ . '/../libs/Exception.php';
require __DIR__ . '/../libs/PHPMailer.php';
require __DIR__ . '/../libs/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

class EmailService {
    
    /**
     * Gửi email qua SMTP (Ví dụ sử dụng Gmail/App Password)
     * * @param string $recipientEmail Email người nhận
     * @param string $subject Tiêu đề email
     * @param string $body Nội dung email (HTML)
     * @return bool Trả về true nếu gửi thành công, false nếu thất bại.
     */
    public static function sendSMTP(string $recipientEmail, string $subject, string $body): bool {
        
        $mail = new PHPMailer(true);
        
        try {
            // Cấu hình Server SMTP
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com'; // Máy chủ SMTP của Gmail
            $mail->SMTPAuth   = true;
            // !!! QUAN TRỌNG: THAY BẰNG THÔNG TIN CỦA BẠN !!!
            $mail->Username   = 'tanloccute0310@gmail.com'; // Email dùng để gửi đi
            $mail->Password   = 'sdgg cagb dbyp ybvy';          // Mật khẩu ứng dụng (App Password) của Gmail
            // !!! QUAN TRỌNG: THAY BẰNG THÔNG TIN CỦA BẠN !!!
            
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; // Sử dụng SMTPS (SSL/TLS)
            $mail->Port       = 465;                         // Port cho SMTPS
            
            $mail->setFrom('no-reply@yourdomain.com', 'N5 Restaurant');
            $mail->addAddress($recipientEmail); 
            $mail->CharSet = 'UTF-8'; 
            
            // Nội dung
            $mail->isHTML(true); 
            $mail->Subject = $subject;
            $mail->Body    = $body;

            $mail->send();
            error_log("✅ Email đặt lại mật khẩu đã được gửi qua SMTP đến: " . $recipientEmail);
            return true;
            
        } catch (Exception $e) {
            error_log("❌ Lỗi gửi email bằng PHPMailer: " . $mail->ErrorInfo);
            return false;
        }
    }
}