<?php
session_start();
require 'vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Function to send OTP
function sendOTP($email) {
    $otp = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
    $_SESSION['otp'] = $otp;
    $_SESSION['otp_time'] = time();
    
    $mail = new PHPMailer(true);
    
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'kuraidiner@gmail.com'; // Your Gmail
        $mail->Password = 'kixukurpwkskeomv'; // Your Gmail App Password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;
        
        $mail->setFrom('kuraidiner@gmail.com', 'EEMS System');
        $mail->addAddress($email);
        
        $mail->isHTML(true);
        $mail->Subject = 'EEMS Registration OTP';
        $mail->Body = "
            <div style='font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto;'>
                <h2 style='color: #710000;'>EVSU-OC EEMS Email Verification</h2>
                <p>Your OTP for EVSU-OC EEMS registration is:</p>
                <h1 style='letter-spacing: 5px; color: #710000; text-align: center;'>$otp</h1>
                <p>This OTP will expire in 5 minutes.</p>
                <p>If you didn't request this OTP, please ignore this email.</p>
                <hr>
                <p style='font-size: 12px; color: #666;'>This is an automated message, please do not reply.</p>
            </div>
        ";
        
        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}

// Handle AJAX requests
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        if ($_POST['action'] === 'send_otp' && isset($_POST['email'])) {
            $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
            if (sendOTP($email)) {
                echo 'success';
            } else {
                echo 'failed';
            }
            exit;
        } elseif ($_POST['action'] === 'verify_otp' && isset($_POST['otp'])) {
            $entered_otp = $_POST['otp'];
            $stored_otp = isset($_SESSION['otp']) ? $_SESSION['otp'] : '';
            $otp_time = isset($_SESSION['otp_time']) ? $_SESSION['otp_time'] : 0;
            
            if (time() - $otp_time > 300) {
                echo 'expired';
                exit;
            }
            
            if ($entered_otp === $stored_otp) {
                $_SESSION['email_verified'] = true;
                echo 'success';
            } else {
                echo 'invalid';
            }
            exit;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EEMS - Registration</title>
    <?php require 'utils/styles.php'; ?>
    <style>
        .otp-section {
            display: none;
            margin-top: 20px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .btn {
            margin-right: 5px;
        }
    </style>
</head>
<body>
    <?php require 'utils/header.php'; ?>
    <div class="content">
        <div class="container">
            <div class="col-md-6 col-md-offset-3">
                <form action="subusn_process.php" method="POST" id="registrationForm">
                    <div class="form-group">
                        <label for="usn">Student ID:</label>
                        <input type="text" id="usn" name="usn" class="form-control" required 
                               pattern="[0-9]{4}-[0-9]{5}" title="Format: 0000-00000">
                    </div>
                    
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" class="form-control" required>
                        <button type="button" class="btn btn-info mt-2" onclick="sendOTP()">
                            <i class="fas fa-paper-plane"></i> Send OTP
                        </button>
                    </div>

                    <div class="form-group otp-section" id="otpSection">
                        <label for="otp">Enter OTP:</label>
                        <input type="text" id="otp" name="otp" class="form-control" maxlength="6">
                        <button type="button" class="btn btn-success mt-2" onclick="verifyOTP()">
                            <i class="fas fa-check"></i> Verify OTP
                        </button>
                    </div>

                    <div class="form-group">
                        <a class="btn btn-default" href="index.php">
                            <span class="glyphicon glyphicon-circle-arrow-left"></span> Back
                        </a>
                        <button type="submit" name="register_usn" class="btn btn-primary" id="submitBtn" disabled>
                            Submit ID
                        </button>
                    </div>
                    <p>Not Registered? <a href="register.php">Register Now</a></p>
                    <?php
                    if (isset($_POST['event_name']) && isset($_POST['event_id'])) {
                        $event = htmlspecialchars($_POST['event_name']);
                        $eventID = htmlspecialchars($_POST['event_id']);
                        echo "<input type='hidden' name='event_name' value='$event'>";
                        echo "<input type='hidden' name='event_id' value='$eventID'>";
                    }
                    ?>
                </form>
            </div>
        </div>
    </div>
    
    <?php require 'utils/footer.php'; ?>
    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function sendOTP() {
            const email = document.getElementById('email').value;
            if (!email) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Please enter your email address'
                });
                return;
            }

            const sendButton = event.target;
            sendButton.disabled = true;
            sendButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Sending...';

            fetch(window.location.href, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'action=send_otp&email=' + encodeURIComponent(email)
            })
            .then(response => response.text())
            .then(data => {
                if (data.trim() === 'success') {
                    document.getElementById('otpSection').style.display = 'block';
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'OTP has been sent to your email'
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Failed to send OTP. Please try again.'
                    });
                }
            })
            .catch(error => {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Error: ' + error
                });
            })
            .finally(() => {
                sendButton.disabled = false;
                sendButton.innerHTML = '<i class="fas fa-paper-plane"></i> Send OTP';
            });
        }

        function verifyOTP() {
            const otp = document.getElementById('otp').value;
            if (!otp) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Please enter the OTP'
                });
                return;
            }

            fetch(window.location.href, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'action=verify_otp&otp=' + encodeURIComponent(otp)
            })
            .then(response => response.text())
            .then(data => {
                if (data.trim() === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'Email verified successfully!'
                    });
                    document.getElementById('submitBtn').disabled = false;
                    document.getElementById('email').readOnly = true;
                    document.getElementById('otpSection').style.display = 'none';
                } else if (data.trim() === 'expired') {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'OTP has expired. Please request a new one.'
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Invalid OTP. Please try again.'
                    });
                }
            })
            .catch(error => {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Error: ' + error
                });
            });
        }

        // Format Student ID input
        document.getElementById('usn').addEventListener('input', function(e) {
            let value = this.value.replace(/\D/g, '');
            if (value.length >= 4) {
                value = value.substr(0, 4) + '-' + value.substr(4, 5);
            }
            this.value = value;
        });

        function scrollToBottomSmooth() {
            const targetScroll = document.body.scrollHeight;
            const duration = 400; 
            const delay = 100; 

            setTimeout(() => {
                const start = window.pageYOffset;
                const distance = targetScroll - start;
                let startTime = null;

                function animation(currentTime) {
                    if (startTime === null) startTime = currentTime;
                    const timeElapsed = currentTime - startTime;
                    const scrollAmount = easeInOutQuad(timeElapsed, start, distance, duration);
                    window.scrollTo(0, scrollAmount);
                    if (timeElapsed < duration) {
                        requestAnimationFrame(animation);
                    }
                }

                function easeInOutQuad(t, b, c, d) {
                    t /= d / 2;
                    if (t < 1) return c / 2 * t * t + b;
                    t--;
                    return -c / 2 * (t * (t - 2) - 1) + b;
                }

                requestAnimationFrame(animation);
            }, delay);
        }

        window.onload = scrollToBottomSmooth;
    </script>
</body>
</html>