<?php
require 'dbconnection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $adoptionID = $_POST['adoptionID'];
    $action = $_POST['action'];

    if ($action === 'accept') {
        $status = 'Accepted';
    } elseif ($action === 'reject') {
        $status = 'Rejected';
    } else {
        $status = 'Pending';
    }

    $query = "UPDATE adoption SET adoptionStatus = ? WHERE adoptionID = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('si', $status, $adoptionID);

    if ($stmt->execute()) {
        echo "Adoption request has been $status.";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>

<script>
    alert("Adoption request has been successfully responded");
    window.location.href = "../admin/adoption_request.php";
</script>
