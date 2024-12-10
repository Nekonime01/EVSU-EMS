<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>
<!DOCTYPE HTML>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Register (EEMS)</title>
    <?php require 'utils/styles.php'; ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        .register-wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 40px 20px;
        }

        .register-container {
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 600px;
            margin: auto;
        }

        .register-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .register-header h1 {
            color: #710000;
            font-size: 32px;
            text-transform: uppercase;
            letter-spacing: 2px;
            text-shadow: 2px 2px yellow;
            margin-bottom: 10px;
        }

        .form-group {
            margin-bottom: 20px;
            position: relative;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #710000;
            font-weight: bold;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .form-group input,
        .form-group select {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #ddd;
            border-radius: 5px;
            transition: all 0.3s ease;
            font-size: 15px;
            box-sizing: border-box;
        }

        .form-group input:focus,
        .form-group select:focus {
            border-color: #710000;
            box-shadow: 0 0 0 3px rgba(113, 0, 0, 0.1);
            outline: none;
        }

        .form-group input[readonly] {
            background-color: #f8f9fa;
            cursor: not-allowed;
        }

        .form-group input[type="number"]::-webkit-inner-spin-button {
            -webkit-appearance: none;
        }

        .btn {
            padding: 12px 25px;
            border: none;
            border-radius: 5px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
            cursor: pointer;
            transition: all 0.3s ease;
            margin: 5px;
        }

        .btn-primary {
            background: #710000;
            color: white;
        }

        .btn-info {
            background: #17a2b8;
            color: white;
        }

        .btn-success {
            background: #28a745;
            color: white;
            width: 100%;
            margin: 20px 0;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        .btn:disabled {
            opacity: 0.7;
            cursor: not-allowed;
            transform: none;
        }

        .login-link {
            text-align: center;
            margin-top: 20px;
        }

        .login-link a {
            color: #710000;
            text-decoration: none;
            font-weight: bold;
        }

        .login-link a:hover {
            text-decoration: underline;
        }

        #otpSection {
            animation: fadeIn 0.5s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .form-row {
            display: flex;
            gap: 20px;
            margin-bottom: 20px;
        }

        .form-col {
            flex: 1;
        }

        @media (max-width: 768px) {
            .form-row {
                flex-direction: column;
                gap: 0;
            }
        }
    </style>
</head>

<body>
    <?php require 'utils/header.php'; ?>
    
    <div class="register-wrapper">
        <div class="register-container">
            <div class="register-header">
                <h1><i class="fas fa-user-plus"></i> Register</h1>
                <hr style="border-color: #710000; width: 50%;">
            </div>

            <form method="POST" id="registrationForm">
                <div class="form-row">
                    <div class="form-col">
                        <div class="form-group">
                            <label><i class="fas fa-id-card"></i> Student ID</label>
                            <input type="text" name="usn" pattern="[0-9]{4}-[0-9]{5}" 
                                   title="Format: 0000-00000" placeholder="0000-00000" required>
                        </div>
                    </div>
                    <div class="form-col">
                        <div class="form-group">
                            <label><i class="fas fa-user"></i> Student Name</label>
                            <input type="text" name="name" required>
                        </div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-col">
                        <div class="form-group">
                            <label><i class="fas fa-graduation-cap"></i> Course</label>
                            <input type="text" name="branch" required>
                        </div>
                    </div>
                    <div class="form-col">
                        <div class="form-group">
                            <label><i class="fas fa-calendar-alt"></i> Semester</label>
                            <select name="sem" required>
                                <option value="1">1st Semester</option>
                                <option value="2">2nd Semester</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label><i class="fas fa-envelope"></i> Email</label>
                    <input type="email" name="email" id="email" required>
                    <button type="button" onclick="sendOTP()" class="btn btn-primary">
                        <i class="fas fa-paper-plane"></i> Verify Email
                    </button>
                </div>

                <div class="form-group" id="otpSection" style="display: none;">
                    <label><i class="fas fa-key"></i> Enter OTP</label>
                    <input type="text" name="otp" id="otp" maxlength="6" required>
                    <button type="button" onclick="verifyOTP()" class="btn btn-info">
                        <i class="fas fa-check-circle"></i> Verify OTP
                    </button>
                </div>
                <div class="form-row">
                    <div class="form-col">
                        <div class="form-group">
                            <label><i class="fas fa-lock"></i> Password</label>
                            <input type="password" name="password" id="password" required 
                                oninput="validatePassword()" autocomplete="new-password">
                        </div>
                    </div>
                    <div class="form-col">
                        <div class="form-group">
                            <label><i class="fas fa-lock"></i> Confirm Password</label>
                            <input type="password" name="confirm_password" id="confirm_password" required 
                                oninput="validatePassword()" autocomplete="new-password">
                        </div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-col">
                        <div class="form-group">
                            <label><i class="fas fa-phone"></i> Phone</label>
                            <input type="number" name="phone" required>
                        </div>
                    </div>
                    <div class="form-col">
                        <div class="form-group">
                            <label><i class="fas fa-university"></i> Campus</label>
                            <input type="text" name="college" value="EVSU-OC" readonly>
                        </div>
                    </div>
                </div>

                <button type="submit" name="update" id="submitBtn" class="btn btn-success" disabled>
                    <i class="fas fa-check"></i> Submit Registration
                </button>

                <div class="login-link">
                    <p>Already registered? <a href="usn.php">Log in</a></p>
                </div>
            </form>
        </div>
    </div>
    <?php require 'utils/footer.php'; ?>

    <script>
        function validatePassword() {
            const password = document.getElementById('password').value;
            const confirm_password = document.getElementById('confirm_password').value;
            
            console.log('Password:', password); // For debugging
            
            if (password !== confirm_password) {
                document.getElementById('confirm_password').setCustomValidity('Passwords do not match');
            } else {
                document.getElementById('confirm_password').setCustomValidity('');
            }
        }
        function sendOTP() {
            const email = document.getElementById('email').value.trim();
            if (!email) {
                alert('Please enter your email address');
                return;
            }

            const verifyButton = document.querySelector('button[onclick="sendOTP()"]');
            verifyButton.disabled = true;
            verifyButton.textContent = 'Sending...';

            fetch('send_otp.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'email=' + encodeURIComponent(email)
            })
            .then(response => response.text())
            .then(data => {
                if (data.trim() === 'success') {
                    document.getElementById('otpSection').style.display = 'block';
                    alert('OTP has been sent to your email');
                } else {
                    alert('Error sending OTP: ' + data);
                }
            })
            .catch(error => {
                alert('Error: ' + error);
            })
            .finally(() => {
                verifyButton.disabled = false;
                verifyButton.textContent = 'Verify Email';
            });
        }

        function verifyOTP() {
            const enteredOTP = document.getElementById('otp').value.trim();
            const email = document.getElementById('email').value.trim();

            if (!enteredOTP) {
                alert('Please enter the OTP');
                return;
            }

            fetch('verify_otp.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'email=' + encodeURIComponent(email) + '&otp=' + encodeURIComponent(enteredOTP)
            })
            .then(response => response.text())
            .then(data => {
                if (data.trim() === 'success') {
                    alert('Email verified successfully!');
                    document.getElementById('submitBtn').disabled = false;
                    document.getElementById('email').readOnly = true;
                    document.getElementById('otpSection').style.display = 'none';
                    const verifiedInput = document.createElement('input');
                    verifiedInput.type = 'hidden';
                    verifiedInput.name = 'email_verified';
                    verifiedInput.value = 'true';
                    document.getElementById('registrationForm').appendChild(verifiedInput);
                } else if (data.trim() === 'expired') {
                    alert('OTP has expired. Please request a new one.');
                } else {
                    alert('Invalid OTP. Please try again.');
                }
            })
            .catch(error => {
                alert('Error: ' + error);
            });
        }

        document.getElementById('confirm_password').addEventListener('input', function() {
            const password = document.getElementById('password').value;
            const confirm_password = this.value;
            
            if (password !== confirm_password) {
                this.setCustomValidity('Passwords do not match');
            } else {
                this.setCustomValidity('');
            }
        });

        document.getElementById('password').addEventListener('input', function() {
            const confirm_password = document.getElementById('confirm_password');
            if (confirm_password.value) {
                if (this.value !== confirm_password.value) {
                    confirm_password.setCustomValidity('Passwords do not match');
                } else {
                    confirm_password.setCustomValidity('');
                }
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
            const loginContainer = document.querySelector('.register-container');
            if (loginContainer) {
                loginContainer.scrollIntoView({ behavior: 'smooth' });
            }
        });
    </script>
</body>
</html>

<?php
if (isset($_POST["update"])) {
    // Debug line - remove in production
    error_log("Form submitted - POST data: " . print_r($_POST, true));
    
    $usn = $_POST["usn"];
    $name = $_POST["name"];
    $branch = $_POST["branch"];
    $sem = $_POST["sem"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $college = $_POST["college"];
    $usn_pass = $_POST["password"]; // Changed variable name
    $confirm_password = $_POST["confirm_password"];
    
    // Debug line - remove in production
    error_log("Password before validation: " . $usn_pass);

    // Password validation
    if ($usn_pass !== $confirm_password) {
        echo "<script>
            alert('Passwords do not match!');
            window.location.href='register.php';
        </script>";
        exit;
    }

    if (empty($usn_pass)) {
        echo "<script>
            alert('Password cannot be empty');
            window.location.href='register.php';
        </script>";
        exit;
    }

    if (!isset($_SESSION['email_verified']) || $_SESSION['email_verified'] !== $email) {
        echo "<script>
            alert('Please verify your email first');
            window.location.href='register.php';
        </script>";
        exit;
    }

    if (!empty($usn) && !empty($name) && !empty($branch) && !empty($sem) && 
        !empty($email) && !empty($phone) && !empty($college) && !empty($usn_pass)) {
        
        include 'classes/db1.php';
        
        if (!$conn) {
            error_log("Database connection failed: " . mysqli_connect_error());
            die("Connection failed: " . mysqli_connect_error());
        }
        
        $check_query = "SELECT * FROM participent WHERE usn = ?";
        $stmt = $conn->prepare($check_query);
        $stmt->bind_param("s", $usn);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            echo "<script>
                alert('Already registered this USN');
                window.location.href='register.php';
            </script>";
        } else {
            $INSERT = "INSERT INTO participent (usn, name, branch, sem, email, phone, college, usn_pass) 
                      VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($INSERT);
            
            if (!$stmt) {
                error_log("Prepare failed: " . $conn->error);
                die("Prepare failed: " . $conn->error);
            }
            
            error_log("About to execute query with password: " . $usn_pass);
            
            $stmt->bind_param("ssssssss", $usn, $name, $branch, $sem, $email, $phone, $college, $usn_pass);
            
            if ($stmt->execute()) {
                error_log("Insert successful for user: " . $email . " with password length: " . strlen($usn_pass));
                unset($_SESSION['email_verified']);
                echo "<script>
                    alert('Registered Successfully!');
                    window.location.href='index.php';
                </script>";
            } else {
                error_log("Registration failed: " . $stmt->error);
                echo "<script>
                    alert('Error registering user: " . $stmt->error . "');
                    window.location.href='register.php';
                </script>";
            }
        }
        $stmt->close();
        $conn->close();
    } else {
        echo "<script>
            alert('All fields are required');
            window.location.href='register.php';
        </script>";
    }
}
?>