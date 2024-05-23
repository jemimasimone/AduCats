<?php
require 'dbconnection.php';
include 'sessioncheck.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $username = $_POST['username'];
    $emailAddress = $_POST['emailAddress'];
    $firstName = $_POST['firstName'];
    $middleName = $_POST['middleName'];
    $lastName = $_POST['lastName'];
    $suffix = $_POST['suffix'];
    $birthdate = $_POST['birthdate'];

    // Update user data
    $update_query = "UPDATE users SET username = ?, email_address = ?, first_name = ?, middle_name = ?, last_name = ?, suffix = ?, birthdate = ? WHERE id = ?";
    $update_stmt = $conn->prepare($update_query);
    $update_stmt->bind_param("sssssssi", $username, $emailAddress, $firstName, $middleName, $lastName, $suffix, $birthdate, $user_id);

    if ($update_stmt->execute()) {
        header("Location: ../user-profile.php");
        exit();
    } else {
        echo "Failed to update profile. Please try again.";
    }
}
?>
