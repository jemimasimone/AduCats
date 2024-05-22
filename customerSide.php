<!-- Pangcheck toh if naka log in ka sa system -->
<?php include 'php/sessioncheck.php'; ?>
<!-- Naka "1" sya kase chinecheck nya if customer ka, kapag admin ka pwede parin -->
<?php check_user_role(1); ?> <!-- "1" nakalagay kase may restriction, bawal sya makapunta sa admin side -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Side</title>
</head>
<body>
    <h1>Welcome to the Customer Side of AduCats</h1>
    <p><a href="php/logout.php">Logout</a></p> <!-- Logout link -->
    <?php
    if ($_SESSION['user_role'] == 2) {
        echo '<p><a href="adminSide.php">Go to Admin side</a>.</p>';
    } else {
        echo '<p>You do not have access to Admin side.</p>';
    }
    ?>
    <!-- Page content here -->
</body>
</html>
