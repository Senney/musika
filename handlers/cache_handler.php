<?php

require_once "../workers/cache_worker.php";

if (!isset($_GET["artist-name"])) {
	header("Location: index.php");
}
$artist_name = $_GET["artist-name"];

$cache = new CacheWorker();
$count = 0;
if ($cache->should_cache($artist_name)) {
	$count = $cache->cache_artist($artist_name);
}

header("Location: ../add.php?import=".$count);

?>
