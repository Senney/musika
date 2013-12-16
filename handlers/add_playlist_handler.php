<?php
require_once "../common/common.php";
require_once "../workers/playlist_worker.php";

if (!keys_exist($_POST, array(
		"playlist-name"
	))) {
	header("Location: ../add.php?error=0");
	exit(1);
}

$playlist_worker = new PlaylistWorker();

$playlist_name = $_POST["playlist-name"];

$playlist_worker->addPlaylist($playlist_name);

?>