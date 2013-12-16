<?php
require_once "../database/database.php"

class PlaylistWorker{
	public function addPlaylist($playlistName){
		$link = get_mysqli_link();
		$query = "INSERT INTO playlist Values(?, DEFAULT, ?)";
		$result = mysqli_prepared_query($link, $query, "ds", array(usrid(), $playlistName));
	}

	public function getPlaylist($pId){
		$link = get_mysqli_link();
		$query = "SELECT * FROM playlist WHERE playlist.pId = ?"
		result = mysqli_prepared_query($link, $query, "d", array($pId));
	}





}
?>