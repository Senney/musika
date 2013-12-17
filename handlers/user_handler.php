<?php

if (!isset($_POST["type"])) { header("Location: ../user.php?error=-1"); die(); }

require_once "../common/common.php";
require_once "../workers/user_worker.php";

$worker = new UserWorker();
$type = $_POST["type"];

if ($type == "bio") {
	$newbio = empty($_POST["bio"]) ? null : $_POST["bio"];
	$worker->setBio(usrid(), $newbio);
} else if ($type == "friend) {
	
}

header("Location: ../user.php?error=1");
die();

?>
