<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>(EVSU-OC) Event Management System</title>
    <?php require 'utils/styles.php';?>
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <style>
        .event-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border-radius: 15px;
            overflow: hidden;
            margin-bottom: 30px;
            background: white;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .event-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.2);
        }

        .event-image {
            position: relative;
            overflow: hidden;
            height: 300px;
        }

        .event-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .event-card:hover .event-image img {
            transform: scale(1.1);
        }

        .subcontent {
            padding: 25px;
            background: linear-gradient(to bottom, #ffffff 0%, #f8f9fa 100%);
        }

        .subcontent h1 {
            color: #710000 !important;
            margin-bottom: 20px;
            font-weight: 700;
            position: relative;
            display: inline-block;
        }

        .subcontent h1:after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 0;
            width: 60%;
            height: 3px;
            background: #ffd700;
        }

        .subcontent p {
            color: #444;
            line-height: 1.8;
            margin-bottom: 20px;
            font-size: 16px;
        }

        .btn-warning {
            background: #710000;
            border: none;
            color: white;
            padding: 12px 30px;
            border-radius: 50px;
            transition: all 0.3s ease;
            text-transform: uppercase;
            font-weight: 600;
            letter-spacing: 1px;
        }

        .btn-warning:hover {
            background: #8B0000;
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(113,0,0,0.3);
        }

        .section-divider {
            height: 3px;
            background: linear-gradient(to right, #710000, #ffd700);
            margin: 40px 0;
            border-radius: 3px;
        }

        .page-title {
            text-align: center;
            margin-bottom: 50px;
        }

        .page-title h1 {
            color: #710000;
            font-size: 50px;
            text-shadow: 3px 3px yellow;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .event-category {
            position: absolute;
            top: 20px;
            right: 20px;
            background: rgba(113,0,0,0.9);
            color: white;
            padding: 8px 15px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 600;
        }

        @media (max-width: 768px) {
            .event-image {
                height: 200px;
            }
            
            .subcontent {
                padding: 15px;
            }
            
            .subcontent h1 {
                font-size: 24px !important;
            }
        }
    </style>
</head>
<body>
    <?php require 'utils/header.php'; ?>
    <div class="content">
        <div class="container">
            <div class="page-title">
                <h1 class="animate__animated animate__fadeInDown">EVENTS</h1>
            </div>

            <div class="row">
                <!-- Technical Events -->
                <section class="col-md-12" data-aos="fade-up">
                    <div class="event-card">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="event-image">
                                        <span class="event-category">Technical</span>
                                        <img src="images/tch.jpg" alt="Technical Events">
                                    </div>
                                </div>
                                <div class="subcontent col-md-6">
                                    <h1>Technical Events</h1>
                                    <p>
                                        EMBRACE YOUR TECHNICAL SKILLS BY PARTICIPATING IN OUR DIFFERENT TECHNICAL EVENTS!
                                        <br><br>
                                        UNLEASH YOUR INNOVATIVE SPIRIT AND TECHNICAL PROWESS BY PARTICIPATING IN OUR DYNAMIC TECHNICAL EVENTS!
                                    </p>
                                    <?php $id=1; ?>
                                    <a class="btn btn-warning" href="viewEvent.php?id=<?php echo $id; ?>">
                                        <span class="glyphicon glyphicon-circle-arrow-right"></span> Explore More
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <div class="section-divider"></div>

                <!-- Gaming Events -->
                <section class="col-md-12" data-aos="fade-up">
                    <div class="event-card">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="event-image">
                                        <span class="event-category">Gaming</span>
                                        <img src="images/gaming12.jpg" alt="Gaming Events">
                                    </div>
                                </div>
                                <div class="subcontent col-md-6">
                                    <h1>Gaming Events</h1>
                                    <p>
                                        EMBRACE YOUR GAMING SKILLS BY PARTICIPATING IN OUR DIFFERENT GAMING EVENTS!
                                        <br><br>
                                        GET READY TO DIVE INTO THE EXHILARATING WORLD OF GAMING WITH OUR ACTION-PACKED GAMING EVENTS!
                                    </p>
                                    <?php $id=2; ?>
                                    <a class="btn btn-warning" href="viewEvent.php?id=<?php echo $id; ?>">
                                        <span class="glyphicon glyphicon-circle-arrow-right"></span> Explore More
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <div class="section-divider"></div>

                <!-- On-Stage Events -->
                <section class="col-md-12" data-aos="fade-up">
                    <div class="event-card">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="event-image">
                                        <span class="event-category">On-Stage</span>
                                        <img src="images/stage1.jpg" alt="On-Stage Events">
                                    </div>
                                </div>
                                <div class="subcontent col-md-6">
                                    <h1>On-Stage Events</h1>
                                    <p>
                                        EMBRACE YOUR CONFIDENCE BY PARTICIPATING IN OUR DIFFERENT ON-STAGE EVENTS!
                                        <br><br>
                                        EXPERIENCE THE THRILL OF THE SPOTLIGHT WITH OUR EXCITING ON-STAGE EVENTS!
                                    </p>
                                    <?php $id=3; ?>
                                    <a class="btn btn-warning" href="viewEvent.php?id=<?php echo $id; ?>">
                                        <span class="glyphicon glyphicon-circle-arrow-right"></span> Explore More
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <div class="section-divider"></div>

                <!-- Off-Stage Events -->
                <section class="col-md-12" data-aos="fade-up">
                    <div class="event-card">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="event-image">
                                        <span class="event-category">Off-Stage</span>
                                        <img src="images/offstage.jpg" alt="Off-Stage Events">
                                    </div>
                                </div>
                                <div class="subcontent col-md-6">
                                    <h1>Off-Stage Events</h1>
                                    <p>
                                        EMBRACE YOUR TALENT BY PARTICIPATING IN OUR DIFFERENT OFF-STAGE EVENTS!
                                        <br><br>
                                        DISCOVER A WORLD OF CREATIVITY, LEARNING, AND FUN WITH OUR DIVERSE RANGE OF OFF-STAGE EVENTS!
                                    </p>
                                    <?php $id=4; ?>
                                    <a class="btn btn-warning" href="viewEvent.php?id=<?php echo $id; ?>">
                                        <span class="glyphicon glyphicon-circle-arrow-right"></span> Explore More
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <div class="section-divider"></div>

                <!-- Department Days -->
                <section class="col-md-12" data-aos="fade-up">
                    <div class="event-card">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="event-image">
                                        <span class="event-category">Department</span>
                                        <img src="images/stage1.jpg" alt="Department Days">
                                    </div>
                                </div>
                                <div class="subcontent col-md-6">
                                    <h1>Department Days</h1>
                                    <p>
                                        EMBRACE YOUR CONFIDENCE BY PARTICIPATING IN OUR DIFFERENT DEPARTMENT DAYS!
                                        <br><br>
                                        DEPARTMENT DAYS EVENT IS TYPICALLY AN ORGANIZED SERIES OF ACTIVITIES AND PROGRAMS DESIGNED TO CELEBRATE AND SHOWCASE THE WORK AND ACHIEVEMENTS OF A SPECIFIC DEPARTMENT.
                                    </p>
                                    <?php $id=5; ?>
                                    <a class="btn btn-warning" href="viewEvent.php?id=<?php echo $id; ?>">
                                        <span class="glyphicon glyphicon-circle-arrow-right"></span> Explore More
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <div class="section-divider"></div>

                <!-- Sports Events -->
                <section class="col-md-12" data-aos="fade-up">
                    <div class="event-card">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="event-image">
                                        <span class="event-category">Sports</span>
                                        <img src="images/se.jpg" alt="Sports Events">
                                    </div>
                                </div>
                                <div class="subcontent col-md-6">
                                    <h1>Sports Events</h1>
                                    <p>
                                        EMBRACE YOUR CONFIDENCE BY PARTICIPATING IN OUR DIFFERENT SPORTS EVENT!
                                        <br><br>
                                        PLANNED AND ORGANIZED GATHERING CENTERED AROUND ATHLETIC COMPETITIONS, FEATURING PARTICIPANTS FROM VARIOUS TEAMS SHOWCASING THEIR PHYSICAL ABILITIES AND SKILLS.
                                    </p>
                                    <?php $id=6; ?>
                                    <a class="btn btn-warning" href="viewEvent.php?id=<?php echo $id; ?>">
                                        <span class="glyphicon glyphicon-circle-arrow-right"></span> Explore More
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
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

        function scrollToCenter(element) {
            const elementRect = element.getBoundingClientRect();
            const absoluteElementTop = elementRect.top + window.pageYOffset;
            const middle = absoluteElementTop - (window.innerHeight / 50) + (elementRect.height / 50);
            window.scrollTo({ top: middle, behavior: 'smooth' });
        }

        document.addEventListener("DOMContentLoaded", function() {
            if (window.location.hash && window.location.hash === '#events-section') {
                const target = document.querySelector('#events-section');
                scrollToCenter(target);
            }
        });
    </script>
</body>
</html>