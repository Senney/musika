<?php

require_once "../workers/cache_worker.php";
require_once "../workers/artist_worker.php";

$add_id = false;
$artist_worker = new ArtistWorker();
if (isset($_GET["artistid"])) {
	// Handle single artist update.
	$origin = $_SERVER["HTTP_REFERER"];
	$add_id = true;
	$artist = $artist_worker->getArtist($_GET["artistid"]);
	if (!$artist) { header("Location: index.php"); die(); }
	$artist_name = $artist["name"];
} else if (!isset($_GET["artist-name"])) {
	header("Location: index.php");
	die();
} else {
	$artist_name = $_GET["artist-name"];
}


$cache = new CacheWorker();
$count = 0;
if ($cache->should_cache($artist_name)) {
	$count = $cache->cache_artist($artist_name);
}

$artistdata = $artist_worker->getArtistName($artist_name);
$artistid = isset($artistdata["artistId"]) ? $artistdata["artistId"] : -1;
if ($add_id) {
	header("Location: ".$origin);
} else {
	header("Location: ../add.php?import=".$count."&artist=".$artistid);
}
	
?>
