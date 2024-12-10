<?php
include_once 'classes/db1.php';
session_start();

$loginSuccess = false;
$loginError = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["usn"]) && isset($_POST["password"])) {
        $usn = mysqli_real_escape_string($conn, $_POST['usn']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);

        $sql = "SELECT * FROM participent WHERE usn = ? AND usn_pass = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $usn, $password);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $_SESSION['user_id'] = $usn;
            $_SESSION['logged_in'] = true;
            $loginSuccess = true;
        } else {
            $loginError = true;
        }
    }
}
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Log in (EEMS)</title>
    <?php require 'utils/styles.php'; ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/login.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .shake {
            animation: shake 0.5s;
        }

        @keyframes shake {
            0% { transform: translateX(0); }
            25% { transform: translateX(-5px); }
            50% { transform: translateX(5px); }
            75% { transform: translateX(-5px); }
            100% { transform: translateX(0); }
        }
    </style>
</head>
<body>
    <?php require 'utils/header.php'; ?>

    <div class="login-wrapper">
        <div class="login-container">
            <div class="login-header">
                <h1><i class="fas fa-user-graduate"></i> Student Login</h1>
                <hr style="border-color: #710000; width: 50%;">
            </div>

            <form action="usn.php" method="POST" id="loginForm">
                <div class="form-group">
                    <label for="usn"><i class="fas fa-id-card"></i> Student ID</label>
                    <input type="text" id="usn" name="usn" class="form-control" 
                           required placeholder="1234-12345" 
                           pattern="[0-9]{4}-[0-9]{5}"
                           title="Please enter in format: 1234-12345"
                           maxlength="10">
                    <small class="text-muted">Format: 1234-12345</small>
                </div>

                <div class="form-group">
                    <label for="password"><i class="fas fa-lock"></i> Password</label>
                    <input type="password" id="password" name="password" class="form-control" 
                           required placeholder="Enter your password">
                </div>

                <button type="submit" class="login-btn">
                    <i class="fas fa-sign-in-alt"></i> Login
                </button>
                <div class="register-link">
                    <p>Haven't registered yet? <a href="register.php">Register Now</a></p>
                </div>
            </form>
        </div>
    </div>

    <footer>
        <?php require 'utils/footer.php'; ?>
    </footer>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const usnInput = document.getElementById('usn');
        if(usnInput) {
            usnInput.addEventListener('input', function(e) {
                let value = this.value.replace(/[^\d-]/g, '');
                if (value.length > 4 && !value.includes('-')) {
                    value = value.slice(0, 4) + '-' + value.slice(4);
                }
                value = value.slice(0, 10);
                this.value = value;
            });

            usnInput.addEventListener('keypress', function(e) {
                const char = String.fromCharCode(e.which);
                if (!/[\d-]/.test(char)) {
                    e.preventDefault();
                }
            });
        }

        const loginContainer = document.querySelector('.login-container');
        if (loginContainer) {
            loginContainer.scrollIntoView({ behavior: 'smooth' });
        }

        <?php if ($loginSuccess): ?>
            Swal.fire({
                icon: 'success',
                title: 'Login Successful',
                text: 'Welcome back!',
                confirmButtonText: 'Continue'
            }).then(() => {
                window.location.href = 'RegisteredEvents.php?usn=<?php echo urlencode($usn); ?>';
            });
        <?php elseif ($loginError): ?>
            Swal.fire({
                icon: 'error',
                title: 'Login Failed',
                text: 'Invalid Student ID or Password',
                confirmButtonText: 'Try Again',
                onOpen: () => {
                    document.querySelector('.login-container').classList.add('shake');
                }
            }).then(() => {
                document.querySelector('.login-container').classList.remove('shake');
            });
        <?php endif; ?>
    });
    </script>
</body>
</html>