<?php

require_once "../database/database.php";

class OwnershipWorker {
	
	private $uid;

	function __construct($userid) {
		$this->uid = $userid;
	}

	function addSong($songid, $albumid, $media) {
		$query = "INSERT INTO songownership VALUES(?, ?, ?, ?)";
		$params = array($this->uid, $songid, $albumid, $media);
		print_r($params);
		$link = get_mysqli_link();
		mysqli_prepared_query($link, $query, "dddd", $params);
		if (mysqli_error($link)) die(mysqli_error($link));
	}
	
	function getUserSongData() {
		$query = "SELECT s.title AS songtitle, ar.name AS artistname, al.name AS albumname FROM songownership AS so " . 
		"JOIN song AS s ON s.SID = so.SID ".
		"JOIN artist AS ar ON ar.artistId = s.AID ".
		"JOIN album AS al ON al.albumID = so.AID ".
		"WHERE so.UID = ?";
		$link = get_mysqli_link();
		$result = mysqli_prepared_query($link, $query, "d", array($this->uid));
		return $result;
	}
}

?>
