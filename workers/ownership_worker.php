<?php

require_once __DIR__ . "/../database/database.php";

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
	
	function removeSong($songid,$albumid){
		$query = "DELETE FROM songownership WHERE UID = ? AND AID = ? AND SID =?";
		$link = get_mysqli_link();
		mysqli_prepared_query($link,$query,"ddd",array($this->uid,$albumid,$songid));
	}
	
	function ownsSong($songid, $albumid) {
		$query = "SELECT * FROM songownership WHERE UID = ? AND AID = ? AND SID = ?";
		$link = get_mysqli_link();
		$result = mysqli_prepared_query($link, $query, "ddd", array($this->uid, $albumid, $songid));
		return !empty($result);
	}
	
	function addAlbum($albumid, $media) {
		$query = "INSERT INTO albumownership VALUES(?, ?, ?)";
		$link = get_mysqli_link();
		mysqli_prepared_query($link, $query, "ddd", array($this->uid, $albumid, $media));
		if (mysqli_error($link)) die(mysqli_error($link));
	}
	
	function removeAlbum($albumid) {
		$query = "DELETE FROM albumownership WHERE UID = ? AND AID = ?";
		$link = get_mysqli_link();
		mysqli_prepared_query($link,$query,"ddd",array($this->uid,$albumid));	
	}
	
	function ownsAlbum($albumid) {
		$query = "SELECT * FROM albumownership WHERE UID = ? AND AID = ?";
		$link = get_mysqli_link();
		$result = mysqli_prepared_query($link, $query, "dd", array($this->uid, $albumid));
		return !empty($result);	
	}
	
	function getUserSongData($limit, $page, $filter) {
		$start = $limit * $page;
	
		$query = "SELECT s.title AS songtitle, s.SID AS songid, ar.name AS artistname, ar.artistId AS artistid, al.name AS albumname, al.albumID AS albumid FROM songownership AS so " . 
		"JOIN song AS s ON s.SID = so.SID ".
		"JOIN artist AS ar ON ar.artistId = s.AID ".
		"JOIN album AS al ON al.albumID = so.AID ".
		"WHERE so.UID = ? ";
		$params = array($this->uid);
		$pstr = "d";
		if ($filter) {
			$filter = "%" . $filter . "%";
			$query .= "AND ((s.title LIKE ?) OR (al.name LIKE ?) OR (ar.name LIKE ?)) ";
			array_push($params, $filter);
			array_push($params, $filter);
			array_push($params, $filter);
			$pstr .= "sss";
		}
		$pstr .= "dd";
		$query .= "LIMIT ?, ?";
		array_push($params, $start);
		array_push($params, $limit);
		$link = get_mysqli_link();
		$result = mysqli_prepared_query($link, $query, $pstr, $params);
		if (mysqli_error($link)) die(mysqli_error($link));
		return $result;
	}
	
	function getUserSongCount($filter) {
		$link = get_mysqli_link();
		$query = "SELECT COUNT(*) AS c FROM songownership AS so ".
		"JOIN song AS s ON s.SID = so.SID ".
		"JOIN artist AS ar ON ar.artistId = s.AID ".
		"JOIN album AS al ON al.albumID = so.AID ".
		"WHERE so.UID = ? ";
		$params = array($this->uid);
		$pstr = "d";
		if ($filter) {
			$filter = "%" . $filter . "%";
			$query .= "AND ((s.title LIKE ?) OR (al.name LIKE ?) OR (ar.name LIKE ?)) ";
			array_push($params, $filter);
			array_push($params, $filter);
			array_push($params, $filter);
			$pstr .= "sss";
		}
		$ret = mysqli_prepared_query($link, $query, $pstr, $params);
		if (empty($ret)) return 0;
		return $ret[0]["c"];
	}
}

?>
