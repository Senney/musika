<?php

require_once __DIR__ . "/../database/database.php";
require_once __DIR__ . "/../workers/album_worker.php";

class OwnershipWorker {
	
	private $uid;

	function __construct($userid) {
		$this->uid = $userid;
	}

	function addSong($songid, $albumid, $media = null) {
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
	
	function addAlbum($albumid, $media = null) {
		$query = "INSERT INTO albumownership VALUES(?, ?, ?)";
		$link = get_mysqli_link();
		mysqli_prepared_query($link, $query, "ddd", array($this->uid, $albumid, $media));
		
		$sw = new AlbumWorker();
		$songs = $sw->getAlbumSongs($albumid);
		foreach ($songs as $song) {
			$this->addSong($song["SID"], $albumid);
		}
		
		if (mysqli_error($link)) die(mysqli_error($link));
	}
	
	function removeAlbum($albumid) {
		$query = "DELETE FROM albumownership WHERE UID = ? AND AID = ?";
		$link = get_mysqli_link();
		mysqli_prepared_query($link,$query,"dd",array($this->uid,$albumid));	

		$sw = new AlbumWorker();
		$songs = $sw->getAlbumSongs($albumid);
		foreach ($songs as $song) {
			$this->removeSong($song["SID"], $albumid);
		}
	}
	
	function ownsAlbum($albumid) {
		$query = "SELECT * FROM albumownership WHERE UID = ? AND AID = ?";
		$link = get_mysqli_link();
		$result = mysqli_prepared_query($link, $query, "dd", array($this->uid, $albumid));
		return !empty($result);	
	}
	
	private function getSortMethod($sortstr) {
		switch($sortstr) {
			case "artist":
				return "ORDER BY ar.name ASC, al.name ASC ";
			case "song":
				return "ORDER BY s.title ASC ";
			case "album":
				return "ORDER BY al.name ASC ";
			case "genre":
				return "ORDER BY ge.type ASC ";
			case "rating":
				return "";
			default:
				return die(json_encode(array("error"=>"invalid sort")));
		}
	}
	
	function getUserSongData($limit, $page, $filter, $sort) {
		$start = $limit * $page;
	
		$query = "SELECT s.title AS songtitle, s.SID AS songid, ar.name AS artistname, ".
		"ar.artistId AS artistid, al.name AS albumname, al.albumID AS albumid, ge.type AS genretype ".
		"FROM songownership AS so " . 
		"JOIN song AS s ON s.SID = so.SID ".
		"JOIN artist AS ar ON ar.artistId = s.AID ".
		"JOIN album AS al ON al.albumID = so.AID ".
		"LEFT OUTER JOIN genre AS ge ON ge.GID = s.genre ".
		"WHERE so.UID = ? ";
		$params = array($this->uid);
		$pstr = "d";
		if ($filter) {
			$filter = "%" . $filter . "%";
			$query .= "AND ((s.title LIKE ?) OR (al.name LIKE ?) OR (ar.name LIKE ?) OR (ge.type LIKE ?)) ";
			array_push($params, $filter);
			array_push($params, $filter);
			array_push($params, $filter);
			array_push($params, $filter);
			$pstr .= "ssss";
		}		
		$query .= $this->getSortMethod($sort);
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
	
	public function getGenre($gid) {
		$link = get_mysqli_link();
		$query = "SELECT * FROM genre WHERE GID = ?";
		$result = mysqli_prepared_query($link, $query, "d", array($gid));
		if (empty($result)) return false;
		return $result[0]["type"];
	}
}

?>
