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
	$retsongs = array();
	for ($i = 0; $i < count($songs); $i++) {
		$newsong = array();
		$song = $songs[$i];
		$newsong["title"] = "<a href='song.php?id=".$song["songid"]."'>".$song["songtitle"]."</a>";
		$newsong["artist"] = "<a href='artist.php?id=".$song["artistid"]."'>".$song["artistname"]."</a>";
		$newsong["album"] = "<a href='album.php?id=".$song["albumid"]."'>".$song["albumname"]."</a>";
		array_push($retsongs, $newsong);
	}
	$returndata["data"] = $retsongs;
	die(json_encode($returndata));
} else if ($type == "count") {
	echo $worker->getUserSongCount($filter);
	die();
}

die(json_encode(array("error"=>"Invalid")));

?>
