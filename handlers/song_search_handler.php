<?php
require_once "../database/database.php";
require_once "../workers/song_worker.php";

if (!isset($_GET["song_name"])) {
	die("-1");
}

$song = $_GET["song_name"] . "%";
$worker = new SongWorker();
$songs = $worker->findSongName($song);

die(json_encode($songs));

?>
