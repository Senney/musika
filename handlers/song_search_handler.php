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

$_SESSION["last_query"] = time();

$song = '%' . $_GET["song_name"] . "%";
$artist = '%' . $_GET["artist_name"] . '%';
$album = '%' . $_GET["album_name"] . '%';
$worker = new SongWorker();
$songs = $worker->findSongArtistAlbumName($song, $artist, $album);
foreach ($songs as &$s) {
    $artistWorker = new ArtistWorker();
    $albumWorker = new AlbumWorker();
    $artistInfo = $artistWorker->getArtist($s["AID"]);
    $albumInfo = $albumWorker->getAlbumSongID($s["SID"]);
	$s["album"] = $albumInfo["name"];
    $s["artist"] = $artistInfo["name"];
}

die(json_encode($songs));

?>
