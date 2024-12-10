<?php
include_once 'classes/db1.php';

if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Event ID is missing.");
}

$id = mysqli_real_escape_string($conn, $_GET['id']);

$query = "SELECT e.event_title, e.event_price, ef.Date, ef.time, ef.location, e.type_id
          FROM events e
          INNER JOIN event_info ef ON e.event_id = ef.event_id
          WHERE e.event_id = '$id'";
$result = mysqli_query($conn, $query);
if (!$result) {
    die("Query Failed: " . mysqli_error($conn));
}
$event = mysqli_fetch_assoc($result);
if (!$event) {
    die("Event not found.");
}

if (isset($_POST["update"])) {
    $event_title = mysqli_real_escape_string($conn, $_POST["event_title"]);
    $event_price = intval($_POST["event_price"]);
    $date = mysqli_real_escape_string($conn, $_POST["Date"]);
    $time = mysqli_real_escape_string($conn, $_POST["time"]);
    $location = mysqli_real_escape_string($conn, $_POST["location"]);
    $type_id = intval($_POST["type_id"]);

    $sql_event_info = "UPDATE event_info SET Date='$date', time='$time', location='$location' WHERE event_id='$id'";
    if ($conn->query($sql_event_info) === TRUE) {
        $sql_events = "UPDATE events SET event_title='$event_title', event_price=$event_price, type_id=$type_id WHERE event_id='$id'";
        if ($conn->query($sql_events) === TRUE) {
            echo "<script>alert('Event Updated Successfully.');
            window.location.href='adminPage.php'</script>";
        } else {
            echo "<script>alert('Error updating event: " . mysqli_error($conn) . "');</script>";
        }
    } else {
        echo "<script>alert('Error updating event info: " . mysqli_error($conn) . "');</script>";
    }
}
?>

<!DOCTYPE HTML>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Update Event</title>
    <?php require 'utils/styles.php'; ?>
</head>
<style>
    .back-button-container {
        display: flex;
        justify-content: flex-end;
    }

    #update-button-container {
        text-align: right;
        margin-top: 20px;
    }
</style>
<body>
    <?php require 'utils/adminHeader.php'; ?>
    <div class="content">
        <div class="container">
            <h1 style="color: #710000; text-shadow: 2px 2px red; user-select: none; font-size: 40px;"><strong>EVENT DETAILS</strong></h1>
            <div class="col-md-6 col-md-offset-3">
                <div class="back-button-container">
                    <a class="btn btn-danger" href="adminPage.php"><strong>X</strong></a>
                </div>
                <form method="POST">
                    <div class="form-group">
                        <h1><strong style="color: #710000; user-select: none; font-size: 25px">Update Event</strong></h1>
                        <hr>
                        <label>Event Name</label>
                        <input type="text" name="event_title" value="<?php echo isset($event['event_title']) ? htmlspecialchars($event['event_title']) : ''; ?>" required class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Price</label>
                        <input type="number" name="event_price" value="<?php echo isset($event['event_price']) ? htmlspecialchars($event['event_price']) : ''; ?>" required class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Date</label>
                        <input type="date" name="Date" value="<?php echo isset($event['Date']) ? htmlspecialchars($event['Date']) : ''; ?>" required class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Time</label>
                        <input type="time" name="time" value="<?php echo isset($event['time']) ? htmlspecialchars($event['time']) : ''; ?>" required class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Location</label>
                        <input type="text" name="location" value="<?php echo isset($event['location']) ? htmlspecialchars($event['location']) : ''; ?>" required class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Category</label><br>
                        <select name="type_id" required class="form-control">
                            <option value="" disabled selected style="font-style:italic;">Select Event Category</option>
                            <option value="1" <?php if ($event['type_id'] == 1) echo 'selected'; ?>>Technical Event</option>
                            <option value="2" <?php if ($event['type_id'] == 2) echo 'selected'; ?>>Gaming Event</option>
                            <option value="3" <?php if ($event['type_id'] == 3) echo 'selected'; ?>>On-Stage Event</option>
                            <option value="4" <?php if ($event['type_id'] == 4) echo 'selected'; ?>>Off-Stage Event</option>
                            <option value="5" <?php if ($event['type_id'] == 5) echo 'selected'; ?>>Department Day</option>
                        </select><br><br>
                    </div>
                    <div id="update-button-container">
                        <button type="submit" name="update" class="btn btn-success">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
