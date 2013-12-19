<?php
require_once __DIR__ . "/../database/database.php";

class AlbumWorker {
	function getAlbum($albumId) {
		$link = get_mysqli_link();
		$query = "SELECT * FROM album WHERE albumID=?";
		$result = mysqli_prepared_query($link, $query, "d", array($albumId));
		return $result[0];
	}
	
	function findAlbumArtistName($album_name, $artist_name) {
		$link = get_mysqli_link();
		$query = "SELECT al.name AS albumname, ar.name AS artistname, ar.artistId AS artistId, al.albumID AS albumId ".
		"FROM album AS al ".
		"JOIN albumcontributor AS ac ON ac.albumId = al.albumId " .
		"JOIN artist AS ar ON ar.artistID = ac.artistId " .
		"WHERE al.name LIKE ? ";
		$album_name = '%' . $album_name . '%';
		$params = array($album_name);
		$pstr = "s";
		if (!empty($artist_name)) {
			$artist_name = '%' . $artist_name . '%';
			$query .= "AND ar.name LIKE ?";
			array_push($params, $artist_name);
			$pstr .= "s";
		}
		$result = mysqli_prepared_query($link, $query, $pstr, $params);
		return $result;
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
	
	public function setGenre($aid, $genre) {
		$query = "SELECT * FROM genre WHERE type = ?";
		$link = get_mysqli_link();
		$result = mysqli_prepared_query($link, $query, "s", array($genre));
		if (mysqli_error($link)) die(mysqli_error($link));
		
		if (empty($result)) {
			$query = "INSERT INTO genre VALUES(DEFAULT, ?, NULL)";
			$result = mysqli_prepared_query($link, $query, "s", array($genre));
			if (mysqli_error($link)) die(mysqli_error($link));
			$gid = mysqli_insert_id($link);
		} else {
			$gid = $result[0]["GID"];
		}
	
		$query = "UPDATE album SET genre = ? WHERE albumID = ?";
		mysqli_prepared_query($link, $query, "dd", array($gid, $aid));
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

}

?>

