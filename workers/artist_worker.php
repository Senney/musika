<?php
require_once "../database/database.php";

class ArtistWorker {
	public function getArtist($artistId) {
		
	}
	
	/**
	 * Expects and artist object from the models/ directory.
	 **/
	public function saveArtist($artist) {
		if (!$artist || empty($artist->name)) {
			return -1;
		}
		
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

