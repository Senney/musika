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
	
	function getUserSongData($limit, $page, $filter) {
		$start = $limit * $page;
	
		$query = "SELECT s.title AS songtitle, ar.name AS artistname, al.name AS albumname FROM songownership AS so " . 
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
