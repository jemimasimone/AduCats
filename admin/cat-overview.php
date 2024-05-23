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
        <link rel="stylesheet" href="../style/cat-overview.css">
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
                <button class="customer-btn"><a href="../homepage.php">Customer Side</a></button>
                <button class="logout-btn"><a href="../php/logout.php">Logout</a></button>
            </div>
           
          </nav>
           
        <!-- SECTION: CAT OVERVIEW -->
       
        <section class="overview">
            <div>
                <button class="add-btn"><a href="addCat.php">Add Cat</a></button>
            </div>
            <div class="cat-table">
                <?php
                    // Fetch cat data from the database
                    $query = "SELECT * FROM cats";
                    $result = $conn->query($query);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $catID = $row['catID'];
                            $catName = $row['catName'];
                            $gender = $row['gender'];
                            $healthStatus = $row['health'];
                            $usuallySeen = $row['place'];
                            $birthdate = $row['birthdate'];
                            $age = date_diff(date_create($birthdate), date_create('today'))->y;
                            $adoptStat = $row['adoptionStatus'];
                            $image = $row['catImg'];

                            echo '
                            <div class="cat">
                                <div class="catindiv">
                                    <a onclick="openPopup(\'' . $catName . '\', \'' . $gender . '\', \'' . $age . ' years old\', \'' . $healthStatus . '\', \'' . $usuallySeen . '\', \'' . $image . '\', \'' . $adoptStat . '\')">
                                        <img class="cat-cover" src="' . $image . '" alt="">
                                    </a>
                                    <input type="text" class="cat-info" value="' . $catName . '" readonly>
                                    <input type="text" class="cat-info" value="' . $gender . '" readonly>
                                    <button onclick="editCat(\'' . $catID . '\', \'' . $catName . '\', \'' . $gender . '\', \'' . $birthdate. '\', \'' . $healthStatus . '\', \'' . $usuallySeen . '\', \'' . $image . '\', \'' . $adoptStat . '\')">Edit</button>
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

        <!-- POPUP edit form -->
        <div class="popup" id="editForm">
            <form action="../php/update_cat.php" method="post" enctype="multipart/form-data">
                <div class="botCatInfo">
                    <label>NAME: <input type="text" id="editName" name="editName" required></label>
                    <label for="">Gender:</label>
                    <select id="editGender" name="editGender">
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                    </select>
                    <label>BIRTHDATE: <input type="date" id="editAge" name="editAge" required></label>
                    <label>STATUS: <input type="text" id="editHealth" name="editHealth" required></label>
                    <label>USUALLY SEEN: <input type="text" id="editPlace" name="editPlace" required></label>
                    <label for="">Adoption Status:</label>
                    <select id="editAdopt" name="editAdopt">
                        <option value="For adoption">For adoption</option>
                        <option value="Not for adoption">Not for adoption</option>
                    </select>
                </div>
                <div class="cat_image">
                    <label for="">Replace Cat Image</label><input type="file" accept="image/*" name="catImage">
                </div>
                <input type="hidden" id="editCatID" name="editCatID">
                <div class="backbtn">
                    <button type="submit">Save Changes</button>
                    <button type="button" onclick="confirmArchive()">Archive</button>
                    <button type="button" onclick="cancelEdit()">Cancel</button>
                </div>
            </form>
        </div>

        <!-- POPUP confirm archive -->
        <div class="popup" id="confirmArchivePopup">
            <div class="confirmArchiveContent">
                <p>Are you sure you want to archive this cat?</p>
                <form action="../php/archive_cat.php" method="post">
                    <input type="hidden" id="archiveCatID" name="archiveCatID">
                    <button type="submit">Yes</button>
                    <button type="button" onclick="closeArchivePopup()">No</button>
                </form>
            </div>
        </div>


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

            function editCat(id, name, gender, birthdate, health, place, img, stat) {
                document.getElementById("editName").value = name;
                document.getElementById("editGender").value = gender;
                document.getElementById("editAge").value = birthdate;
                document.getElementById("editHealth").value = health;
                document.getElementById("editPlace").value = place;
                document.getElementById("editAdopt").value = stat;
                document.getElementById("editCatID").value = id;
                document.getElementById("editForm").classList.add("open-popup");
            }


            function cancelEdit() {
                // // Hide the edit form
                // document.getElementById("editForm").style.display = "none";
                document.getElementById("editForm").classList.remove("open-popup");
            }

            function confirmArchive() {
                const catID = document.getElementById("editCatID").value;
                document.getElementById("archiveCatID").value = catID;
                document.getElementById("confirmArchivePopup").classList.add("open-popup");
            }

            function closeArchivePopup() {
                document.getElementById("confirmArchivePopup").classList.remove("open-popup");
            }
        </script>
    </body>
</html>