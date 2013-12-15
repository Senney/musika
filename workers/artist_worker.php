<?php
require_once "../database/database.php";

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
		return $result[0];		
	}
	
	/**
	 * Expects and artist object from the models/ directory.
	 **/
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
}

?>

