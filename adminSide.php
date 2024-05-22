<!-- Pangcheck toh if naka log in ka sa system -->
<?php include 'php/sessioncheck.php'; ?>
<!-- Naka "2" sya kase chinecheck nya if admin ka, pag hindi, kicked ka -->
<?php check_user_role(2); ?> <!-- "2" nakalagay kase may accessibility, pwede sya pumunta kahit saan -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Side</title>
</head>
<body>
    <h1>Welcome to the Admin side of AduCats</h1>
    <p><a href="php/logout.php">Logout</a></p> <!-- Logout link -->
    <?php
    if ($_SESSION['user_role'] == 2) {
        echo '<p><a href="customerSide.php">Go to Customer side</a>.</p>';
    } else {
        echo '<p>You do not have access to Customer side</p>';
    }
    ?>
    <!-- Page content here -->
</body>
</html>
