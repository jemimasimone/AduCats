<?php
// Include the database connection file
require 'dbconnection.php';
require 'errors.php';

$imgext_val = false;
$catID = $_POST['editCatID'];
$catname = $_POST['editName'];
$birthdate = $_POST['editAge'];
$place = $_POST['editPlace'];
$gender = $_POST['editGender'];
$health = $_POST['editHealth'];
$adoptionStatus = $_POST['editAdoption'];
$date = new DateTime(date('m.d.y'));
$dateUpd = $date->format('Y-m-d H:i:s');


?>