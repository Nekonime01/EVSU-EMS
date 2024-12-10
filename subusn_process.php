<?php
if (isset($_POST['event_name'])) {
    $usn = $_POST["usn"];
    $eventName = $_POST['event_name'];
    $eventID = intval($_POST['event_id']);

    if (!empty($usn)) {
        include 'classes/db1.php';
        $check_query = mysqli_query($conn, "SELECT * FROM participent WHERE usn = '$usn'");
        if (mysqli_num_rows($check_query) > 0) {
            $check_registration_query = mysqli_query($conn, "SELECT * FROM registered WHERE usn = '$usn' AND event_id = $eventID");
            if (mysqli_num_rows($check_registration_query) > 0) {
                echo "<script>
                    alert('Already Registered for this Event');
                    window.location.href='index.php';
                </script>";
            } else {
                $insert_query = "INSERT INTO registered (usn, event_id) VALUES ('$usn', $eventID)";
                if ($conn->query($insert_query) === true) {
                    echo "<script>
                        alert('Registered Successfully!');
                        window.location.href='index.php';
                    </script>";
                } else {
                    echo "<script>
                        alerts('Registration failed. Please try again.');
                        window.location.href='usn.php';
                    </script>";
                }
            }
        } else {
            echo "<script>
                alert('Invalid USN. Please enter a valid USN.');
                window.location.href='usn.php';
            </script>";
        }
        $conn->close();
    } else {
        echo "<script>
            alert('USN field is required');
            window.location.href='usn.php';
        </script>";
    }
}
?>