<?php
require 'php/dbconnection.php';
include 'php/sessioncheck.php';
check_user_role(1);
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
    <link rel="stylesheet" href="style/cat.css">
</head>

<body>
    <!--NAVBAR-->

    <nav class="nav_bar">

        <div class="left-navbar">
            <a id="profilelnk" href=" ">Profile</a>
            <a id="adoptionlnk" href="adoption.php">Adoption Request</a>
            <a id="donatelnk" href="donation.php">Donate</a>

        </div>

        <img id="AduCatsLogo" src="img/AduCatsLogoWhite.png">

        <div class="right-navbar">
            <a id="recordslnk" href=" ">Records</a>
            <a id="CatProflnk" href="homepage.php">About</a>
            <a id="Logoutlnk" href="php/logout.php"><button>Logout</button></a>
            <?php
            // if ($_SESSION['user_role'] == 2) {
            //     echo '<p><a href="adminSide.php">Go to Admin side</a>.</p>';
            // } else {
            //     echo '<p>You do not have access to Admin side.</p>';
            // }
            ?>
        </div>

    </nav>
    <!-- SECTION: CAT OVERVIEW -->

    <section class="overview">
        <div class="cat-table">
            <?php
            // Fetch cat data from the database
            $query = "SELECT * FROM cats";
            $result = $conn->query($query);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $catName = $row['catName'];
                    $gender = $row['gender'];
                    $healthStatus = $row['health'];
                    $usuallySeen = $row['place'];
                    $birthdate = $row['birthdate'];
                    $age = date_diff(date_create($birthdate), date_create('today'))->y;
                    $image = $row['catImg'];
                    $adoptStat = $row['adoptionStatus'];
                    $adjustedImagePath = str_replace('../img/', 'img/', $image);

                    echo '
                            <div class="cat">
                                <div class="catindiv">
                                    <a onclick="openPopup(\'' . $catName . '\', \'' . $gender . '\', \'' . $age . ' years old\', \'' . $healthStatus . '\', \'' . $usuallySeen . '\', \'' . $adjustedImagePath . '\', \'' . $adoptStat . '\')">
                                        <img class="cat-cover" src="' . $adjustedImagePath . '" alt="">
                                    </a>
                                    <input type="text" class="cat-info" value="' . $catName . '" readonly>
                                    <input type="text" class="cat-info" value="' . $gender . '" readonly>
                                </div>
                            </div>';
                }
            } else {
                echo '<p>No cats available for display.</p>';
            }

            $conn->close();
            ?>
        </div>
    </section>

    <!-- POPUP display info -->
    <div class="popup" id="popup">
        <div class="topImg">
            <img class="cat-img" id="popupImg" src="" alt="">
        </div>
        <div class="botCatInfo">
            <label>NAME: <input type="text" id="popupName" readonly></label>
            <label>GENDER: <input type="text" id="popupGender" readonly></label>
            <label>AGE: <input type="text" id="popupAge" readonly></label>
            <label>STATUS: <input type="text" id="popupHealth" readonly></label>
            <label>USUALLY SEEN: <input type="text" id="popupPlace" readonly></label>
            <label>ADOPTION STATUS: <input type="text" id="popupAdopt" readonly></label>
        </div>
        <div class="backbtn">
            <button onclick="closePopup()">Back</button>
        </div>
    </div>

    <!--FOOTER NA TOH-->

    <footer>
        <div class="AduCatsLogo">
            <img id="FooterLogo" src="img/Cat-1.png">
            <p>© 2024 AduCats</p>
        </div>
        <div class="ContactUs">
            <h3>CONTACT US</h3>
            <a href="https://www.facebook.com/groups/946027585595117">Aducats Facebook</a>
            <p>0992 123 4561</p>
        </div>
        <div class="Address">
            <h3>ADDRESS</h3>
            <p>900 San Marcelino St, Ermita, Manila, 1000 Metro Manila</p>
        </div>

    </footer>

    <!-- JAVASCRIPT -->
    <script>
        function openPopup(name, gender, age, health, place, img, stat) {
            document.getElementById("popupName").value = name;
            document.getElementById("popupGender").value = gender;
            document.getElementById("popupAge").value = age;
            document.getElementById("popupHealth").value = health;
            document.getElementById("popupPlace").value = place;
            document.getElementById("popupAdopt").value = stat;
            document.getElementById("popupImg").src = img;
            document.getElementById("popup").classList.add("open-popup");
        }

        function closePopup() {
            document.getElementById("popup").classList.remove("open-popup");
        }
    </script>
</body>

</html>