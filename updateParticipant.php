<?php
include_once 'classes/db1.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usn = mysqli_real_escape_string($conn, $_POST['usn']);
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $branch = mysqli_real_escape_string($conn, $_POST['branch']);
    $sem = mysqli_real_escape_string($conn, $_POST['sem']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $college = mysqli_real_escape_string($conn, $_POST['college']);

    $sql = "UPDATE participent 
            SET name='$name', branch='$branch', sem='$sem', email='$email', phone='$phone', college='$college' 
            WHERE usn='$usn'";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Student Updated Successfully');
        window.location.href='participent.php';</script>";
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }
}

if(isset($_GET['usn'])) {
    $usn = mysqli_real_escape_string($conn, $_GET['usn']);
    $sql = "SELECT * FROM participent WHERE usn='$usn'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
} else {
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Update Participant</title>
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
        #update-button-container {
            text-align: right;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <?php require 'utils/adminHeader.php'; ?>
<div class="content">
    <div class="container">
        <div class="col-md-6 col-md-offset-3">
            <div class="back-button-container">
                <a class="btn btn-danger" href="participent.php"><strong>X</strong></a>
            </div>
        <form method="POST" action="">
            <h1><strong style="color: #710000; user-select: none; font-size: 25px">Update Student</strong></h1>
            <hr>
        <input type="hidden" name="usn" class="form-control" value="<?php echo $row['usn']; ?>">
        <label>Name:</label><br>
        <input type="text" name="name" class="form-control" value="<?php echo $row['name']; ?>"><br>
        <label>Course:</label><br>
        <input type="text" name="branch" class="form-control" value="<?php echo $row['branch']; ?>"><br>
        <label>Semester:</label><br>
        <select name="sem" class="form-control">
                        <option value="1">1 Semester</option>
                        <option value="2">2 Semester</option>
                </select><br>
        <label>Email:</label><br>
        <input type="text" name="email" class="form-control" value="<?php echo $row['email']; ?>"><br>
        <label>Phone:</label><br>
        <input type="text" name="phone" class="form-control" value="<?php echo $row['phone']; ?>"><br>
        <label>College:</label><br>
        <input type="text" name="college" class="form-control" style="pointer-events: none;" readonly value="<?php echo $row['college']; ?>"><br>
        <div id="update-button-container">
            <input type="submit" class="btn btn-success" value="Update">
        </div>
        </form>
        </div>
    </div>
</div>
</body>
</html>
