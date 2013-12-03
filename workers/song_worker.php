<?php
require_once "../database/database.php";

class SongWorker {
	public function findSongName($song_name) {
		$link = get_mysqli_link();
		$query = "SELECT * FROM song JOIN WHERE title LIKE ?";
		$result = mysqli_prepared_query($link, $query, "s",
			array($song_name));
		return $result;
	}
}

?>

