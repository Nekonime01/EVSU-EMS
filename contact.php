<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Contact us (EEMS)</title>
    <?php require 'utils/styles.php'; ?>
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        .content {
            background: #f8f9fa;
            padding: 50px 0;
        }

        .page-title {
            text-align: center;
            margin-bottom: 50px;
        }

        .page-title h1 {
            color: #710000;
            font-size: 42px;
            font-weight: 700;
            text-shadow: 3px 3px yellow;
            margin-bottom: 20px;
            position: relative;
            display: inline-block;
        }

        .contact-card {
            background: white;
            border-radius: 15px;
            padding: 30px;
            margin-bottom: 30px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .contact-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.2);
        }

        .contact-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background: linear-gradient(to right, #710000, #ffd700);
        }

        .contact-title {
            color: #000080;
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .contact-title i {
            color: #710000;
            font-size: 36px;
        }

        .contact-info {
            padding-left: 15px;
            border-left: 3px solid #ffd700;
        }

        .contact-item {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
            padding: 10px;
            background: #f8f9fa;
            border-radius: 8px;
            transition: transform 0.2s ease;
        }

        .contact-item:hover {
            transform: translateX(10px);
        }

        .contact-item i {
            color: #710000;
            font-size: 20px;
            margin-right: 15px;
            width: 25px;
            text-align: center;
        }

        .contact-text {
            color: #444;
            font-size: 16px;
            font-weight: 500;
        }

        .divider {
            height: 3px;
            background: linear-gradient(to right, #710000, #ffd700);
            margin: 40px 0;
            border-radius: 3px;
        }

        @media (max-width: 768px) {
            .contact-card {
                margin: 15px;
                padding: 20px;
            }
            
            .contact-title {
                font-size: 24px;
            }
            
            .contact-item {
                padding: 8px;
            }
        }
    </style>
</head>
<body>
    <?php require 'utils/header.php'; ?>
    <div class="content">
        <div class="container">
            <div class="page-title">
                <h1 data-aos="fade-down">CONTACT US</h1>
            </div>

            <div class="row">
                <!-- EVSU-ORMOC Contact -->
                <div class="col-md-6" data-aos="fade-right">
                    <div class="contact-card">
                        <h2 class="contact-title">
                            <i class="fas fa-university"></i>
                            EVSU-ORMOC
                        </h2>
                        <div class="contact-info">
                            <div class="contact-item">
                                <i class="fas fa-envelope"></i>
                                <span class="contact-text">evsuormoc@gmail.com</span>
                            </div>
                            <div class="contact-item">
                                <i class="fas fa-phone-alt"></i>
                                <span class="contact-text">09303139470</span>
                            </div>
                            <div class="contact-item">
                                <i class="fas fa-map-marker-alt"></i>
                                <span class="contact-text">Ormoc City, Leyte</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Admin Contact -->
                <div class="col-md-6" data-aos="fade-left">
                    <div class="contact-card">
                        <h2 class="contact-title">
                            <i class="fas fa-user-shield"></i>
                            ADMIN
                        </h2>
                        <div class="contact-info">
                            <div class="contact-item">
                                <i class="fas fa-envelope"></i>
                                <span class="contact-text">Admin@gmail.com</span>
                            </div>
                            <div class="contact-item">
                                <i class="fas fa-phone-alt"></i>
                                <span class="contact-text">09631192186</span>
                            </div>
                            <div class="contact-item">
                                <i class="fas fa-clock"></i>
                                <span class="contact-text">Available 24/7</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php require 'utils/footer.php'; ?>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 1000,
            once: true,
            offset: 100
        });

        function scrollToContact() {
            var contactSection = document.getElementById('contact');
            var targetScroll = contactSection.offsetTop - (window.innerHeight - contactSection.offsetHeight) / 2;
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

        window.onload = scrollToContact;
    </script>
</body>
</html>