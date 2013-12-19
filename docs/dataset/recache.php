<?php

require_once "../../database/database.php";
require_once "../../workers/cache_worker.php";
require_once "../../workers/artist_worker.php";

$link = get_mysqli_link();
$query = "SELECT artistId FROM itunescache";
$result = mysqli_prepared_query($link, $query);

$cw = new CacheWorker();
$aw = new ArtistWorker();
foreach ($result as $r) {
	$name = $aw->getArtist($r["artistId"])["name"];
	printf("Recaching: %s\n", $name);
	$ret = $cw->cache_artist($name);
	printf("Recached: %s -- %d\n", $name, $ret);
	sleep(1);
}

?>
