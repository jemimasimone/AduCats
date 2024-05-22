<?php
session_start();

// Function to redirect with an alert
function redirect_with_alert($message, $location) {
    echo '<script>
            alert("' . $message . '");
            window.location.href = "' . $location . '";
          </script>';
    exit();
}

// Check if user is logged in
if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_role'])) {
    // If not logged in, show an alert and redirect to login page
    redirect_with_alert("You are not logged in. Redirecting to login page...", "login.html");
}

// Function to check user role
function check_user_role($required_role) {
    if ($_SESSION['user_role'] < $required_role) {
        // If role does not match, show an alert and go back to the previous page
        echo '<script>
                alert("Error: You do not have access to this page.");
                window.history.back();
              </script>';
        exit();
    }
}
?>
