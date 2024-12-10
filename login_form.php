<?php
include_once 'classes/db1.php';
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Admin (EEMS)</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <style>
        .login-wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 80vh;
            padding: 20px;
        }

        .login-container {
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
            width: 100%;
            max-width: 400px;
            margin: auto;
        }

        .login-container:hover {
            transform: translateY(-5px);
        }

        .login-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .login-header h1 {
            color: #710000;
            font-size: 28px;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-bottom: 10px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
        }

        .form-group {
            margin-bottom: 25px;
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

        .form-group input {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #ddd;
            border-radius: 5px;
            transition: all 0.3s ease;
            font-size: 16px;
            box-sizing: border-box;
        }

        .form-group input:focus {
            border-color: #710000;
            box-shadow: 0 0 0 3px rgba(113, 0, 0, 0.1);
            outline: none;
        }

        .password-container {
            position: relative;
        }

        .toggle-password {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #666;
            transition: color 0.3s ease;
        }

        .toggle-password:hover {
            color: #710000;
        }

        .login-btn {
            width: 100%;
            padding: 12px;
            background: #710000;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .login-btn:hover {
            background: #900303;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(113, 0, 0, 0.3);
        }

        .login-btn:active {
            transform: translateY(0);
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .form-group {
            animation: fadeInUp 0.5s ease forwards;
        }

        .form-group:nth-child(2) {
            animation-delay: 0.1s;
        }

        .login-btn {
            animation: fadeInUp 0.5s ease forwards;
            animation-delay: 0.2s;
        }
    </style>
    <?php require 'utils/styles.php'; ?>
</head>
<body>
    <?php require 'utils/header.php'; ?>
    <div class="login-wrapper">
        <div class="login-container">
            <div class="login-header">
                <h1><i class="fas fa-user-shield"></i> Admin Login</h1>
                <hr style="border-color: #710000; width: 50%;">
            </div>
            <form method="POST">
                <div class="form-group">
                    <label><i class="fas fa-user"></i> Username</label>
                    <input type="text" name="name" class="form-control" required 
                           placeholder="Enter your username">
                </div>
                <div class="form-group">
                    <label><i class="fas fa-lock"></i> Password</label>
                    <div class="password-container">
                        <input type="password" name="password" id="password" 
                               class="form-control" required 
                               placeholder="Enter your password">
                        <i class="fas fa-eye toggle-password" onclick="togglePassword()"></i>
                    </div>
                </div>
                <button type="submit" name="update" class="login-btn">
                    <i class="fas fa-sign-in-alt"></i> Login
                </button>
            </form>
        </div>
    </div>
    <?php require 'utils/footer.php'; ?>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.querySelector('.toggle-password');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        }

        function scrollToCenterSmooth() {
            var targetScroll = (document.body.scrollHeight - window.innerHeight) / 1.2;
            var duration = 400;
            var delay = 100;

            setTimeout(function() {
                var start = window.pageYOffset;
                var distance = targetScroll - start;
                var startTime = null;

                function animation(currentTime) {
                    if (startTime === null) startTime = currentTime;
                    var timeElapsed = currentTime - startTime;
                    var scrollAmount = easeInOutQuad(timeElapsed, start, distance, duration);
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

        window.onload = scrollToCenterSmooth;
    </script>
</body>
</html>

<?php
if (isset($_POST["update"])) {
    $myusername = mysqli_real_escape_string($conn, $_POST['name']);
    $mypassword = mysqli_real_escape_string($conn, $_POST['password']);

    $sql = "SELECT * FROM admin_login WHERE username = '$myusername' AND password = '$mypassword'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        session_start();
        $_SESSION['admin_logged_in'] = true;
        
        echo "<script>
            Swal.fire({
                icon: 'success',
                title: 'Login Successful',
                text: 'Welcome back, Administrator!',
                confirmButtonColor: '#710000'
            }).then((result) => {
                window.location.href='dash.php';
            });
        </script>";
    } else {
        echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Login Failed',
                text: 'Invalid username or password. Please try again.',
                confirmButtonColor: '#710000',
                background: '#fff',
                showClass: {
                    popup: 'animate__animated animate__fadeInDown'
                },
                hideClass: {
                    popup: 'animate__animated animate__fadeOutUp'
                }
            });
        </script>";
    }
}
?>