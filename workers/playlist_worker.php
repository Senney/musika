<?php
require_once __DIR__ . "/../database/database.php";

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
		if (empty($result)) return false;
		return $result[0];
	}
	
	public function getPlaylists($userid) {
		$link = get_mysqli_link();
		$query = "SELECT * FROM playlist WHERE userId = ?";
		$result = mysqli_prepared_query($link, $query, "d", array($userid));
		if (empty($result)) return false;
		return $result;
	}

	public function getPlaylistSongs($pId){
		$link = get_mysqli_link();
		$query = "SELECT * FROM playlistentry WHERE playlistentry.pId = ?";
		$result = mysqli_prepared_query($link, $query, "d", array($pId));
		return $result;
	}
	
	public function sharePlaylist($userId, $pId, $message = null){
		$link = get_mysqli_link();
		$query = "INSERT INTO playlistshare Values(?, ?,?, ?)";
		$result = mysqli_prepared_query($link, $query, "dds", array(usrid(),$userId, $pId, $message));
	}
	
	public function addRating($userId, $pId, $rating){
		$link = get_mysqli_link();
		$query = "INSERT INTO playlistrating Values(?, ?, ?)";
		$result = mysqli_prepared_query($link, $query, "dddd", array($userId, $pId, $rating));
	}
	
	public function addSongToPlayList($song_id,$pid,$albumid){
		$link = get_mysqli_link();
		$query = "INSERT INTO playlistentry Values(?,?,?,?)";
		$result = mysqli_prepared_query($link,$query,"dddd",array(usrid(),$pid,$song_id,$albumid));
	
	
	}
	
	public function deleteSongFromPlaylist($songid,$pId,$albumid){
		$link = get_mysqli_link();
		$query = "DELETE FROM playlistentry WHERE userId = ? AND pId = ?".
		" AND sId = ? AND aId = ?";
		$result = mysqli_prepared_query($link,$query,"dddd",array(usrid(),$pId, $songid,$albumid));
	}
	
	public function deletePlayList($pid){
		$link = get_mysqli_link();
		$query = "DELETE FROM playlistentry WHERE pId = ?";
		$result = mysqli_prepared_query($link,$query,"d",array($pid));
		
		$query = "DELETE FROM playlistrating WHERE pId = ?";
		$result = mysqli_prepared_query($link,$query,"d",array($pid));
		
		$query = "DELETE FROM playlistshare WHERE pId = ?";
		$result = mysqli_prepared_query($link,$query,"d",array($pid));
		
		$query = "DELETE FROM playlist WHERE pId = ?";
		$result = mysqli_prepared_query($link,$query,"d",array($pid));
		
	}
	
	
}
?>