<?php
require '../php/dbconnection.php';
include '../php/sessioncheck.php';
check_user_role(2);
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
    <link rel="stylesheet" href="../style/cat.css">
</head>
<body>
    <!-- NAVIGATION -->
    <nav class="nav_bar">
        <div class="left-navbar">
            <a href="dashboard.php">Home</a>
            <a href="cat-overview.php">Cat Profiles</a>
            <a href="adoptionRequest.php">Adoption Request</a> 
            <a href="donationForm.php">Donation Form</a> 
        </div>
        <img id="AduCatsLogo" src ="../img/AduCatsLogoWhite.png">
        <div class="right-navbar">
                <button class="logout-btn"><a href="../homepage.php">Customer Side</a></button>
                <button class="logout-btn"><a href="../php/logout.php">Logout</a></button>
        </div>
    </nav>
       
    <!-- SECTION: DONATION OVERVIEW -->
    <section class="overview">
        <div class="cat-table">
            <?php
                // Fetch donation data from the database
                $query = "SELECT * FROM adoption";
                $result = $conn->query($query);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $adoptionID = $row['adoptionID'];
                        $adopterName = $row['adopterName'];
                        $cat = $row['catName'];
                        $email = $row['email'];
                        $contactno = $row['contactno'];
                        $street = $row['street'];
                        $province = $row['province'];
                        $postal = $row['postal'];
                        $adoptionDate = $row['adoptionDate'];

                        echo '
                        <div class="submissions">
                            <div class="indivsub" onclick="openPopup(\'' . $adoptionID . '\', \'' . $adopterName . '\', \'' . $cat . '\',
                            \'' . $email . '\', \'' . $contactno . '\', \'' . $street . '\',
                            \'' . $province . '\', \'' . $postal . '\', \'' . $adoptionDate . '\')">
                                <p>Adoption ID: ' . $adoptionID . '</p>
                                <p>Adopter: ' . $adopterName . '</p>
                                <p>Cat: ' . $cat . '</p>
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
            <label>Adoption ID: <input type="text" id="popupAdoptionID" readonly></label>
            <label>Adopter: <input type="text" id="popupAdopterName" readonly></label>
            <label>Email: <input type="text" id="popupEmail" readonly></label>
            <label>Phone number: <input type="text" id="popupContact" readonly></label>
            <label>Cat: <input type="text" id="popupCat" readonly></label>
            <label>Street: <input type="text" id="popupStreet" readonly></label>
            <label>Province: <input type="text" id="popupProvince" readonly></label>
            <label>Postal: <input type="text" id="popupPostal" readonly></label>
            <label>Requested On: <input type="text" id="popupDate" readonly></label>
        </div>
        <div class="backbtn">
            <button type="button" onclick="response()">Response</button>
            <button onclick="closePopup()">Back</button>
        </div>
    </div>

    <!-- POPUP response -->
    <div class="popup" id="responsePopup">
        <div class="responseContent">
            <p>What do you wish to do with the request?</p>
            <form action="../php/adoption_request.php" method="post">
                <input type="hidden" id="adoptionID" name="adoptionID">
                <button type="submit" name="action" value="accept">Accept</button>
                <button type="submit" name="action" value="reject">Reject</button>
                <button type="button" onclick="closeresponsePopup()">Cancel</button>
            </form>
        </div>
    </div>

    <!-- JAVASCRIPT -->
    <script>
        function openPopup(adoptionID, adopterName, cat, email, contactno, street, province, postal, date) {
            document.getElementById("popupAdoptionID").value = adoptionID;
            document.getElementById("popupAdopterName").value = adopterName;
            document.getElementById("popupEmail").value = email;
            document.getElementById("popupContact").value = contactno;
            document.getElementById("popupCat").value = cat;
            document.getElementById("popupStreet").value = street;
            document.getElementById("popupProvince").value = province;
            document.getElementById("popupPostal").value = postal;
            document.getElementById("popupDate").value = date;
            document.getElementById("popup").classList.add("open-popup");
        }

        function closePopup() {
            document.getElementById("popup").classList.remove("open-popup");
        }

        function response() {
            const adpID = document.getElementById("popupAdoptionID").value;
            document.getElementById("adoptionID").value = adpID;
            document.getElementById("responsePopup").classList.add("open-popup");
        }

        function closeresponsePopup() {
            document.getElementById("responsePopup").classList.remove("open-popup");
        }
    </script>
</body>
</html>
