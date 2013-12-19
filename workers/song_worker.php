<?php
require_once __DIR__ . "/../database/database.php";

class SongWorker {
	public function getSong($song_id) {
		$query = "SELECT * FROM song WHERE SID = ?";
		$link = get_mysqli_link();
		$data = mysqli_prepared_query($link, $query, "d", array($song_id));
		if (mysqli_error($link) || empty($data)) {
			return false;
		}
		return $data[0];
	}
	
	public function getSongData($song_id, $album_id) {
		$link = get_mysqli_link();
		$query = "SELECT song.*, artist.name AS artistname, artist.artistId AS artistId, album.name AS albumname, album.albumID AS albumID ".
				 "FROM song JOIN artist ON " .
				 "song.AID = artist.artistID JOIN albumsongs " .
				 "ON song.SID = albumsongs.songId JOIN album ON ".
				 "albumsongs.albumId = album.albumID WHERE " . 
				 "song.SID = ? AND album.albumID = ?";
		$results = mysqli_prepared_query($link, $query, "dd", array($song_id, $album_id));
		if (mysqli_error($link)) die(mysqli_error($link));
		if (empty($results)) return false;
		
		return $results[0];
	}

	public function findSongName($song_name, $limit=10) {
		$link = get_mysqli_link();
		
		$query = "SELECT * FROM song WHERE title LIKE ? LIMIT ?;";
		$result = mysqli_prepared_query($link, $query, "sd",
			array($song_name, $limit));
		return $result;
	}
	
	public function findSongArtistName($song_name, $artist_id) {
		$link = get_mysqli_link();
		$query = "SELECT * FROM song WHERE title = ? AND AID = ?";
		$params = array($song_name, $artist_id);
		$result = mysqli_prepared_query($link, $query, "sd", $params);
		if (empty($result)) return false;
		return $result[0];
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
		
		$query = "SELECT song.*, artist.name AS artistname, artist.artistId AS artistId, album.name AS albumname, album.albumID AS albumID ".
				 "FROM song JOIN artist ON " .
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
		
		if ($limit > 0) {
			$query .= " LIMIT ?";
			array_push($params, $limit);
			$parstr .= "d";
		}
		
		$result = mysqli_prepared_query($link, $query, $parstr, $params);	
		
		return $result;
	}
	
	public function addSong($title, $artist_id, $desc = null, $genre = null) {
		$link = get_mysqli_link();
		$query = "INSERT INTO song VALUES(DEFAULT, ?, ?, ?, ?, NULL)";
		$params = array($title, $desc, $artist_id, $genre);
		mysqli_prepared_query($link, $query, "ssdd", $params);
		if (mysqli_error($link)) die(mysqli_error($link));
		return mysqli_insert_id($link);
	}
	
	public function setLength($song_id,$length){
		$link = get_mysqli_link();
		$query = "UPDATE song SET length = ? WHERE song.SID = ?";
		mysqli_prepared_query($link,$query,"dd",array($length,$song_id));	
	}
	
	public function setGenre($sid, $genre_name) {
		$query = "SELECT * FROM genre WHERE type = ?";
		$link = get_mysqli_link();
		$result = mysqli_prepared_query($link, $query, "s", array($genre_name));
		if (mysqli_error($link)) die(mysqli_error($link));
		
		if (empty($result)) {
			$query = "INSERT INTO genre VALUES(DEFAULT, ?, NULL)";
			$result = mysqli_prepared_query($link, $query, "s", array($genre_name));
			if (mysqli_error($link)) die(mysqli_error($link));
			$gid = mysqli_insert_id($link);
		} else {
			$gid = $result[0]["GID"];
		}
		
		$query = "UPDATE song SET genre = ? WHERE SID = ?";
		mysqli_prepared_query($link, $query, "dd", array($gid, $sid));
		if (mysqli_error($link)) die(mysqli_error($link));
	}
	
	public function getGenre($gid) {
		$link = get_mysqli_link();
		$query = "SELECT * FROM genre WHERE GID = ?";
		$result = mysqli_prepared_query($link, $query, "d", array($gid));
		if (empty($result)) return false;
		return $result[0]["type"];
	}
}

?>

