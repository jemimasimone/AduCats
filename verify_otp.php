<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Verify OTP | AdU Cats</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="style/login.css">
</head>
<body>
    <div class="login_content">
        <div class="right_side">
            <div class="login_container">
                <h2>Verify OTP</h2>
                <form action="php/verify_otp.php" method="POST">
                    <label for="otp">Enter OTP</label>
                    <input type="text" id="otp" name="otp" placeholder="Enter OTP" required>
                    <input type="hidden" name="email" value="<?php echo htmlspecialchars($_GET['email']); ?>">
                    <button class="login_button" type="submit">Verify OTP</button>
                </form>
                <p><a href="login.html">Back to Login</a></p>
            </div>
        </div>
    </div>
</body>
</html>
