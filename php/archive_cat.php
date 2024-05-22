<?php
require 'dbconnection.php';
require 'errors.php';

$catID = $_POST['archiveCatID'];
$date = new DateTime(date('m.d.y'));
$dateUpd = $date->format('Y-m-d H:i:s');

if (count($errors) == 0 && isset($catID)) {
    $query = "SELECT * FROM cats WHERE catID = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $catID);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        $archiveQuery = "INSERT INTO catsarchive (catID, catName, gender, birthdate, health, place, adoptionStatus, catImg, dateAdded, dateArchived)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $archiveStmt = $conn->prepare($archiveQuery);
        $archiveStmt->bind_param(
            "isssssssss",
            $row['catID'],
            $row['catName'],
            $row['gender'],
            $row['birthdate'],
            $row['health'],
            $row['place'],
            $row['adoptionStatus'],
            $row['catImg'],
            $row['dateAdded'],
            $dateUpd
        );
        $archiveStmt->execute();
        $archiveStmt->close();

        // Delete the cat data from the cats table
        $deleteQuery = "DELETE FROM cats WHERE catID = ?";
        $deleteStmt = $conn->prepare($deleteQuery);
        $deleteStmt->bind_param("i", $catID);
        $deleteStmt->execute();
        $deleteStmt->close();
    }

    $stmt->close();
}

$conn->close();
?>

<script>
    alert("Cat has been archived successfully.");
    window.location.href = "../admin/cat-overview.php";
</script>
