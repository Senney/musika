<?php
require_once "../database/database.php";

if (!isset($_POST["username"]) || !isset($_POST["password"])) {
	// Redirect to login page with error.
	header("Location: ../login.php");
	exit(1);
}

$link = get_mysqli_link();
$query = "SELECT password FROM users WHERE username=?";
$params = array($_POST["username"]);
$result = mysqli_prepared_query($link, $query, "s", $params);

if (password_verify($_POST["password"], $result["password"])) {
	// Successfully verified. Setup user session here.
} else {
	// Verification failed, redirect to login page.
}

?>
