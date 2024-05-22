<?php
require 'dbconnection.php';
require '../phpmailer/src/Exception.php';
require '../phpmailer/src/PHPMailer.php';
require '../phpmailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    
    // Check if email exists in the database
    $stmt = $conn->prepare("SELECT id FROM users WHERE email_address = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // Email exists, generate OTP
        $otp = rand(100000, 999999);

        // Store OTP in the database
        $stmt->close();
        $stmt = $conn->prepare("UPDATE users SET otp = ?, otp_expires_at = DATE_ADD(NOW(), INTERVAL 10 MINUTE) WHERE email_address = ?");
        $stmt->bind_param("is", $otp, $email);
        $stmt->execute();
        $stmt->close();

        // Send OTP via email
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'sparkyahjussi@gmail.com';
            $mail->Password = 'wkmhaqyyegfoijjp';
            $mail->SMTPSecure = 'ssl';
            $mail->Port = 465;

            $mail->setFrom('sparkyahjussi@gmail.com', 'AdU Cats');
            $mail->addAddress($email);

            $mail->isHTML(true);
            $mail->Subject = 'Password Reset OTP';
            $mail->Body = "Your OTP is: $otp";

            $mail->send();
            header("Location: ../verify_otp.php?email=$email");
            exit();
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    } else {
        // Email does not exist, alert user
        echo '<script>
                alert("Email does not exist.");
                window.location.href = "../forgot_password.html";
              </script>';
    }
}
?>
