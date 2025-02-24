<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // Adjust based on your installation method

$mail = new PHPMailer(true); // Enable exceptions

// SMTP Configuration
$mail->isSMTP();
$mail->Host = 'smtp.gmail.com'; // Your SMTP server
$mail->SMTPAuth = true;
$mail->Username = 'jacksonbimenyimana3@gmail.com'; // Your Mailtrap username
$mail->Password = 'sdqe zltc wqyv chse'; // Your Mailtrap password
$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Use PHPMailer::ENCRYPTION_SMTPS for SSL
$mail->Port = 587; // 465 for SSL, 587 for TLS
// Sender and recipient settings
$mail->setFrom('jacksonbimenyimana3@gmail.com', 'bimenyimana jackson');
$mail->addAddress('sangwajozaphat@gmail.com', 'sangwa josephat');

// Sending plain text email
$mail->isHTML(false); // Set email format to plain text
$mail->Subject = 'Sending mails';
$mail->Body    = 'Hello i hope you are doing well this is all about sending mail';

// Send the email
if(!$mail->send()){
    echo 'Message could not be sent. Mailer Error: ' . $mail->ErrorInfo;
} else {
    echo 'Message has been sent';
}

?>