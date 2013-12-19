<?php
require_once "../common/common.php";
require_once "../workers/playlist_worker.php";

if (!keys_exist($_POST, array("idBox", "rate"))) {
	header("Location: ../playlist.php");
	die();
}

$playlist_worker = new PlaylistWorker();
	
$playlist_name = $_POST["idBox"];
$rating = $_POST["rate"];

if (!$playlist_worker->getRating(usrid(), $playlist_name)) {
	$playlist_worker->addRating(usrid(),$playlist_name,$rating);
} else {
	$playlist_worker->updateRating(usrid(),$playlist_name,$rating);
}

die(true);

?>
