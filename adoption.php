<?php
require 'php/dbconnection.php';

if (isset($_POST['submit_adoption'])) {
    // Prepare and bind the insert statement
    $stmt = $conn->prepare("INSERT INTO adoption (userID, adopterName, catID, catName, email, contactno, street, province, postal, adoptionDate) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    if ($stmt === false) {
        throw new Exception('Prepare statement failed: ' . htmlspecialchars($conn->error));
    }

    $cat = $_POST['cat'];

    // Retrieve catID based on catName
    $query = "SELECT catID FROM cats WHERE catName = ?";
    $stmt2 = $conn->prepare($query);
    if ($stmt2 === false) {
        throw new Exception('Prepare statement failed: ' . htmlspecialchars($conn->error));
    }
    $stmt2->bind_param("s", $cat);
    $stmt2->execute();
    $result = $stmt2->get_result();
    $row = $result->fetch_assoc();

    // Replace this with the actual user ID from the session
    $id = ''; // or use $id = $_SESSION['user_id'];
    $adopter = $_POST['name'];
    $catid = $row['catID'];
    $email = $_POST['email'];
    $contact = $_POST['contactno'];
    $street = $_POST['street'];
    $province = $_POST['province'];
    $postal = $_POST['postal'];
    $date = new DateTime();
    $adoptionDate = $date->format('Y-m-d H:i:s');

    $stmt->bind_param("isisssssss", $id, $adopter, $catid, $cat, $email, $contact, $street, $province, $postal, $adoptionDate);
    if ($stmt->execute() === false) {
        die('Execute() failed: ' . htmlspecialchars($stmt->error));
    }
    $stmt->close();
    $stmt2->close();
    $conn->close();
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
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Aoboshi+One&display=swap" rel="stylesheet">
</head>

<body>
    <header class="logo">
        <img src="img/Cat-2.png" alt="logo_cat">
        <h1>Adoption</h1>
    </header>
    <div class="hline"></div>
    <section>
        <form action="adoption.php" method="post">
            <div>
                <h3>Adopter</h3>
                <div class="grid-container">
                    <div class="row">
                        <input type="text" id="name" placeholder="Name" name="name">
                        <input type="text" id="emailAddress" placeholder="Email Address" name="email">
                        <input type="text" id="phoneNumber" name="contactno" pattern="[0-9]{11}" placeholder="Phone Number" title="Please enter a valid 11-digit phone number">
                    </div>
                    
                    <div class="row">
                        <input type="date" id="birthdate" class="small-input" placeholder="Birthdate" name="birthdate">
                        <label for="gender">Gender: </label>
                        <select name="gender" id="gender" class="small-input">
                            <option value="">Gender</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                    </div>

                    <div class="row">
                        <input type="text" id="address1" placeholder="Address 1 (street and barangay)" name="street">
                        <input type="text" id="address2" placeholder="Address 2 (region/province)" name="province">
                        <input type="text" id="address3" placeholder="Address 3 (postal code)" name="postal">
                    </div>
                </div>
            </div>

            <div>
                <h3>Cat</h3>
                <div class="grid-container">
                    <div class="row">
                        <select name="cat" id="catDropdown">
                            <?php
                            $query = "SELECT catName FROM cats WHERE adoptionStatus = ?";
                            $stmt = $conn->prepare($query);
                            $adoptionStatus = 'For Adoption'; // Assign the value to a variable
                            $stmt->bind_param("s", $adoptionStatus);
                            $stmt->execute();
                            $result = $stmt->get_result();

                            if ($result->num_rows > 0) {
                                // Fetch rows inside the loop
                                while ($row = $result->fetch_assoc()) {
                                    echo '<option value="' . $row['catName'] . '">' . $row['catName'] . '</option>';
                                }
                            } else {
                                echo '<option value="">No cats available for adoption</option>';
                            }

                            // Free result set and close statement
                            // $result->free_result();
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
                        <input type="text" id="messageEmail" name="emailadd" placeholder="Email Address">
                    </div>
                    <div class="row">
                        <input type="text" id="subject" name="subject" placeholder="Subject">
                    </div>
                    <div class="row">
                        <textarea class="comments" name="comments">Comments</textarea>
                    </div>
                </div>
            </div>

            <div class="submit-btn">
                <button class="submit" type="submit" name="submit_adoption">SUBMIT</button>
            </div>
        </form>
    </section>

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
        const registerForm = document.querySelector('form'); // Assuming your form has a tag

        registerForm.addEventListener('submit', function(event) {
        const selectedGender = genderSelect.value;
        if (selectedGender === "") {
            event.preventDefault(); // Prevent form submission
            alert("Please select your gender.");
        }
        });

        document.getElementById('gender').addEventListener('change', function() {
        if (this.value) {
            this.style.color = 'black';
        } else {
            this.style.color = '#757575'; // default color for the placeholder
        }
        });
    </script>

</body>
</html>
