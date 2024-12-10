<?php
include_once 'classes/db1.php';

if(isset($_GET['usn'])) {
    $usn = mysqli_real_escape_string($conn, $_GET['usn']);

    $sql = "DELETE FROM participent WHERE usn='$usn'";

    if (mysqli_query($conn, $sql)) {
        echo "<script>
                alert('Participant deleted successfully.');
                window.location.href='participent.php';
              </script>";
    } else {
        echo "<script>
                alert('Error deleting participant.');
                window.location.href='index.php';
              </script>";
    }

    $conn->close();
} else {
    echo "<script>
            alert('Invalid request.');
            window.location.href='index.php';
          </script>";
}
?>
