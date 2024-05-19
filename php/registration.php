<?php
// Include the database connection file
require 'dbconnection.php';

// Prepare and bind
$stmt = $conn->prepare("INSERT INTO users (first_name, middle_name, last_name, suffix, username, birthdate, email_address, password, role) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
if ($stmt === false) {
    die('Prepare() failed: ' . htmlspecialchars($conn->error));
}

$first_name = $_POST['firstName'];
$middle_name = $_POST['middleName'];
$last_name = $_POST['lastName'];
$suffix = $_POST['suffix'];
$username = $_POST['username'];
$birthdate = $_POST['birthdate'];
$email_address = $_POST['emailAddress'];
$hashed_password = password_hash($_POST['password'], PASSWORD_DEFAULT);
$role = $_POST['role'];

$stmt->bind_param("sssssssss", $first_name, $middle_name, $last_name, $suffix, $username, $birthdate, $email_address, $hashed_password, $role);

if ($stmt->execute() === false) {
    die('Execute() failed: ' . htmlspecialchars($stmt->error));
}

//header("Location: ../login.html"); 

$stmt->close();
$conn->close();
?>

<script>
    alert("Registration successful! You can now login.");
    // Redirect to login page
    window.location.href = "../login.html";
</script>
