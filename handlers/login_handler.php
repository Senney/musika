<?php
require_once "../database/database.php";
require_once "../workers/user_worker.php";

if (!isset($_POST["username"]) || !isset($_POST["password"])) {
	// Redirect to login page with error.
	header("Location: ../login.php?error=val");
	exit(1);
}

$worker = new UserWorker();
$ret = $worker->checkLogin($_POST["username"], $_POST["password"]);

if ($ret == 0) {
	header("Location: ../index.php");
} else {
	header("Location: ../login.php?error=" . $ret);
}

?>
