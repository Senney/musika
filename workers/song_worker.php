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
	
	public function findSongArtistAlbum($song_name, $artist_id, $album_id) {
		$link = get_mysqli_link();
		
		$query = "SELECT * FROM song JOIN artist ON " .
				 "song.AID = artist.artistID JOIN albumsongs " .
				 "ON song.SID = albumsongs.songId WHERE " . 
				 "song.title = ? AND artist.artistID = ? AND " .
				 "albumsongs.albumId  = ?";
		$params = array($song_name, $artist_id, $album_id);
		$result = mysqli_prepared_query($link, $query, "sdd", $params);
		if (mysqli_error($link)) die(mysqli_error($link));
		
		return $result[0];
	}
}

?>

