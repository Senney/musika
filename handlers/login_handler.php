<?php
require_once "../database/database.php";

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
