<?php
session_start();

if (isset($_POST['email']) && isset($_POST['otp'])) {
    $email = $_POST['email'];
    $entered_otp = $_POST['otp'];
    
    if (isset($_SESSION['otp']) && 
        isset($_SESSION['otp_email']) && 
        isset($_SESSION['otp_time']) && 
        $_SESSION['otp_email'] === $email && 
        time() - $_SESSION['otp_time'] <= 600) {
        
        $stored_otp = trim((string)$_SESSION['otp']);
        $entered_otp = trim((string)$entered_otp);
        
        if ($stored_otp === $entered_otp) {
            $_SESSION['email_verified'] = $email;
            echo 'success';
        } else {
            echo 'invalid';
        }
    } else {
        echo 'expired';
    }
} else {
    echo 'invalid request';
}
?>