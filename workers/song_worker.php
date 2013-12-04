<?php
require_once "../database/database.php";

class SongWorker {
	public function findSongName($song_name, $limit=10) {
		$link = get_mysqli_link();
		
		$query = "SELECT * FROM song WHERE title LIKE ? LIMIT ?;";
		$result = mysqli_prepared_query($link, $query, "sd",
			array($song_name, $limit));
		return $result;
	}
}

?>

