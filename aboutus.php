<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>About (EVSU)</title>
    <?php require 'utils/styles.php'; ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .about-section {
            padding: 50px 0;
            background: linear-gradient(rgba(255,255,255,0.9), rgba(255,255,255,0.9)),
                        url('path/to/your/background-image.jpg') center/cover;
        }

        .about-header {
            color: #710000;
            font-size: 42px;
            text-shadow: 3px 3px yellow;
            text-align: center;
            margin-bottom: 50px;
            position: relative;
        }

        .about-header::after {
            content: '';
            display: block;
            width: 100px;
            height: 4px;
            background: #710000;
            margin: 20px auto;
        }

        .about-content {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .about-text {
            font-size: 20px;
            line-height: 1.8;
            text-align: justify;
            margin-bottom: 30px;
        }

        .vision-mission {
            display: flex;
            justify-content: space-between;
            margin: 50px 0;
            flex-wrap: wrap;
            gap: 30px;
        }

        .vm-box {
            flex: 1;
            min-width: 300px;
            padding: 30px;
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
        }

        .vm-box:hover {
            transform: translateY(-10px);
        }

        .vm-title {
            font-size: 30px;
            color: #710000;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .vm-text {
            font-size: 18px;
            line-height: 1.6;
        }

        .core-values {
            background: #710000;
            color: white;
            padding: 40px;
            border-radius: 15px;
            margin: 50px 0;
        }

        .core-values h3 {
            color: yellow;
            font-size: 30px;
            margin-bottom: 30px;
            text-align: center;
        }

        .values-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
        }

        .value-item {
            text-align: center;
            padding: 20px;
            background: rgba(255,255,255,0.1);
            border-radius: 10px;
            transition: transform 0.3s ease;
        }

        .value-item:hover {
            transform: scale(1.05);
        }

        .value-letter {
            font-size: 36px;
            font-weight: bold;
            color: yellow;
            margin-bottom: 10px;
        }

        @media (max-width: 768px) {
            .vision-mission {
                flex-direction: column;
            }
            
            .vm-box {
                width: 100%;
            }
        }
    </style>
</head>

<body>
    <?php require 'utils/header.php'; ?>
    
    <div class="about-section">
        <div class="about-content">
            <h1 class="about-header">ABOUT US</h1>
            
            <div class="about-text">
                <p>The Eastern Visayas State University addresses its academic endeavors towards the development of the socio-economic condition of region VIII by emphasizing the development of human resources and necessary input to production and growth. It plays a major role in providing the human resources for industrial agri-business enterprises as well as for the small, medium, and large-scale industries, which are the components for regional development.</p>
            </div>

            <div class="about-text">
                <p>The Eastern Visayas State University – Ormoc City Campus (EVSU Ormoc) is one of the four satellite campuses of EVSU whose main campus is located in Tacloban City, Leyte. The EVSU charter mandates it to provide quality education and training in the fields of science, technology and allied fields through instruction, research, extension and production activities.</p>
            </div>

            <div class="vision-mission">
                <div class="vm-box">
                    <h3 class="vm-title">
                        <i class="fas fa-eye"></i>
                        Vision
                    </h3>
                    <p class="vm-text">A Leading State University in Technological and Professional Education.</p>
                </div>

                <div class="vm-box">
                    <h3 class="vm-title">
                        <i class="fas fa-bullseye"></i>
                        Mission
                    </h3>
                    <p class="vm-text">Develop a Strong Technologically and Professionally Competent Productive Human Resource Imbued with Positive Values Needed to Propel Sustainable Development.</p>
                </div>
            </div>

            <div class="core-values">
                <h3>Core Values</h3>
                <div class="values-grid">
                    <div class="value-item">
                        <div class="value-letter">E</div>
                        <div>EXCELLENCE</div>
                    </div>
                    <div class="value-item">
                        <div class="value-letter">V</div>
                        <div>VALUE-LADEN</div>
                    </div>
                    <div class="value-item">
                        <div class="value-letter">S</div>
                        <div>SERVICE-DRIVEN</div>
                    </div>
                    <div class="value-item">
                        <div class="value-letter">U</div>
                        <div>UNITY IN DIVERSITY</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php require 'utils/footer.php'; ?>

    <hr style="margin: 0px;">
    <script>
        function scrollToCenterSmooth() {
            var targetScroll = (document.body.scrollHeight - window.innerHeight) / 2;
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
