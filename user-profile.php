<?php
require 'php/dbconnection.php';
include 'php/sessioncheck.php';
check_user_role(1);

$user_id = $_SESSION['user_id'];

// Fetch user data
$user_query = "SELECT first_name, middle_name, last_name, suffix, username, birthdate, email_address, password, role
FROM users WHERE id = ?";
$user_stmt = $conn->prepare($user_query);
$user_stmt->bind_param("i", $user_id);
$user_stmt->execute();
$user_result = $user_stmt->get_result();
$user_data = $user_result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>User Profile | AdU Cats</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- LINKS -->
    <link rel="stylesheet" href="style/user-profile.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Aoboshi+One&display=swap" rel="stylesheet">
</head>

<body>
    <header class="logo">
    <a href="homepage.php">
            <img src="img/Cat-2.png" alt="logo_cat">
        </a>
        <h1>Profile</h1>
    </header>
    <div class="hline"></div>

    <section class="user-content">
    <form id="profile-form" action="php/edit_profile.php" method="post">
        <div class="upper">
            <h3>Account Information</h3>
            <div class="grid-container">
                <div class="row">
                    <input type="text" id="username" name="username" placeholder="Username" value="<?php echo $user_data['username']; ?>" class="readonly" readonly>
                    <input type="text" id="emailAddress" name="emailAddress" placeholder="Email Address" value="<?php echo $user_data['email_address']; ?>" class="readonly" readonly>
                </div>
                <div class="row">
                    <input type="password" id="password" name="password" placeholder="Password" class="readonly" readonly>
                </div>
            </div>
        </div>
        <div class="lower">
            <h3>Personal Information</h3>
            <div class="grid-container">
                <div class="row">
                    <input type="text" id="firstName" name="firstName" placeholder="First Name" value="<?php echo $user_data['first_name']; ?>" class="readonly" readonly>
                    <input type="text" id="middleName" name="middleName" placeholder="Middle Name" value="<?php echo $user_data['middle_name']; ?>" class="readonly" readonly>
                </div>
                <div class="row">
                    <input type="text" id="lastName" name="lastName" placeholder="Last Name" value="<?php echo $user_data['last_name']; ?>" class="readonly" readonly>
                    <input type="text" id="suffix" name="suffix" placeholder="Suffix" value="<?php echo $user_data['suffix']; ?>" class="readonly" readonly>  
                </div>
                <div class="row">
                    <input type="date" name="birthdate" id="birthdate" class="small-input readonly" placeholder="Birthdate" value="<?php echo $user_data['birthdate']; ?>" readonly>
                </div>
            </div>
        </div>
        <div class="btn">
            <button type="button" id="changePasswordBtn" class="changePassword">CHANGE PASSWORD</button>
            <button type="button" id="editBtn" class="edit">EDIT</button>
            <button type="submit" id="saveBtn" class="edit">SAVE</button>
        </div>
    </form>

    <div id="passwordPopup" class="popup">
        <div class="popup-content">
            <span class="close" onclick="closePasswordPopup()">&times;</span>
            <h3 class="change">Change Password</h3>
            <form id="password-form" method="post" action="php/change_password.php">
                <input type="password" id="currentPassword" name="currentPassword" placeholder="Current Password" required>
                <input type="password" id="newPassword" name="newPassword" placeholder="New Password" required>
                <input type="password" id="confirmPassword" name="confirmPassword" placeholder="Confirm Password" required>
                <button type="submit" class="changePassword">SAVE</button>
            </form>
        </div>
    </div>
    </section>

    <script>
    const editBtn = document.getElementById('editBtn');
    const saveBtn = document.getElementById('saveBtn');
    const inputs = document.querySelectorAll('input');

    // Initially, hide the save button
    saveBtn.style.display = 'none';

    editBtn.addEventListener('click', function() {
        // Hide the edit button and show the save button
        editBtn.style.display = 'none';
        saveBtn.style.display = 'inline-block';

        // Enable input fields for editing
        inputs.forEach(input => {
            input.removeAttribute('readonly');
        });
    });

    saveBtn.addEventListener('click', function() {
        // Hide the save button and show the edit button
        saveBtn.style.display = 'none';
        editBtn.style.display = 'inline-block';

        // Disable input fields after saving
        inputs.forEach(input => {
            input.setAttribute('readonly', 'readonly');
        });

    });

    function closePasswordPopup() {
        document.getElementById('passwordPopup').style.display = 'none';
    }

    document.getElementById('changePasswordBtn').addEventListener('click', function() {
        document.getElementById('passwordPopup').style.display = 'flex';
    });

    // document.getElementById('password-form').addEventListener('submit', function(e) {
    //     e.preventDefault();
    //     // Collect the form data
    //     let formData = new FormData(this);

    //     // Send an AJAX request to change the password
    //     fetch('php/change_password.php', {
    //         method: 'POST',
    //         body: formData
    //     })
    //     .then(response => response.text())
    //     .then(data => {
    //         alert(data);
    //         closePasswordPopup();
    //     })
    //     .catch(error => {
    //         console.error('Error:', error);
    //     });
    // });
</script>


</body>
</html>
