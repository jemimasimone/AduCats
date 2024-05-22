<?php
require 'dbconnection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email']; // Retrieve email from POST data
    $otp = $_POST['otp']; // Retrieve OTP from POST data
    
    // Debug output to see the value of $email
    echo "Email received: " . $email . "<br>";

    // Check if OTP is correct and not expired
    $stmt = $conn->prepare("SELECT id FROM users WHERE email_address = ? AND otp = ? AND otp_expires_at > NOW()");
    $stmt->bind_param("is", $email, $otp);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // Redirect to reset password form with email parameter
        header("Location: ../reset_password_form.php?email=$email");
        exit();
    } else {
        echo "Invalid OTP or OTP has expired.";
    }
}

?>
