<?php 
include_once 'classes/db1.php';

function getCategoryName($type_id) {
    switch ($type_id) {
        case 1:
            return 'Technical Event';
        case 2:
            return 'Gaming Event';
        case 3:
            return 'On-Stage Event';
        case 4:
            return 'Off-Stage Event';
        case 5:
            return 'Department Day';
        default:
            return 'Unknown';
    }
}

$id = $_GET['id'];

$sql = "SELECT s.*, e.event_title, e.type_id FROM student_coordinator s 
        INNER JOIN events e ON e.event_id = s.event_id 
        WHERE sid='$id'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$eventName = $row['event_title'];
$category = getCategoryName($row['type_id']);
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>EEMS</title>
    <?php require 'utils/styles.php';?>
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
        #update-button-container {
            text-align: right;
            margin-top: 20px;
        }
        .readonly {
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 5px;
            padding: 7px 10px;
            pointer-events: none;
        }
    </style>
</head>
<body>
    <?php require 'utils/adminHeader.php'; ?>
    <div class="content">
        <div class="container">
            <h1 style="color: #710000; text-shadow: 2px 2px red; user-select: none; font-size: 40px;"><strong>STUDENT CO-ORDINATOR DETAILS</strong></h1>
            <div class="col-md-6 col-md-offset-3">
                <br><br>
                <br>
                <div class="back-button-container">
                    <a class="btn btn-danger" href="Stu_cordinator.php"><strong>X</strong></a>
                </div>
                <form method="POST" id="USForm">
                    <h1><strong style="color: #710000; user-select: none; font-size: 25px">Update Student Coordinator</strong></h1>
                    <hr>
                    <label>FullName:</label><br>
                    <input type="text" name="st_name" required class="form-control" value="<?php echo $row['st_name']; ?>"><br>
                    <label>Mobile Phone:</label><br>
                    <input type="number" name="phone" required class="form-control" value="<?php echo $row['phone']; ?>"><br>
                    <label>Event</label><br>
                    <input type="text" class="form-control readonly" value="<?php echo $eventName; ?>" readonly><br>
                    <label>Category</label><br>
                    <input type="text" class="form-control readonly" value="<?php echo $category; ?>" readonly><br>
                    
                    <div id="update-button-container">
                        <button type="submit" name="update" class="btn btn-success">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>

<?php
if (isset($_POST["update"])) {
    $name = $_POST["st_name"];
    $phone = $_POST["phone"];
    $sql = "UPDATE student_coordinator SET phone='$phone', st_name='$name' WHERE sid='$id'";
    if ($conn->query($sql) === TRUE) {
        echo "<script>
        alert('Studen Coordinator Updated Successfully');
        window.location.href='Stu_cordinator.php';
        </script>";
    } else {
        echo "<script>
        alert('Update Failed');
        window.location.href='updateStudent.php?id=$id';
        </script>";
    }
}
?>
