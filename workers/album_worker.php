<?php
require_once __DIR__ . "/../database/database.php";

class AlbumWorker {
	function getAlbum($albumId) {
		$link = get_mysqli_link();
		$query = "SELECT * FROM album WHERE albumID=?";
		$result = mysqli_prepared_query($link, $query, "d", array($albumId));
		return $result[0];
	}
	
	function getContributors($albumId) {
		$link = get_mysqli_link();
		$query = "SELECT * FROM albumcontributor AS ac JOIN artist AS ar ON ar.artistId = ac.artistId WHERE ac.albumId = ?";
		$result = mysqli_prepared_query($link, $query, "d", array($albumId));
		if (mysqli_error($link)) die(mysqli_error($link));
		if (empty($result)) return false;
		return $result;
	}

	function getAlbumsSongId($songId) {
		$link = get_mysqli_link();
        $query = "SELECT * FROM albumsongs JOIN album ON " .
                 "albumsongs.albumId = album.albumID WHERE " .
                 "albumsongs.songId = ?";
        $result = mysqli_prepared_query($link, $query, "d", array($songId));
		if (empty($result)) return false;
		
		return $result;
	}

    function getAlbumSongId($songId) {
		$result = $this->getAlbumsSongId($songId);
        return $result[0];
    }
	
	function getAlbumSongs($albumId) {
		$link = get_mysqli_link();
		$query = "SELECT song.* FROM albumsongs JOIN song ON " . 
				 "song.SID = albumsongs.songId " .
				 "WHERE albumsongs.albumId = ?";
		$result = mysqli_prepared_query($link, $query, "d", array($albumId));
		return $result;
	}
	
	function getAlbumArtistName($title, $artist) {
		$link = get_mysqli_link();
		$query = "SELECT al.albumID FROM album AS al" .
		"JOIN albumcontributor AS ac ON ac.albumId = al.albumID " . 
		"JOIN artist AS ar ON ar.artistId = ac.artistId " . 
		"WHERE al.name = ? AND ar.name = ?";
		$params = array($title, $artist);
		$result = mysqli_prepared_query($link, $query, "ss", $params);
		if (empty($result)) return false;
		return $result[0];
	}
	
	function getAlbumArtist($title, $artistId) {
		$link = get_mysqli_link();
		$query = "SELECT * FROM album JOIN albumcontributor ON " . 
		         "album.albumID = albumcontributor.albumId WHERE " . 
				 "album.name = ? AND albumcontributor.artistId = ?";
		$params = array($title, $artistId);
		$result = mysqli_prepared_query($link, $query, "sd", $params);
		if (empty($result)) return false;
		
		return $result[0];
	}
	
	function addSong($alid, $sid) {
		$link = get_mysqli_link();
		$query = "INSERT INTO albumsongs VALUES(?, ?)";
		$params = array($alid, $sid);
		mysqli_prepared_query($link, $query, "dd", $params);
	}
	
	function addAlbum($title, $artistid, $year=null, $genre=null) {
		$link = get_mysqli_link();
		$query = "INSERT INTO album VALUES(DEFAULT, ?, ?, ?)";
		$params = array($title, $year, $genre);
		mysqli_prepared_query($link, $query, "sdd", $params);
		if (mysqli_error($link)) die(mysqli_error($link));
		$retid = mysqli_insert_id($link);
		$acq = "INSERT INTO albumcontributor VALUES(?, ?)";
		mysqli_prepared_query($link, $acq, "dd", array($artistid, $retid));
		return $retid;
	}
	/*
	function addAlbum($title, $artist_array) {
		// Check if the album exists already.
		
		$link = get_mysqli_link();
		$query = "INSERT INTO album(`name`) VALUES(?)";
		$params = array($title);
		mysqli_prepared_query($link, $query, "s", $params);
		if (mysqli_error($link)) die("Unable to create album " . $title);
		foreach ($artist_array as $a) {
			$query = "INSERT INTO albumcontributor VALUES(?, ?)";
			$params = array(mysqli_insert_id(), $a);
			mysqli_prepared_query($link, $query, "dd", $params);
			if (mysqli_error($link)) die("Unable to add artist to album " . $a);
		}
	}
	*/
}

?>

