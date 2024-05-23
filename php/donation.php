<?php
require 'dbconnection.php';
include 'sessioncheck.php';
check_user_role(1);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_SESSION['user_id'];
    
    // Check if inputs exist in the $_POST array before using them
    $donator = isset($_POST['name']) ? $_POST['name'] : null;
    $email = isset($_POST['email']) ? $_POST['email'] : null;
    $contact = isset($_POST['contactno']) ? $_POST['contactno'] : null;
    $type = isset($_POST['donation-info']) ? $_POST['donation-info'] : null;
    $amount = isset($_POST['amount']) ? $_POST['amount'] : null;
    $goods = isset($_POST['goods']) ? $_POST['goods'] : null;
    $mot = isset($_POST['mop']) ? $_POST['mop'] : null; // corrected name from 'mot' to 'mop'
    $receiver = isset($_POST['receiver']) ? $_POST['receiver'] : null;
    $date = new DateTime();
    $donationDate = $date->format('Y-m-d H:i:s');

    // Check if the required fields are provided
    if (is_null( is_null($type))) {
        die('Some required fields are missing.');
    }

    // Prepare and bind the insert statement
    $stmt = $conn->prepare("INSERT INTO donation (userID, donatorName, email, contactno, donationType, amount, goods, mot, receiver, donationDate)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    if ($stmt === false) {
        throw new Exception('Prepare statement failed: ' . htmlspecialchars($conn->error));
    }

    $stmt->bind_param("isssssssss", $id, $donator, $email, $contact, $type, $amount, $goods, $mot, $receiver, $donationDate);
    if ($stmt->execute() === false) {
        die('Execute() failed: ' . htmlspecialchars($stmt->error));
    }

    $stmt->close();
    $conn->close();
} else {
    die('Invalid request method.');
}
?>

<script>
    alert("Donation form has been successfully submitted");
    // Redirect to login page
    window.location.href = "../homepage.php";
</script>
