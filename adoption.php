<?php
require 'php/dbconnection.php';
include 'php/sessioncheck.php';
check_user_role(1);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

if (isset($_POST['submit_adoption'])) {

    try {
        // Start transaction
        $conn->begin_transaction();

        // Retrieve catID based on catName
        $cat = $_POST['cat'];
        $stmt2 = $conn->prepare("SELECT catID FROM cats WHERE catName = ?");
        if ($stmt2 === false) {
            throw new Exception('Prepare statement failed: ' . htmlspecialchars($conn->error));
        }
        $stmt2->bind_param("s", $cat);
        $stmt2->execute();
        $result = $stmt2->get_result();
        if ($result->num_rows === 0) {
            throw new Exception('Cat not found.');
        }
        $row = $result->fetch_assoc();
        $catid = $row['catID'];
        $stmt2->close();

        // User ID from session
        if (!isset($_SESSION['user_id'])) {
            throw new Exception('User not logged in.');
        }
        $id = $_SESSION['user_id'];

        // Gather other form data
        $adopter = $_POST['name'];
        $email = $_POST['email'];
        $contact = $_POST['contactno'];
        $street = $_POST['street'];
        $province = $_POST['province'];
        $postal = $_POST['postal'];
        $status = "Pending";
        $date = new DateTime();
        $adoptionDate = $date->format('Y-m-d H:i:s');

        // Prepare and execute insert statement
        $stmt = $conn->prepare("INSERT INTO adoption (userID, adopterName, catID, catName, email, contactno, street, province, postal, adoptionDate, adoptionStatus) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        if ($stmt === false) {
            throw new Exception('Prepare statement failed: ' . htmlspecialchars($conn->error));
        }
        $stmt->bind_param("isissssssss", $id, $adopter, $catid, $cat, $email, $contact, $street, $province, $postal, $adoptionDate, $status);
        if ($stmt->execute() === false) {
            throw new Exception('Execute failed: ' . htmlspecialchars($stmt->error));
        }
        $stmt->close();

        // Commit transaction
        $conn->commit();

        // Send confirmation email using PHPMailer
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
            $mail->addAddress("sparkyahjussi@gmail.com"); // Recipient's email address from form

            $mail->isHTML(true);
            $mail->Subject = $_POST['subject'];
            $mail->Body = $_POST['comments'];

            $mail->send();

            echo
            "
            <script>
            alert('Request Sent Succesfully');
            document.location.href = 'adoption.php';
            </script>
            ";
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }

        $conn->close();
    } catch (Exception $e) {
        // Rollback transaction in case of error
        $conn->rollback();
        echo "Error: " . $e->getMessage();
    }

    // Redirect to homepage.html after successful insertion
    header('Location: homepage.php');
    exit();
}
?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Adopt | AdU Cats</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- LINKS -->
    <link rel="stylesheet" href="style/form.css">
    <link rel="icon" href="img/WhiteLogoCat.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Aoboshi+One&display=swap" rel="stylesheet">
</head>

<body>
    <header class="logo">
        <a href="homepage.php">
            <img src="img/Cat-2.png" alt="logo_cat">
        </a>
        <h1>Adoption</h1>
    </header>




    <!-- LINKS -->

    <div class="AdoptForm">
        <form action="adoption.php" method="post">
            <div>
                <h3>Adopter</h3>
                <div class="grid-container">
                    <div class="row">

                        <div class="PersonalInfo">
                            <p>Personal Information</p>
                            <input type="text" id="name" placeholder="Name" name="name" required>
                            <input type="email" id="emailAddress" placeholder="Email Address" name="email" required>
                            <input type="tel" id="phoneNumber" name="contactno" pattern="[0-9]{11}" placeholder="Phone Number" title="Please enter a valid 11-digit phone number" required>

                            <input type="date" id="birthdate" class="small-input" placeholder="Birthdate" name="birthdate" required>
                            <select name="gender" id="gender" class="small-input" required>
                                <option value="">Gender</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                        </div>


                        <div class="Addresses">



                            <p>Address Information</p>
                            <input type="text" id="address1" placeholder="Address 1 (street and barangay)" name="street" required>
                            <input type="text" id="address2" placeholder="Address 2 (region/province)" name="province" required>
                            <input type="text" id="address3" placeholder="Address 3 (postal code)" name="postal" required>

                        </div>
                    </div>
                </div>
            </div>

            <div class="cat">
                <h3>Cat</h3>
                <div class="grid-container">
                    <div class="row">
                        <select name="cat" id="catDropdown" required>
                            <?php
                            $query = "SELECT catName FROM cats WHERE adoptionStatus = ?";
                            $stmt = $conn->prepare($query);
                            $adoptionStatus = 'For Adoption';
                            $stmt->bind_param("s", $adoptionStatus);
                            $stmt->execute();
                            $result = $stmt->get_result();

                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo '<option value="' . $row['catName'] . '">' . $row['catName'] . '</option>';
                                }
                            } else {
                                echo '<option value="">No cats available for adoption</option>';
                            }
                            $stmt->close();
                            ?>
                        </select>
                    </div>
                </div>
            </div>

            <div>
                <h3>Message</h3>
                <div class="grid-container">
                    <div class="row">
                        <input type="text" id="subject" name="subject" placeholder="Subject" required>
                    </div>
                    <div class="row">
                        <textarea rows="10" cols="100" class="comments" name="comments" placeholder="Message" required></textarea>
                    </div>
                </div>


            </div>
            <div class="submit-btn">
                <button class="submit" type="submit" name="submit_adoption">SUBMIT</button>
            </div>


        </form>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var commentsTextarea = document.querySelector(".comments");

            commentsTextarea.addEventListener("focus", function() {
                if (this.value === "Comments") {
                    this.value = "";
                }
            });

            commentsTextarea.addEventListener("blur", function() {
                if (this.value === "") {
                    this.value = "Comments";
                }
            });
        });

        const genderSelect = document.getElementById('gender');
        const registerForm = document.querySelector('form');

        registerForm.addEventListener('submit', function(event) {
            const selectedGender = genderSelect.value;
            if (selectedGender === "") {
                event.preventDefault();
                alert("Please select your gender.");
            }
        });

        document.getElementById('gender').addEventListener