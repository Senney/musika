<?php
require_once "../common/common.php";

if (!keys_exist($_POST, array(
		"song-name", "artist-name", "album-name", "media-type"
	))) {
	header("Location: ../add.php?error=0");
	exit(1);
}

$song_name = $_POST["song-name"];
$artist_name = $_POST["artist-name"];
$album_name = $_POST["album-name"];
$media_type = $_POST["media-type"];

	
	
?>