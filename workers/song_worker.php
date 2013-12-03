<?php
require_once "../database/database.php";

class SongWorker {
	public function findSongName($song_name) {
		$link = get_mysqli_link();
		
		$query = "SELECT * FROM ((song JOIN ".
			"albumsongs ON albumsongs.songId = song.SID) ".
			"JOIN album ON albumsongs.albumId = album.albumID) ".
			"WHERE title LIKE ?;";
		$result = mysqli_prepared_query($link, $query, "s",
			array($song_name));
		return $result;
	}
}

?>

