#!/usr/bin/php
<?php
require "../../database/database.php";

$link = get_mysqli_link();

function get_song($song_name, $album_name, $artist_name) {
	global $link;
	$artist = get_artist($artist_name);
	$album = get_album($album_name, $artist_name);
	
	$query = "SELECT sg.* FROM song AS sg JOIN albumsongs AS ss WHERE ".
		"sg.title = ? AND ss.albumId = ? AND sg.AID = ?";
	$params = array($song_name, $album["albumID"], $artist["artistId"]);
	$result = mysqli_prepared_query($link, $query, "sdd", $params);
	return $result[0];
}

function add_song($song_name, $album_id, $artist_id) {
	global $link;
	
	$query = "INSERT INTO song(title, AID) VALUES(?, ?, ?)";
	mysqli_prepared_query($link, $query, "ssd", array($song_name, $artist_id));
	if (mysqli_error($link)) die(mysqli_error($link));
	
	$id = mysqli_insert_id($link);
	$query = "INSERT INTO albumsongs VALUES(?, ?)";
	mysqli_prepared_query($link, $query, "dd", array($album_id,
		$id));
	if (mysqli_error($link)) die(mysqli_error($link));
	return $id;
	
}

function get_album($album_name, $artist_name) {
	$artist = get_artist($artist_name);
	global $link;
	$query = "SELECT al.* FROM album AS al JOIN albumcontributor AS ac WHERE " .
		"ac.artistId = ? AND al.name = ?";
	$res = mysqli_prepared_query($link, $query, "ds", 
		array($artist["artistId"], $album_name));
	return $res[0];
}

function add_album($album_name, $artist_id) {
	global $link;
	$query = "INSERT INTO album(name) VALUES(?)";
	mysqli_prepared_query($link, $query, "s", array($album_name));
	if (mysqli_error($link)) die(mysqli_error($link));
	$id = mysqli_insert_id($link);
	$query = "INSERT INTO albumcontributor VALUES(?, ?)";
	$params = array($artist_id, $id);
	mysqli_prepared_query($link, $query, "dd", $params);
	if (mysqli_error($link)) die(mysqli_error($link));
	
	return $id;
}

function get_artist($artist_name) {
	global $link;
	$query = "SELECT * FROM artist WHERE name = ?";
	$params = array($artist_name);
	$artist = mysqli_prepared_query($link, $query, "s", $params);
	return $artist[0];
}

function add_artist($artist_name) {
	global $link;
	$query = "INSERT INTO artist(name) VALUES(?)";
	$params = array($artist_name);
	mysqli_prepared_query($link, $query, "s", $params);
	if (mysqli_error($link)) die(mysqli_error($link));
	return mysqli_insert_id($link);
}

$artists = array();
$albums = array();

$file = fopen("data.sql", "r");
if (!$file) die("Unable to open data file.");

$count = 0;
$next = 10000;
while (($buffer = fgets($file)) !== false) {	
	$type = substr($buffer, 0, 1);
	$rest = substr($buffer, 2);
	switch ($type) {
	case "A":
		// Artist definition.
		$artist = trim($rest);
		$id = add_artist($artist);
		$artists[$artist] = $id;
		break;
	case "C":
		// Artist-Album Relation.
		// 2 part relation.
		$artist = trim($rest);
		$buffer = fgets($file);
		$rest = substr($buffer, 2);
		$album = trim($rest);
		$id = add_album($album, $artists[$artist]);
		$albums[$album] = $id;
		break;
	case "S":
		$count++;
		if ($count > $next) {
			echo "Done importing " . $count . " songs.";
			$next = $next + 10000;
		}
		$song = trim($rest);
		$buffer = fgets($file);
		$rest = substr($buffer, 2);
		$album = trim($rest);
		$buffer = fgets($file);
		$rest = substr($buffer, 2);
		$artist = trim($rest);
		add_song($song, $albums[$album], $artists[$artist]);
		break;
	}
}

?>
