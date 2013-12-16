#!/usr/bin/php
<?php
require "../../database/database.php";

$link = get_mysqli_link();

$query = "SELECT * FROM artist";
$result = mysqli_prepared_query($link, $query);

foreach ($result as $artist) {
	$query = "SELECT album.albumID, album.name FROM album " .
	"JOIN albumcontributor ON albumcontributor.albumId = album.albumID ".
	"WHERE albumcontributor.artistID = ? AND ".
	"album.name IN (SELECT name FROM album JOIN albumcontributor ON albumcontributor.albumId = album.albumID ".
	"WHERE albumcontributor.artistId = ? GROUP BY album.name HAVING COUNT(album.albumID) > 1)";
	$res = mysqli_prepared_query($link, $query, "dd", array($artist["artistId"], $artist["artistId"]));
	if (empty($res)) {
		continue;
	}
	
	$vals = array();
	foreach ($res as $dup) {
		if (!isset($vals[$dup["name"]])) {
			$vals[$dup["name"]] = $dup["albumID"];
			continue;
		}
		$aid = $dup["albumID"];
		$nid = $vals[$dup["name"]];
		
		$acq = "DELETE FROM albumcontributor WHERE albumId = ?";
		$asq = "UPDATE albumsongs SET albumId = ? WHERE albumId = ?";
		$soq = "UPDATE songownership SET AID = ? WHERE AID = ?";
		$alq = "DELETE FROM album WHERE albumID = ?";
		mysqli_prepared_query($link, $acq, "d", array($aid));
		if (mysqli_error($link)) die(mysqli_error($link));
		mysqli_prepared_query($link, $asq, "dd", array($nid, $aid));
		if (mysqli_error($link)) die(mysqli_error($link));
		mysqli_prepared_query($link, $soq, "dd", array($nid, $aid));
		if (mysqli_error($link)) die(mysqli_error($link));
		mysqli_prepared_query($link, $alq, "d", array($aid));
		if (mysqli_error($link)) die(mysqli_error($link));		
	}
}

?>
