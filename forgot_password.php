<?php
require 'php/dbconnection.php';
include 'php/sessioncheck.php';
check_user_role(1);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Forgot Password | AdU Cats</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="style/login.css">
</head>
<body>
    <div class="login_content">
        <div class="right_side">
            <div class="login_container">
                <h2>Forgot Password</h2>
                <form action="php/send_otp.php" method="POST">
                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email" placeholder="Enter your email" required>
                    <button class="login_button" type="submit">Submit</button>
                </form>
                <p><a href="login.html">Back to Login</a></p>
            </div>
        </div>
    </div>
</body>
</html>
