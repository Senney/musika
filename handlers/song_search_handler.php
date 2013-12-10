<?php

require_once "../workers/song_worker.php";
require_once "../workers/album_worker.php";
require_once "../workers/artist_worker.php";
require_once "../common/common.php";


// Wait 2 seconds between queries.
$MIN_QUERY_TIME = 2;

if (!isset($_GET["song_name"])) {
	die("-1");
}

if (isset($_SESSION["last_query"]) && 
    !empty($_SESSION["last_query"]) && 
    time() - $_SESSION["last_query"] <= $MIN_QUERY_TIME)
{
	die('{"error":"'.$_SESSION["last_query"].'"}');
}

$_SESSION["last_query"] = time();

$song = '%' . $_GET["song_name"] . "%";
$worker = new SongWorker();
$songs = $worker->findSongName($song);
foreach ($songs as &$s) {
    $artistWorker = new ArtistWorker();
    $albumWorker = new AlbumWorker();
    $artistInfo = $artistWorker->getArtist($s["AID"]);
    $albumInfo = $albumWorker->getAlbumSongID($s["SID"]);
    $s["album"] = $albumInfo[0]["name"];
    $s["artist"] = $artistInfo["name"];
}

die(json_encode($songs));

?>
