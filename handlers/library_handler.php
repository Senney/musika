<?php
require_once "../common/common.php";
require_once "../workers/ownership_worker.php";

logged_in_redirect();

$type = $_GET["type"];
$limit = isset($_GET["limit"]) ? $_GET["limit"] : 100;
$page = isset($_GET["page"]) ? $_GET["page"] : 0;
$filter = isset($_GET["filter"]) ? $_GET["filter"] : false;
$userid = usrid();

$worker = new OwnershipWorker($userid);
if ($type == "song") {
	$returndata = array("head" => array("Title", "Artist", "Album"), "data" => array());
	$songs = $worker->getUserSongData($limit, $page, $filter);
	$returndata["data"] = $songs;
	die(json_encode($returndata));
} else if ($type == "count") {
	echo $worker->getUserSongCount($filter);
	die();
}

die(json_encode(array("error"=>"Invalid")));

?>
