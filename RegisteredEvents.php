<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>User (EEMS)</title>
    
    <!-- Add SweetAlert2 CSS and JS -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <?php require 'utils/styles.php'; ?>
    <style>
        .header {
            width: 100%;
            height: 110px;
            background-color: #710000;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 20px;
            box-sizing: border-box;
            position: relative;
        }

        .header img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
        }

        .header .student-name-container {
            display: flex;
            align-items: center;
            position: absolute;
            right: 90px;
            top: 50%;
            transform: translateY(-50%);
        }

        .header .student-name {
            font-weight: bold;
            font-size: 1em;
            color: white;
            margin-right: 15px;
        }

        .header .logo {
            display: flex;
            align-items: center;
            position: absolute;
            left: 20px; 
            top: 50%;
            transform: translateY(-50%);
        }

        .header .logo img {
            width: 100px;
            height: 94px;
        }

        .header .logo-text {
            color: white;
            font-size: 24px;
            font-weight: bold;
            margin-left: 10px; 
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #900303da;
            color: white;
        }

        tr:hover {
            background-color: #f5f5f5;
        }

        .logout-button button {
            background-color: transparent;
            border: none; 
            font-size: 20px; 
            color: white; 
            cursor: pointer;
            top: 6px;
            left: 1430px;
        }

        .logout-button button:hover {
            transform: scale(1.2);
            border-radius: 50px;
        }

        .logout-button button .glyphicon {
            font-size: 24px; 
        }

        /* SweetAlert Custom Styles */
        .swal-wide {
            width: 350px !important;
            padding: 20px !important;
        }
        
        .swal-title {
            color: #710000 !important;
            font-size: 24px !important;
        }
        
        .swal-text {
            font-size: 16px !important;
        }
    </style>
</head>
<body>

    <?php
    include_once 'classes/db1.php';
    session_start();

    if (isset($_GET['usn'])) {
        $usn = htmlspecialchars($_GET['usn']);
    } else {
        $usn = '';
    }

    $nameResult = mysqli_query($conn, "SELECT name FROM participent WHERE usn = '$usn'");
    $studentName = 'Guest';

    if ($nameResult && mysqli_num_rows($nameResult) > 0) {
        $row = mysqli_fetch_assoc($nameResult);
        $studentName = htmlspecialchars($row['name']);
    }

    $result = mysqli_query($conn, "SELECT * FROM registered r 
        JOIN staff_coordinator s ON r.event_id = s.event_id 
        JOIN event_info ef ON r.event_id = ef.event_id 
        JOIN student_coordinator st ON r.event_id = st.event_id 
        JOIN events e ON r.event_id = e.event_id 
        WHERE r.usn = '$usn'");
    ?>

    <div class="header">
        <div class="logo">
            <img src="images/evsulogo.png" alt="EVSU Logo">
            <span class="logo-text" style="user-select: none; text-shadow: 2.5px 2.5px black;">(EVSU-OC) Event Management System</span>
        </div>

        <div class="student-name-container">
            <span class="student-name"><?php echo $studentName; ?></span>
            <img src="images/user1.png" alt="User Image">
        </div>

        <form method="post" action="logout.php" class="logout-button" id="logoutForm">
            <button type="button" id="logoutBtn" class="glyphicon glyphicon-log-out"></button>
        </form>
    </div>

    <div class="content" style="margin-top: 120px; padding: 20px;">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1 style="color: green;"><strong>REGISTERED EVENTS</strong></h1>
                </div>
            </div>
            <hr>
            <?php if (mysqli_num_rows($result) > 0) { ?> 
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Event Name</th>
                        <th>Student Co-ordinator</th>
                        <th>Staff Co-ordinator</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Location</th>
                        <th>Price</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = mysqli_fetch_array($result)) { ?>
                    <tr>
                        <td><?php echo $row['event_title']; ?></td>
                        <td><?php echo $row['st_name']; ?></td>
                        <td><?php echo $row['name']; ?></td>
                        <td><?php echo $row['Date']; ?></td>
                        <td><?php echo $row['time']; ?></td>
                        <td><?php echo $row['location']; ?></td>
                        <td><?php echo $row['event_price']; ?></td>
                        <td>
                            <?php if ($row['paid'] == 'Paid') { ?>
                                <span class="badge badge-success" style="background-color: green; color: white;">Paid</span>
                            <?php } elseif ($row['paid'] == 'Cancelled') { ?>
                                <span class="badge badge-danger" style="background-color: red; color: white;">Cancelled</span>
                            <?php } else { ?>
                                <span class="badge badge-secondary">Unpaid</span>
                            <?php } ?>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
            <?php } else { echo 'Not Yet Registered for any events'; } ?>
        </div>
    </div>

    <script>
        document.getElementById('logoutBtn').addEventListener('click', function(event) {
            event.preventDefault();
            
            Swal.fire({
                title: 'Logout Confirmation',
                text: 'Are you sure you want to log out?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#710000',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, logout!',
                cancelButtonText: 'Cancel',
                background: '#fff',
                customClass: {
                    popup: 'swal-wide',
                    title: 'swal-title',
                    content: 'swal-text'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('logoutForm').submit();
                }
            });
        });
    </script>

</body>
</html>