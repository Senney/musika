<?php
require_once __DIR__ . "/../database/database.php";

class ArtistWorker {
	public function getArtist($artistId) {
		$link = get_mysqli_link();
		$query = "SELECT * FROM artist WHERE artistId = ?";
		$result = mysqli_prepared_query($link, $query, "d", array($artistId));
		return $result[0];
	}
	
	public function getArtistName($name) {
		$link = get_mysqli_link();
		$query = "SELECT * FROM artist WHERE name = ?";
		$result = mysqli_prepared_query($link, $query, "s", array($name));
		if (empty($result)) return false;
		return $result[0];		
	}
	
	function getArtistSongs($artistId) {
		$query = "SELECT * FROM song WHERE AID = ?";
		$link = get_mysqli_link();
		$result = mysqli_prepared_query($link, $query, "d", array($artistId));
		if (empty($result)) return false;
		return $result;
	}
	
	function getArtistAlbums($artistId) {
		$query = "SELECT al.* FROM album AS al JOIN albumcontributor AS ac ON al.albumId = ac.albumId WHERE ac.artistId = ?";
		$link = get_mysqli_link();
		$result = mysqli_prepared_query($link, $query, "d", array($artistId));
		if (empty($result)) return false;
		return $result;	
	}
	
	public function saveArtist($name, $desc=null, $era=null, $genre=null) {
		$link = get_mysqli_link();
		$query = "INSERT INTO artist VALUES(DEFAULT, ?, ?, ?, ?)";
		$params = array($name, $desc, $era, $genre);
		mysqli_prepared_query($link, $query, "ssdd", $params);
		if (mysqli_error($link)) die(mysqli_error($link));
		return mysqli_insert_id($link);
	}
	
	/**
	 * Expects and artist object from the models/ directory.

	public function saveArtist($artist) {
		if (!$artist || empty($artist->name)) {
			return -1;
		}
		
		echo "Caching artist: " . $artist->name;
		$link = get_mysqli_link();
		$query = "INSERT INTO Artist(DEFAULT, ?, ?, ?, ?)";
		$params = $artist->toWorkerArray();
		$result = mysqli_prepared_query($link, $query, "ssdd", $params);
		if (mysqli_error() || empty($result)) {
			return -1;
		}
		
		return 0;
	}
		 **/
}

?>

