<?php
require_once __DIR__ . "/../database/database.php";

class SongWorker {
	public function getSong($song_id) {
		$query = "SELECT * FROM song WHERE SID = ?";
		$link = get_mysqli_link();
		$data = mysqli_prepared_query($link, $query, "d", array($song_id));
		if (mysqli_error($link)) {
			return -1;
		}
		return $data;
	}

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
	
	public function findSongArtistAlbumName($song_name, $artist_name, $album_name, $limit=10) {
		$link = get_mysqli_link();
		
		$query = "SELECT * FROM song JOIN artist ON " .
				 "song.AID = artist.artistID JOIN albumsongs " .
				 "ON song.SID = albumsongs.songId JOIN album ON ".
				 "albumsongs.albumId = album.albumID WHERE " . 
				 "song.title LIKE ?";
		$params = array($song_name);
		$parstr = "s";
		if (isset($artist_name) && !empty($artist_name)) {
			$query .= " AND artist.name LIKE ?";
			array_push($params, $artist_name);
			$parstr .= "s";
		}
		if (isset($album_name) && !empty($album_name)) {
			$query .= " AND album.name LIKE ?";
			array_push($params, $album_name);
			$parstr .= "s";
		}
		$query .= " LIMIT ?";
		array_push($params, $limit);
		$parstr .= "d";
		
		$result = mysqli_prepared_query($link, $query, $parstr, $params);	
		
		return $result;
	}
}

?>

