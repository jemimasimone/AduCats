<?php
// Include the database connection file
require 'dbconnection.php';
require 'errors.php';

$imgext_val = false;
$catname = $_POST['name'];
$birthdate = $_POST['birthdate'];
$place = $_POST['place'];
$gender = $_POST['gender'];
$health = $_POST['health'];
$adoptionStatus = $_POST['adoption'];
$date = new DateTime(date('m.d.y'));
$dateUpd = $date->format('Y-m-d H:i:s');

//Check for duplicates
$cat_check_query = "SELECT * FROM cats
WHERE catName = ? AND place = ? AND birthdate = ?";
$stmt = $conn->prepare($cat_check_query);
$stmt->bind_param("sss", $catname, $place, $birthdate);
$stmt->execute();
$result = $stmt->get_result();
$cat_res = $result->fetch_assoc();
if ($cat_res) {
    array_push($errors, "Duplicate product detected.");
}
$stmt->close();

// INSERTION
if (count($errors) == 0) {

    // IMAGE VALIDATION
    if (isset($_FILES['images'])) {
        $images = $_FILES['images'];

        foreach ($images['tmp_name'] as $key => $tmp_name) {
            $imgfile = $images['name'][$key];
            $imgtemp = $tmp_name;
            $filename_sep = explode('.', $imgfile);
            $file_ext = strtolower(end($filename_sep));

            $ext = array('jpeg', 'jpg', 'png');
            if (in_array($file_ext, $ext)) {
                $imgext_val = true;
            }

            if ($imgext_val) {
                $upload_image = "../img/" . $imgfile;

                if (move_uploaded_file($imgtemp, $upload_image)) {
                    // Prepare and bind
                    $stmt = $conn->prepare("INSERT INTO cats (catName, birthdate, place, gender, health, adoptionStatus, catImg, dateAdded)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
                    if ($stmt === false) {
                        die('Prepare() failed: ' . htmlspecialchars($conn->error));
                    }
                    $stmt->bind_param("ssssssss", $catname, $birthdate, $place, $gender, $health, $adoptionStatus, $upload_image, $dateUpd);
                    if ($stmt->execute() === false) {
                        die('Execute() failed: ' . htmlspecialchars($stmt->error));
                    }
                    $stmt->close();
                } else {
                    echo 'File upload failed with error code ' . $images['error'][$key];
                }
            }
        }
    } else {
        // Prepare and bind
        $stmt = $conn->prepare("INSERT INTO cats (catName, birthdate, place, gender, health, adoptionStatus, dateAdded)
        VALUES (?, ?, ?, ?, ?, ?, ?)");
        if ($stmt === false) {
            die('Prepare() failed: ' . htmlspecialchars($conn->error));
        }
        $stmt->bind_param("sssssss", $catname, $birthdate, $place, $gender, $health, $adoptionStatus, $dateUpd);
        if ($stmt->execute() === false) {
            die('Execute() failed: ' . htmlspecialchars($stmt->error));
        }
        $stmt->close();
    }
}

$conn->close();


?>

<script>
    alert("Campus cat has been successfully added");
    // Redirect to login page
    window.location.href = "../admin/index.html";
</script>