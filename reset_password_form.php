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
    <title>Reset Password | AdU Cats</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="style/login.css">
</head>
<body>
    <div class="login_content">
        <div class="right_side">
            <div class="login_container">
                <h2>Reset Password</h2>
                <form action="php/reset_password.php" method="POST">
                    <input type="hidden" id="email" name="email" value="<?php echo htmlspecialchars($_GET['email'] ?? ''); ?>">
                    <label for="password">New Password</label>
                    <input type="password" id="password" name="password" placeholder="Enter new password" required>
                    <label for="confirm_password">Confirm Password</label>
                    <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm new password" required>
                    <button class="login_button" type="submit">Reset Password</button>
                </form>
                <p><a href="login.html">Back to Login</a></p>
            </div>
        </div>
    </div>
</body>
</html>
