<?php

require_once "../workers/user_worker.php";

if (!isset($_GET["username"])) {
	die(false);
}

$uw = new UserWorker();
$names = $uw->findUserNames($_GET["username"] . "%");

die(json_encode(array_values($names)));

?>
