<?php

require_once "../../database/database.php";
require_once "../../workers/album_worker.php";

$link = get_mysqli_link();
$cq = "SELECT COUNT(*) AS c FROM song";
$result = mysqli_prepared_query($link, $cq);
$count = $result[0]['c'];
$numgen = 2500;

$songs = array();
$worker = new AlbumWorker();
for ($i = 0; $i < $numgen; $i++) {
	$value = rand(1, $count);
	if (in_array($value, $songs)) {
		continue;
	}
	
	$albums = $worker->getAlbumsSongId($value);
	
	array_push($songs, $value);
	$query = "INSERT INTO songownership VALUES(?, ?, ?, 1)";
	$params = array(5, $value, $albums[rand(0, count($albums)-1)]["albumId"]);
	mysqli_prepared_query($link, $query, "ddd", $params);
	if (mysqli_error($link)) die(mysqli_error($link));
}

?>
