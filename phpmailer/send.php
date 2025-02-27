<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';


// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name=$_POST['sender_name'];
    $sender_email = $_POST['sender_email']; // Get sender email from form
    $subject = $_POST['subject'];
    $message = $_POST['message'];
    $department =$_POST['select'];

    // Database Connection
$conn=mysqli_connect("localhost","root","","mails");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch emails from database
$sql = "SELECT email FROM emails where department='$department'";
$result = $conn->query($sql);

$emails = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $emails[] = $row['email'];
    }
}
$conn->close();

    // Validate email format
    if (!filter_var($sender_email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Invalid sender email address.');</script>";
    } else {
        // Initialize PHPMailer
        $mail = new PHPMailer(true);

        try {
            // SMTP Configuration
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com'; // Your SMTP server
            $mail->SMTPAuth = true;
            $mail->Username = 'jacksonbimenyimana3@gmail.com'; // Your Mailtrap username
            $mail->Password = 'sdqe zltc wqyv chse'; // Your Mailtrap password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Use PHPMailer::ENCRYPTION_SMTPS for SSL
            $mail->Port = 587; // 465 for SSL, 587 for TLS

            // Sender info
            $mail->setFrom($sender_email, $name);
            $mail->addReplyTo($sender_email); // Allows recipients to reply to sender
            $mail->Subject = $subject;
            $mail->Body = $message;

            // Add recipients from database
            foreach ($emails as $email) {
                $mail->addAddress($email);
            }

            // Send Email
            if ($mail->send()) {
                echo "<script>alert('Emails sent successfully!');</script>";
            }
        } catch (Exception $e) {
            echo "<script>alert('Email could not be sent. Error: {$mail->ErrorInfo}');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Send Emails</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
</head>
<body>

    <h2>Send Bulk Emails</h2>
    <form method="post">
    <label for="sender_email">Enter Names:</label><br>
    <input type="text" id="sender_name" name="sender_name" required><br><br>
        <label for="sender_email">Your Email:</label><br>
        <input type="email" id="sender_email" name="sender_email" required><br><br>

        <label for="subject">Subject:</label><br>
        <input type="text" id="subject" name="subject" required><br><br>

        <label for="message">Message:</label><br>
        <textarea id="message" name="message" rows="4" required></textarea><br><br>
        <select name="select">
        <option >-- Select Department --</option>
            <?php
            $conn=mysqli_connect("localhost","root","","mails");
            $select=mysqli_query($conn,"SELECT department FROM emails");
            while ($result=mysqli_fetch_array($select)) {
             ?>
             <option value="<?php echo $result['department'] ; ?>"><?php echo $result['department'] ; ?></option>
            <?php
            }
            ?>
        </select>

        <button type="submit">Send Emails</button>
    </form>

</body>
</html>
