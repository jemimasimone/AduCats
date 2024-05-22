<?php
require 'dbconnection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Check if passwords match
    if ($password !== $confirm_password) {
        echo '<script>
                    alert("Passwords do not match.");
                    window.location.href = "../reset_password_form.php";
                  </script>';
        exit();
    }

    // Update password in the database
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $conn->prepare("UPDATE users SET password = ? WHERE email_address = ?");
    $stmt->bind_param("ss", $hashed_password, $email);

    if ($stmt->execute()) {
        // Clear OTP fields
        $stmt = $conn->prepare("UPDATE users SET otp = NULL, otp_expires_at = NULL WHERE email_address = ?");
        $stmt->bind_param("s", $email);

        if ($stmt->execute()) {
            echo '<script>
                    alert("Password changed");
                    window.location.href = "../login.html";
                  </script>';
        } else {
            echo "Error clearing OTP fields: " . $stmt->error;
        }
    } else {
        echo "Error updating password: " . $stmt->error;
    }
}
?>
