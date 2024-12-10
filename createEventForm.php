<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Create-Event (ADMIN)</title>
    <?php require 'utils/styles.php'; ?>
    <style>
        .back-button-container {
            display: flex;
            justify-content: flex-end;
        }
        .content h1 {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        input[type="date"]::-webkit-calendar-picker-indicator {
            cursor: pointer;
        }
        
        input[type="date"]:disabled {
            background-color: #f0f0f0;
            cursor: not-allowed;
        }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const dateInput = document.querySelector('input[name="Date"]');
            
            dateInput.disabled = true;
            dateInput.placeholder = "Loading available dates...";

            let today = new Date();
            let dd = String(today.getDate()).padStart(2, '0');
            let mm = String(today.getMonth() + 1).padStart(2, '0');
            let yyyy = today.getFullYear();
            today = yyyy + '-' + mm + '-' + dd;

            dateInput.min = today;

            let bookedDates = <?php
                include 'classes/db1.php';
                $query = "SELECT Date FROM event_info";
                $result = $conn->query($query);
                $dates = array();
                while($row = $result->fetch_assoc()) {
                    $dates[] = $row['Date'];
                }
                echo json_encode($dates);
            ?>;

            dateInput.addEventListener('input', function(e) {
                if (bookedDates.includes(this.value)) {
                    alert('This date is already booked!');
                    this.value = '';
                }
            });

            dateInput.disabled = false;
        });
    </script>
</head>
<body>
    <?php require 'utils/adminHeader.php'; ?>
    <form method="POST" enctype="multipart/form-data">
        <div class="w3-container"> 
            <div class="content">
                <h1 style="color: #710000; text-shadow: 2px 2px red; user-select: none; font-size: 40px;">
                    <strong>CREATE EVENT</strong>
                    <hr style="margin: 5px;">
                </h1>
                <div class="container">
                    <div class="col-md-6 col-md-offset-3">
                        <div class="back-button-container">
                            <a class="btn btn-danger navbar-btn" href="adminPage.php"><strong>X</strong></a>
                        </div>
                        <h1>
                            <strong style="color: #710000; user-select: none; font-size: 25px">
                                Event Details
                            </strong>
                        </h1>
                        <hr>
                        <label>Event Name</label><br>
                        <input type="text" name="event_title" required class="form-control"><br><br>

                        <label>Event Price</label><br>
                        <input type="text" name="event_price" required class="form-control"><br><br>

                        <label>Image</label><br>
                        <input type="file" name="img_link" accept="image/*" required class="form-control"><br><br>

                        <label>Category</label><br>
                        <select name="type_id" required class="form-control">
                            <option value="" disabled selected style="font-style:italic;">Select Event Category</option>
                            <option value="1">Technical Event</option>
                            <option value="2">Gaming Event</option>
                            <option value="3">On-Stage Event</option>
                            <option value="4">Off-Stage Event</option>
                            <option value="5">Department Day</option>
                            <option value="6">Sports</option>
                        </select><br><br>

                        <label>Event Date</label><br>
                        <input type="date" name="Date" required class="form-control"><br><br>

                        <label>Event Time</label><br>
                        <input type="time" name="time" required class="form-control"><br><br>

                        <label>Event Location</label><br>
                        <input type="text" name="location" required class="form-control"><br><br>

                        <h1><strong style="color: #710000; user-select: none; font-size: 25px">Staff Coordinator</strong></h1>
                        <hr>

                        <input type="text" name="sname" required class="form-control" placeholder="Full Name"><br><br>
                        <input type="number" name="sphone" required class="form-control" placeholder="Mobile Number"><br><br>

                        <h1><strong style="color: #710000; user-select: none; font-size: 25px">Student Coordinator</strong></h1>
                        <hr>

                        <input type="text" name="st_name" required class="form-control" placeholder="Full Name"><br><br>
                        <input type="number" name="st_phone" required class="form-control" placeholder="Mobile Number"><br><br>

                        <button type="submit" name="update" class="btn btn-success pull-right">Create Event <span class="glyphicon glyphicon-send"></span></button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</body>
</html>

<?php
if (isset($_POST["update"])) {
    $event_title = $_POST["event_title"];
    $event_price = $_POST["event_price"];
    $type_id = $_POST["type_id"];
    $name = $_POST["sname"];
    $st_name = $_POST["st_name"];
    $Date = $_POST["Date"];
    $time = $_POST["time"];
    $location = $_POST["location"];
    $sphone = $_POST["sphone"];
    $stphone = $_POST["st_phone"];

    if (!empty($event_title) && !empty($event_price) && !empty($_FILES["img_link"]["name"]) && !empty($type_id) && !empty($name) && !empty($st_name) && !empty($Date) && !empty($time) && !empty($location) && !empty($sphone) && !empty($stphone)) {
        include 'classes/db1.php';
        $current_date = date('Y-m-d');
        if ($Date < $current_date) {
            echo "<script>
                    alert('Cannot create event for past dates');
                    window.location.href='createEventForm.php';
                  </script>";
            exit();
        }

        $check_date = "SELECT * FROM event_info WHERE Date = '$Date'";
        $result = $conn->query($check_date);
        if ($result->num_rows > 0) {
            echo "<script>
                    alert('An event is already scheduled for this date');
                    window.location.href='createEventForm.php';
                  </script>";
            exit();
        }

        $event_id = rand(1000, 9999); 

        $target_dir = "uploads/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        $target_file = $target_dir . basename($_FILES["img_link"]["name"]);
        if (move_uploaded_file($_FILES["img_link"]["tmp_name"], $target_file)) {
            $conn->begin_transaction();

            try {
                $INSERT = "INSERT INTO events(event_id, event_title, event_price, img_link, type_id) VALUES($event_id, '$event_title', '$event_price', '$target_file', $type_id)";
                if ($conn->query($INSERT) === TRUE) {
                    $event_id = $conn->insert_id;

                    $INSERT_INFO = "INSERT INTO event_info (event_id, Date, time, location) VALUES ($event_id, '$Date', '$time', '$location')";
                    $conn->query($INSERT_INFO);

                    $INSERT_STUDENT = "INSERT INTO student_coordinator(sid, st_name, phone, event_id) VALUES ($event_id, '$st_name', '$stphone', $event_id)";
                    $conn->query($INSERT_STUDENT);

                    $INSERT_STAFF = "INSERT INTO staff_coordinator(stid, name, phone, event_id) VALUES ($event_id, '$name', '$sphone', $event_id)";
                    $conn->query($INSERT_STAFF);

                    $conn->commit();

                    echo "<script>
                            alert('Event Inserted Successfully!');
                            window.location.href='adminPage.php';
                          </script>";
                } else {
                    throw new Exception("Error inserting event: " . $conn->error);
                }
            } catch (Exception $e) {
                $conn->rollback();
                echo "<script>
                        alert('Event insertion failed: " . $e->getMessage() . "');
                        window.location.href='createEventForm.php';
                      </script>";
            }

            $conn->close();
        } else {
            echo "<script>
                    alert('File upload failed: " . $_FILES["img_link"]["error"] . "');
                    window.location.href='createEventForm.php';
                  </script>";
        }
    } else {
        echo "<script>
                alert('All fields are required');
                window.location.href='createEventForm.php';
              </script>";
    }
}
?>