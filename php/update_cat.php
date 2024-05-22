<?php
// Include the database connection file
require 'dbconnection.php';
require 'errors.php';

$catID = $_POST['editCatID'];
$catname = $_POST['editName'];
$birthdate = $_POST['editAge'];
$place = $_POST['editPlace'];
$gender = $_POST['editGender'];
$health = $_POST['editHealth'];
$adoptionStatus = $_POST['editAdopt'];

if (count($errors) == 0) {
    // Check if a new image is being uploaded
    if (isset($_FILES['catImage']) && $_FILES['catImage']['error'] == UPLOAD_ERR_OK) {
        $image = $_FILES['catImage']['name'];
        $target_dir = "../img/";
        $target_file = $target_dir . basename($image);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Validate file type
        $valid_extensions = array("jpeg", "jpg", "png");
        if (in_array($imageFileType, $valid_extensions)) {
            if (move_uploaded_file($_FILES['catImage']['tmp_name'], $target_file)) {
                // Prepare and bind for update with new image
                $sql = "UPDATE cats SET catName=?, gender=?, birthdate=?, health=?, place=?, adoptionStatus=?, catImg=? WHERE catID=?";
                $stmt = $conn->prepare($sql);
                if ($stmt === false) {
                    die('Prepare() failed: ' . htmlspecialchars($conn->error));
                }
                $stmt->bind_param("sssssssi", $catname, $gender, $birthdate, $health, $place, $adoptionStatus, $target_file, $catID);
                if ($stmt->execute() === false) {
                    die('Execute() failed: ' . htmlspecialchars($stmt->error));
                }
                $stmt->close();
            } else {
                echo 'File upload failed with error code ' . $_FILES['catImage']['error'];
            }
        } else {
            echo 'Invalid file type. Only JPEG, JPG, and PNG files are allowed.';
        }
    } else {
        // Update without new image
        $sql = "UPDATE cats SET catName=?, gender=?, birthdate=?, health=?, place=?, adoptionStatus=? WHERE catID=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssssi", $catname, $gender, $birthdate, $health, $place, $adoptionStatus, $catID);
        if ($stmt->execute() === false) {
            die('Execute() failed: ' . htmlspecialchars($stmt->error));
        }
        $stmt->close();
    }
}

$conn->close();
?>

<script>
    alert("Campus cat information has been successfully updated");
    window.location.href = "../admin/cat-overview.php";
</script>
