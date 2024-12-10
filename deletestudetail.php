<?php
require 'classes/db1.php';
$id = $_GET['id'];

$conn->begin_transaction();

try {
    $sql = "DELETE FROM registered WHERE event_id = '$id'";

    if ($conn->query($sql) === true) {
        $updateSql = "UPDATE events SET participents = participents - 1 WHERE event_id = '$id'";
        
        if ($conn->query($updateSql) === true) {
            $conn->commit();
            echo "<script>
                alert('Student Detail Deleted successfully.');
                window.location.href = 'Stu_details.php';
            </script>";
        } else {
            $conn->rollback();
            echo "Error updating participant count: " . $conn->error;
        }
    } else {
        $conn->rollback();
        echo "Error deleting participant: " . $conn->error;
    }
} catch (Exception $e) {
    $conn->rollback();
    echo "Transaction failed: " . $e->getMessage();
}

$conn->close();
?>
