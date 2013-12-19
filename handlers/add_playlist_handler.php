<?php
require_once "../common/common.php";
require_once "../workers/playlist_worker.php";
require_once "../workers/song_worker.php";

if (!keys_exist($_GET, array(
		"type"
	))) {
	header("Location: ../playlist.php?error=-1");
	exit(1);
}
$song_worker = new SongWorker();
$playlist_worker = new PlaylistWorker();


$type = $_GET["type"];

if($type == 1){
	$playlist_name = $_GET["playlist-name"];
	$playlist_worker->addPlaylist($playlist_name);
//done
}
else if($type == 2){
	$playlist_name = $_GET["playlist-id"];
	$playlist_worker->deletePlaylist($playlist_name);
}
else if ($type == 3){
	$song_name = $_GET["song-id"];
	$playlist_name = $_GET["playlist-id"];
	$album_id = $_GET["album-id"];
	$playlist_worker->addSongToPlaylist($song_name,$playlist_name, $album_id);

//done
}
else if ($type == 4 ){
	$song_name = $_GET["song-id"];
	$playlist_name = $_GET["playlist-id"];
	$album_id = $_GET["album-id"];
	$playlist_worker->deleteSongFromPlaylist($song_name,$playlist_name, $album_id);
//done
}
else if ($type == 5){
	die("Moved");
//done

}
else if ($type == 6){
	$userid = $_GET["user-id"];
	$playlist_name = $_GET["playlist-id"];
	$message = $_GET["message"];
	$playlist_worker->sharePlaylist($userid,$playlist_name,$message);
//done
}

redirect_back();

?>