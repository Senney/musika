<?php
require_once "../database/database.php";
require_once "../workers/user_worker.php";

$username = $_POST["username"];
$password = $_POST["password"];
$password_confirm = $_POST["passwordconfirm"];
$email = $_POST["email"];

// Verify all of our variables are set.
if (!isset($username) || !isset($password) || !isset($password_confirm)
		|| !isset($email)) 
{
	// Handle errors here.
	header("Location: ../register.php");
	exit(1);
}

if ($password != $password_confirm) {
	// Handle passwords not matching (this is really only if they bypass
	// the javascript like weirdos.
	header("Location: ../register.php");
	exit(1);
}

$worker = new UserWorker();
$ret = $worker->registerUser($username, $password, $email);
if ($ret == -1) {
	header("Location: ../register.php?error=username");
	exit(1);
}

// Redirect them to the login page.
header("Location: ../login.php?error=register");

?>
