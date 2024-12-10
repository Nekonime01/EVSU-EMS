<?php
include_once 'classes/db1.php';

$participants_query = "SELECT COUNT(*) AS count FROM participent";
$result = $conn->query($participants_query);
$participants_count = $result->fetch_assoc()['count'];

$events_query = "SELECT COUNT(*) AS event_count FROM events";
$events_result = $conn->query($events_query);
$events_count = $events_result->fetch_assoc()['event_count'];

$registered_query = "SELECT COUNT(*) AS participants_count FROM registered";
$registered_result = $conn->query($registered_query);
$registered_count = $registered_result->fetch_assoc()['participants_count'];

$earnings_query = "SELECT SUM(total_earnings) AS total_earnings FROM payments";
$earnings_result = $conn->query($earnings_query);
$total_earnings = $earnings_result->fetch_assoc()['total_earnings'];

$event_types_query = "SELECT 
    et.type_title,
    COUNT(e.event_id) as count
    FROM events e
    JOIN event_type et ON e.type_id = et.type_id
    GROUP BY et.type_id, et.type_title";
$event_types_result = $conn->query($event_types_query);
$event_type_labels = [];
$event_type_data = [];
while($row = $event_types_result->fetch_assoc()) {
    $event_type_labels[] = $row['type_title'];
    $event_type_data[] = $row['count'];
}
$conn->close();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Administrator</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        .info-box {
            background: linear-gradient(135deg, #1a2a6c, #b21f1f, #fdbb2d);
            border-radius: 15px;
            padding: 20px;
            margin: 20px;
            text-align: center;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
            width: 300px;
            display: inline-block;
            transform-style: preserve-3d;
            transition: transform 0.5s ease, box-shadow 0.5s ease;
            color: white;
            position: relative;
            overflow: hidden;
    
        }

        .info-box:hover {
            transform: translateY(-10px) rotateX(5deg);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.3);
        }

        .info-box::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: 0.5s;
        }

        .info-box:hover::before {
            left: 100%;
        }

        .info-box i {
            font-size: 50px;
            color: rgba(255, 255, 255, 0.9);
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
            animation: bounce 2s infinite;
        }

        .info-box h2 {
            color: white;
            margin: 20px 0;
            font-size: 24px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
        }

        .info-box .count {
            font-size: 36px;
            font-weight: bold;
            color: white;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
            animation: countUp 2s ease-out;
        }

    .info-box-link {
        text-decoration: none;
        display: inline-block;
        cursor: pointer;
    }

    .info-box-link:hover .info-box {
        transform: translateY(-10px) rotateX(5deg);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.3);
    }

    .info-box-link .info-box::after {
        content: '';
        position: absolute;
        bottom: 10px;
        right: 10px;
        width: 20px;
        height: 20px;
        background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="white"><path d="M5 12h14M12 5l7 7-7 7"/></svg>');
        background-size: contain;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .info-box-link:hover .info-box::after {
        opacity: 1;
    }

    .info-box:last-child {
        cursor: default;
        opacity: 0.9;
    }

    .info-box:last-child:hover {
        transform: none;
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        cursor: pointer;
    }

        .dashboard {
            margin-top: -20px;
            padding-left: 100px;
            perspective: 1000px;
        }

        @keyframes bounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }

        @keyframes countUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .charts-row {
            display: flex;
            justify-content: space-around;
            margin-top: 40px;
            padding: 0 20px;
        }

        .chart-wrapper {
            width: 45%;
            height: 500px;
            margin: 20px;
        }

        .chart-title {
            color: #710000;
            text-align: center;
            margin-bottom: 20px;
            font-size: 24px;
            font-weight: bold;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>
<?php include 'utils/adminHeader.php'?>
<div class="container" id="eventDetailsSection">
    <h1 style="color: #710000; text-shadow: 2px 2px yellow; user-select: none; font-size: 40px; padding-left: 70px; margin: 20px;">
        <strong>Administrator</strong>
        <hr style="width: 110%; margin: 30px;">
    </h1>
        <div class="dashboard">
        <a href="participent.php" class="info-box-link">
            <div class="info-box">
                <i class="fas fa-user-check"></i>
                <h2>Students Registered</h2>
                <div class="count"><?php echo $participants_count; ?></div>
            </div>
        </a>

        <a href="adminPage.php" class="info-box-link">
            <div class="info-box">
                <i class="fas fa-calendar-alt"></i>
                <h2>Ongoing Events</h2>
                <div class="count"><?php echo $events_count; ?></div>
            </div>
        </a>

        <a href="Stu_details.php" class="info-box-link">
            <div class="info-box">
                <i class="fas fa-users"></i>
                <h2>Participants</h2>
                <div class="count"><?php echo $registered_count; ?></div>
            </div>
        </a>

        <div class="info-box">
            <i class="fas fa-dollar-sign"></i>
            <h2>Total Earnings</h2>
            <div class="count"><?php echo number_format($total_earnings, 2); ?></div>
        </div>

        <h1><strong style="color: #710000; user-select: none; font-size: 25px">Data Analytics</strong></h1>
        <hr>

        <div class="charts-row">
            <div class="chart-wrapper">
                <div class="chart-title">Overall Statistics</div>
                <canvas id="barChart"></canvas>
            </div>

            <div class="chart-wrapper">
                <div class="chart-title">Event Type Distribution</div>
                <canvas id="pieChart"></canvas>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
    const infoBoxLinks = document.querySelectorAll('.info-box-link');
    
    infoBoxLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            const box = this.querySelector('.info-box');
            box.style.transform = 'scale(0.95)';
            setTimeout(() => {
                box.style.transform = '';
            }, 150);
        });
    });
});
    document.addEventListener('DOMContentLoaded', function() {
    const infoBoxLinks = document.querySelectorAll('.info-box-link');
    
    infoBoxLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            const box = this.querySelector('.info-box');
            box.style.transform = 'scale(0.95)';
            setTimeout(() => {
                box.style.transform = '';
            }, 150);
        });
    });
});
    // Bar Chart
    const data = {
        studentsRegistered: <?php echo $participants_count; ?>,
        ongoingEvents: <?php echo $events_count; ?>,
        participants: <?php echo $registered_count; ?>,
        totalEarnings: <?php echo $total_earnings; ?>
    };

    const ctxBar = document.getElementById('barChart').getContext('2d');
    const barChart = new Chart(ctxBar, {
        type: 'bar',
        data: {
            labels: ['Students Registered', 'Ongoing Events', 'Participants', 'Total Earnings'],
            datasets: [{
                label: 'Statistics',
                data: [data.studentsRegistered, data.ongoingEvents, data.participants, data.totalEarnings],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.8)',
                    'rgba(54, 162, 235, 0.8)',
                    'rgba(153, 102, 255, 0.8)',
                    'rgba(255, 206, 86, 0.8)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 206, 86, 1)'
                ],
                borderWidth: 2,
                borderRadius: 10,
                borderSkipped: false,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(255, 255, 255, 0.1)'
                    },
                    ticks: {
                        color: '#710000',
                        font: {
                            size: 14
                        }
                    }
                },
                x: {
                    grid: {
                        color: 'rgba(255, 255, 255, 0.1)'
                    },
                    ticks: {
                        color: '#710000',
                        font: {
                            size: 14
                        }
                    }
                }
            },
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    padding: 12,
                    titleColor: 'white',
                    bodyColor: 'white',
                    borderColor: 'white',
                    borderWidth: 1,
                    displayColors: false,
                    titleFont: {
                        size: 16
                    },
                    bodyFont: {
                        size: 14
                    }
                }
            },
            animation: {
                duration: 2000,
                easing: 'easeInOutQuart'
            }
        }
    });

    // Pie Chart
    const ctxPie = document.getElementById('pieChart').getContext('2d');
    const pieChart = new Chart(ctxPie, {
        type: 'doughnut',
        data: {
            labels: <?php echo json_encode($event_type_labels); ?>,
            datasets: [{
                data: <?php echo json_encode($event_type_data); ?>,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.8)',
                    'rgba(54, 162, 235, 0.8)',
                    'rgba(255, 206, 86, 0.8)',
                    'rgba(75, 192, 192, 0.8)',
                    'rgba(153, 102, 255, 0.8)',
                    'rgba(255, 159, 64, 0.8)'
                ],
                borderColor: 'white',
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'right',
                    labels: {
                        color: '#710000',
                        padding: 20,
                        font: {
                            size: 14
                        }
                    }
                },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    padding: 12,
                    titleColor: 'white',
                    bodyColor: 'white',
                    borderColor: 'white',
                    borderWidth: 1,
                    displayColors: true,
                    titleFont: {
                        size: 16
                    },
                    bodyFont: {
                        size: 14
                    }
                }
            },
            animation: {
                duration: 2000,
                easing: 'easeInOutQuart'
            }
        }
    });
</script>
</body>
</html>