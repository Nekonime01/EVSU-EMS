<?php
include_once 'classes/db1.php';

$message = '';

if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $event_id = $_POST['event_id'];
    $paid = $_POST['paid'];

    $event_price_query = "SELECT event_price, event_title FROM events WHERE event_id='$event_id'";
    $event_price_result = mysqli_query($conn, $event_price_query);
    if (!$event_price_result) {
        die("Error fetching event price: " . mysqli_error($conn));
    }
    $event_data = mysqli_fetch_assoc($event_price_result);
    $event_price = $event_data['event_price'];
    $event_title = $event_data['event_title'];

    $current_status_query = "SELECT paid FROM registered WHERE usn='$id' AND event_id='$event_id'";
    $current_status_result = mysqli_query($conn, $current_status_query);
    if (!$current_status_result) {
        die("Error fetching current status: " . mysqli_error($conn));
    }
    $current_status = mysqli_fetch_assoc($current_status_result)['paid'];


    $sql = "UPDATE registered SET paid='$paid' WHERE usn='$id' AND event_id='$event_id'";
    if (mysqli_query($conn, $sql)) {
        if ($paid == 'Paid' && $current_status != 'Paid') {
            $payment_update_query = "INSERT INTO payments (total_earnings) VALUES ('$event_price')";
            mysqli_query($conn, $payment_update_query);

            $user_email_query = "SELECT email, name FROM participent WHERE usn='$id'";
            $user_email_result = mysqli_query($conn, $user_email_query);
            if (!$user_email_result) {
                die("Error fetching user email: " . mysqli_error($conn));
            }
            $user_data = mysqli_fetch_assoc($user_email_result);
            $user_email = $user_data['email'];
            $user_name = $user_data['name'];

            $email_subject = "Payment Confirmation for $event_title";
            $email_body = "
                <html>
                <body>
                    <h2>Payment Confirmation</h2>
                    <p>Dear $user_name,</p>
                    <p>We are pleased to inform you that your payment for the event <strong>'$event_title'</strong> has been successfully processed.</p>
                    <p><strong>Amount Paid:</strong> ₹$event_price</p>
                    <p>Thank you for your participation!</p>
                    <br>
                    <p>Best regards,</p>
                    <p>Event Management Team</p>
                    <p>Email: kuraidiner@gmail.com</p>
                </body>
                </html>
            ";
            
            sendEmail($user_email, $email_subject, $email_body);
        }

        if ($paid == 'Cancelled' && $current_status == 'Paid') {
            $payment_subtract_query = "INSERT INTO payments (total_earnings) VALUES ('-$event_price')";
            mysqli_query($conn, $payment_subtract_query);
        }
        
        echo "<script>
        alert('Status Updated Successfully!');
        window.location.href='Stu_details.php';
        </script>";
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }
}

function sendEmail($email, $subject, $body) {
    require 'vendor/autoload.php'; 

    $mail = new PHPMailer\PHPMailer\PHPMailer();

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; 
        $mail->SMTPAuth = true;
        $mail->Username = 'kuraidiner@gmail.com'; 
        $mail->Password = 'kixukurpwkskeomv'; 
        $mail->SMTPSecure = PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom('kuraidiner@gmail.com', 'EEMS');
        $mail->addAddress($email);

        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $body;

        $mail->send();
        echo "<script>alert('Email sent successfully!');</script>";
        return true;
    } catch (Exception $e) {
        echo "<script>alert('Error sending email: " . $mail->ErrorInfo . "');</script>";
        return false;
    }
}

$id = $_GET['id'];
$event_id = $_GET['event_id'];
$sql = "SELECT * FROM participent JOIN registered ON participent.usn = registered.usn WHERE participent.usn='$id'";
$result = mysqli_query($conn, $sql);
if (!$result) {
    die("Error fetching participant details: " . mysqli_error($conn));
}
$row = mysqli_fetch_assoc($result);
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>EEMS</title>
    <?php require 'utils/styles.php'; ?>
</head>
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
    
    #save-button-container {
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
<body>
    <?php require 'utils/adminHeader.php'?>
    <div class="content">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6 col-md-offset-3">
                    <br><br><br>
                    <div class="back-button-container">
                        <a class="btn btn-danger" href="Stu_details.php"><strong>X</strong></a>
                    </div>
                    <?php if ($message): ?>
                    <div class="alert alert-success" role="alert">
                        <?php echo $message; ?> 
                    </div>
                    <?php endif; ?>
                    <form method="POST" action="">
                        <h1><strong style="color: #710000; user-select: none; font-size: 25px">Update Status</strong></h1>
                        <hr>
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="hidden" name="event_id" value="<?php echo $event_id; ?>">
                        <label>Student ID</label><br>
                        <input type="text" class="form-control" name="usn" value="<?php echo htmlspecialchars($_GET['id']); ?>" readonly><br>

                        <label>Name</label><br>
                        <input type="text" class="form-control" name="name" value="<?php echo htmlspecialchars($_GET['name']); ?>" readonly><br>

                        <label>Phone</label><br>
                        <input type="text" class="form-control" name="phone" value="<?php echo htmlspecialchars($_GET['phone']); ?>" readonly><br>

                        <label>Email</label><br>
                        <input type="text" class="form-control" name="email" value="<?php echo htmlspecialchars($_GET['email']); ?>" readonly><br>

                        <label>Event</label><br>
                        <input type="text" class="form-control" name="event_title" value="<?php echo htmlspecialchars($_GET['event_title']); ?>" readonly><br>

                        <label>Price</label><br>
                        <input type="text" class="form-control" name="event_price" value="<?php echo htmlspecialchars($_GET['event_price']); ?>" readonly><br>

                        <label>Status:</label>
                        <select name="paid" class="form-control d-inline-block">
                            <option value="Paid" <?php if ($row['paid'] == "Paid") echo 'selected'; ?>>Paid</option>
                            <option value="Cancelled" <?php if ($row['paid'] == "Cancelled") echo 'selected'; ?>>Cancelled</option>
                        </select>
                        <div id="save-button-container">
                            <button type="submit" name="update" class="btn btn-success">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>