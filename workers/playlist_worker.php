<?php
require_once __DIR__ . "/../database/database.php"

class PlaylistWorker{
	public function addPlaylist($playlistName){
		$link = get_mysqli_link();
		$query = "INSERT INTO playlist Values(?, DEFAULT, ?)";
		$result = mysqli_prepared_query($link, $query, "ds", array(usrid(), $playlistName));
	}

	public function getPlaylist($pId){
		$link = get_mysqli_link();
		$query = "SELECT * FROM playlist WHERE playlist.pId = ?";
		$result = mysqli_prepared_query($link, $query, "d", array($pId));
		return = $result;
	}

	public function getPlaylistSongs($pId){
		$link = get_mysqli_link();
		$query = "SELECT * FROM playlistentry WHERE playlistentry.pId = ?";
		$result = mysqli_prepared_query($link, $query, "d", array($pId));
		return = $result;
	}
	
	public function sharePlaylist($userId, $pId, $message = null){
		$link = get_mysqli_link();
		$query = "INSERT INTO playlistshare Values(?, ?, ?)";
		$result = mysqli_prepared_query($link, $query, "dds", array($userId, $pId, $message));
	}
	
	public function addRating($userId, $pId, $rating){
		$link = get_mysqli_link();
		$query = "INSERT INTO playlistrating Values(?, ?, ?)";
		$result = mysqli_prepared_query($link, $query, "ddd", array($userId, $pId, $rating));
	}
}
?>