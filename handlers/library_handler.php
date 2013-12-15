<?php
require_once "../common/common.php";
require_once "../workers/ownership_worker.php";

logged_in_redirect();

$type = $_GET["type"];
$userid = usrid();

$worker = new OwnershipWorker($userid);
if ($type == "song") {
	$returndata = array("head" => array("Title", "Artist", "Album"), "data" => array());
	$songs = $worker->getUserSongData();
	$returndata["data"] = $songs;
	die(json_encode($returndata));
}

?>
