<?php
// app/Utils/EmailSender.php (Môi trường PHÁT TRIỂN/GIẢ ĐỊNH)

class EmailSender {
    
    public static function sendEmail(string $recipientEmail, string $subject, string $body): bool {
        
       
        if (preg_match('/<strong>(\w+)<\/strong>/', $body, $matches)) {
            $code = $matches[1];
        } else {
            $code = 'N/A';
        }
        
        
        error_log("\n--- MOCK EMAIL FORGOT PASSWORD ---\n" .
                  "TO: $recipientEmail\n" .
                  "CODE TEST: $code\n" .
                  "----------------------------------\n");
                  

        $_SESSION['MOCK_CODE'] = $code; 
        
        return true; 
    }
}
?>