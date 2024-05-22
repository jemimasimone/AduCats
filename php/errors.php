<?php
$errors = array();
if (count($errors) > 0){
	foreach ($errors as $error){
		echo "<script>alert('$error')</script>";
	}
}
?>