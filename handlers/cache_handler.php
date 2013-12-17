<?php

require_once "../workers/cache_worker.php";
require_once "../workers/artist_worker.php";

$add_id = false;
if (isset($_GET["artistid"])) {
	// Handle single artist update.
	$origin = $_SERVER["HTTP_REFERER"];
	$add_id = true;
	$artist_worker = new ArtistWorker();
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

if ($add_id) {
	header("Location: ".$origin);
} else {
	header("Location: ../add.php?import=".$count);
}
	
?>
