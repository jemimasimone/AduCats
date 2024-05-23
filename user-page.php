<?php
require 'php/dbconnection.php';
include 'php/sessioncheck.php';
check_user_role(1);

$user_id = $_SESSION['user_id'];

// Fetch donations based on session user_id
$donation_query = "SELECT donationID, donationType, amount, goods, mot, receiver, donationDate FROM donation WHERE userID = ?";
$donation_stmt = $conn->prepare($donation_query);
$donation_stmt->bind_param("i", $user_id);
$donation_stmt->execute();
$donation_result = $donation_stmt->get_result();
$donations = $donation_result->fetch_all(MYSQLI_ASSOC);

// Fetch adoptions based on session user_id
$adoption_query = "SELECT adoptionID, catName, adoptionDate, adoptionStatus FROM adoption WHERE userID = ?";
$adoption_stmt = $conn->prepare($adoption_query);
$adoption_stmt->bind_param("i", $user_id);
$adoption_stmt->execute();
$adoption_result = $adoption_stmt->get_result();
$adoptions = $adoption_result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>AdU Cats</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- LINKS -->
    <link rel="stylesheet" href="style/user-page.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Aoboshi+One&display=swap" rel="stylesheet">
</head>
<body>
    <header class="logo">
    <a href="homepage.php">
            <img src="img/Cat-2.png" alt="logo_cat">
        </a>
        <h1>Records</h1>
    </header>
    <div class="hline"></div>
    <h3>Donation</h3>

    <!-- SECTION 1: Donation -->
    <section class="records">
        <div class="record-content">
            <table class="table">
               <!-- HEADER  -->
                <tr class="table-header">
                    <th>Donation #</th>
                    <th>Type</th>
                    <th>Amount</th>
                    <th>Goods</th>
                    <th>MOT</th>
                    <th>Receiver</th>
                    <th>Date</th>
                </tr>
                <!-- CONTENTS -->
                <?php foreach ($donations as $donation): ?>
                <tr class="product-contents">
                    <td><?php echo $donation['donationID']; ?></td>
                    <td><?php echo $donation['donationType']; ?></td>
                    <td><?php echo $donation['amount']; ?></td>
                    <td><?php echo $donation['goods']; ?></td>
                    <td><?php echo $donation['mot']; ?></td>
                    <td><?php echo $donation['receiver']; ?></td>
                    <td><?php echo date('F j, Y', strtotime($donation['donationDate'])); ?></td>
                </tr>
                <?php endforeach; ?>
            </table>
          </div>
    </section>

    <h3>Adoption</h3>
    <!-- SECTION 2: Adoption -->
    <section class="records">
        <div class="record-content">
            <table class="table">
               <!-- HEADER  -->
                <tr class="table-header">
                    <th>Adoption #</th>
                    <th>Cat</th>
                    <th>Date</th>
                    <th>Status</th>
                </tr>
                <!-- CONTENTS -->
                <?php foreach ($adoptions as $adoption): ?>
                <tr class="product-contents">
                    <td><?php echo $adoption['adoptionID']; ?></td>
                    <td><?php echo $adoption['catName']; ?></td>
                    <td><?php echo date('F j, Y', strtotime($adoption['adoptionDate'])); ?></td>
                    <td><?php echo $adoption['adoptionStatus']; ?></td>
                </tr>
                <?php endforeach; ?>
            </table>
          </div>
    </section>
</body>
</html>
