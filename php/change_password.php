<?php
require 'dbconnection.php';
include 'sessioncheck.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $current = $_POST['currentPassword'];
    $new = $_POST['newPassword'];
    $confirm = $_POST['confirmPassword'];

    // Retrieve existing hashed password from the database
    $stmt = $conn->prepare("SELECT password FROM users WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->store_result();
    
    // Check if user exists
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($hashed_password);
        $stmt->fetch();
        
        // Verify if the input current password matches the hashed password
        if (password_verify($current, $hashed_password)) {
            // Check if new password matches the confirmed password
            if ($new !== $confirm) {
                echo '<script>
                        alert("Passwords do not match");
                        window.location.href = "../user-profile.php";
                    </script>';
                exit();
            }

            // Update password in the database
            $hashed_new_password = password_hash($new, PASSWORD_DEFAULT);
            $update_stmt = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
            $update_stmt->bind_param("si", $hashed_new_password, $user_id);

            if ($update_stmt->execute()) {
                $update_stmt->close();
                echo '<script>
                        alert("Password changed successfully");
                        window.location.href = "../user-profile.php";
                    </script>';
                exit();
            } else {
                echo "Error changing password: " . $update_stmt->error;
            }
        } else {
            echo '<script>
                    alert("Current password is incorrect");
                    window.location.href = "../user-profile.php";
                </script>';
            exit();
        }
    } else {
        echo "User not found";
    }
}
?>
