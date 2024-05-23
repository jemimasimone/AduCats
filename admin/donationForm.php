<?php require '../php/dbconnection.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>AdU Cats</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- LINKS -->
    <link rel="stylesheet" href="../style/cat.css">
</head>
<body>
    <!-- NAVIGATION -->
    <nav class="nav_bar">

            <div class="left-navbar">
                <a href="index.html">Home</a>
                <a href="cat-overview.php">Cat Profiles</a>
                <a href="adoptionRequest.php">Adoption Request</a> 
                <a href="donationForm.php">Donation Form</a> 
            </div>
            
            <img id="AduCatsLogo" src ="../img/AduCatsLogoWhite.png">
            
            <div class="right-navbar">
                <a href=""><button>Logout</button></a>
            </div>
           
          </nav>
       
    <!-- SECTION: DONATION OVERVIEW -->
    <section class="overview">
        <div class="cat-table">
            <?php
                // Fetch donation data from the database
                $query = "SELECT * FROM donation";
                $result = $conn->query($query);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $donationID = $row['donationID'];
                        $donatorName = $row['donatorName'];
                        $donationType = $row['donationType'];
                        $email = $row['email'];
                        $contactno = $row['contactno'];
                        $amount = $row['amount'];
                        $goods = $row['goods'];
                        $mot = $row['mot'];
                        $receiver = $row['receiver'];
                        $donationDate = $row['donationDate'];

                        echo '
                        <div class="cat">
                            <div class="catindiv" onclick="openPopup(\'' . $donationID . '\', \'' . $donatorName . '\', \'' . $donationType . '\',
                            \'' . $email . '\', \'' . $contactno . '\', \'' . $amount . '\', \'' . $goods . '\',
                            \'' . $mot . '\', \'' . $receiver . '\', \'' . $donationDate . '\')">
                                <p>Donation ID: ' . $donationID . '</p>
                                <p>Donator: ' . $donatorName . '</p>
                                <p>Donation Type: ' . $donationType . '</p>
                            </div>
                        </div>';
                    }
                } else {
                    echo '<p>No donation records available for display.</p>';
                }

                $conn->close();
            ?>
        </div>
    </section>

    <!-- POPUP display donation info -->
    <div class="popup" id="popup">
        <div class="botCatInfo">
            <label>Donation ID: <input type="text" id="popupDonationID" readonly></label>
            <label>Donator: <input type="text" id="popupDonatorName" readonly></label>
            <label>Email: <input type="text" id="popupEmail" readonly></label>
            <label>Phone number: <input type="text" id="popupContact" readonly></label>
            <label>Donation Type: <input type="text" id="popupDonationType" readonly></label>
            <label>Amount: <input type="text" id="popupAmount" readonly></label>
            <label>Goods: <input type="text" id="popupGoods" readonly></label>
            <label>Mode of Transaction: <input type="text" id="popupMOT" readonly></label>
            <label>Receiver: <input type="text" id="popupReceiver" readonly></label>
            <label>Donated On: <input type="text" id="popupDate" readonly></label>
            <!-- Add any additional popup content here -->
        </div>
        <div class="backbtn">
            <button onclick="closePopup()">Back</button>
        </div>
    </div>

    <!-- JAVASCRIPT -->
    <script>
        function openPopup(donationID, donatorName, donationType, email, contact, amount, goods, mot, receiver, date) {
            document.getElementById("popupDonationID").value = donationID;
            document.getElementById("popupDonatorName").value = donatorName;
            document.getElementById("popupDonationType").value = donationType;
            document.getElementById("popupEmail").value = email;
            document.getElementById("popupContact").value = contact;
            document.getElementById("popupAmount").value = amount;
            document.getElementById("popupGoods").value = goods;
            document.getElementById("popupMOT").value = mot;
            document.getElementById("popupReceiver").value = receiver;
            document.getElementById("popupDate").value = date;
            document.getElementById("popup").classList.add("open-popup");
        }

        function closePopup() {
            document.getElementById("popup").classList.remove("open-popup");
        }
    </script>
</body>
</html>
