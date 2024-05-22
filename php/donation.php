<?php 
require 'php/dbconnection.php';

// Prepare and bind the insert statement
$stmt = $conn->prepare("INSERT INTO donation (userID, donatorName, email, contactno, donationType, amount, goods, mot, receiver, donationDate)
VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
if ($stmt === false) {
    throw new Exception('Prepare statement failed: ' . htmlspecialchars($conn->error));
}

// Replace this with the actual user ID from the session
$id = ''; // or use $id = $_SESSION['user_id'];
$donator = $_POST['name'];
$email = $_POST['email'];
$contact = $_POST['contactno'];
$type = $_POST['donation-info'];
$amount = $_POST['email'];
$goods = $_POST['email'];
$mot = $_POST['mot'];
$receiver = $_POST['receiver'];
$date = new DateTime();
$donationDate = $date->format('Y-m-d H:i:s');

$stmt->bind_param("isisssssss", $id, $adopter, $catid, $cat, $email, $contact, $street, $province, $postal, $adoptionDate);
if ($stmt->execute() === false) {
    die('Execute() failed: ' . htmlspecialchars($stmt->error));
}
$stmt->close();
$stmt2->close();
$conn->close();
?>