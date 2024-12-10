<?php
session_start();
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if (isset($_POST['email'])) {
    $email = $_POST['email'];
    
    $otp = str_pad(strval(mt_rand(0, 999999)), 6, '0', STR_PAD_LEFT);
    
    $_SESSION['otp'] = $otp;
    $_SESSION['otp_email'] = $email;
    $_SESSION['otp_time'] = time();

    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'kuraidiner@gmail.com'; 
        $mail->Password = 'kixukurpwkskeomv'; 
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Recipients
        $mail->setFrom('kuraidiner@gmail.com', 'Event Management System');
        $mail->addAddress($email);

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Email Verification OTP';
        $mail->Body = "
            <html>
            <body style='font-family: Arial, sans-serif;'>
                <div style='background-color: #f5f5f5; padding: 20px;'>
                    <h2 style='color: #710000;'>Email Verification</h2>
                    <p>Your OTP for email verification is: <strong style='font-size: 24px; color: #710000;'>{$otp}</strong></p>
                    <p>This OTP will expire in 10 minutes.</p>
                    <br>
                    <p>Best regards,</p>
                    <p>Event Management Team</p>
                </div>
            </body>
            </html>
        ";

        $mail->send();
        echo 'success';
    } catch (Exception $e) {
        error_log("Mailer Error: " . $mail->ErrorInfo);
        echo "Error sending email: {$mail->ErrorInfo}";
    }
} else {
    echo 'Email not provided';
}
?>