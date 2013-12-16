<?php
require_once __DIR__ . "/../database/database.php";

class AlbumWorker {
	function getAlbumsSongId($songId) {
		$link = get_mysqli_link();
        $query = "SELECT * FROM albumsongs JOIN album ON " .
                 "albumsongs.albumId = album.albumID WHERE " .
                 "albumsongs.songId = ?";
        $result = mysqli_prepared_query($link, $query, "d", array($songId));
		if (empty($result)) return false;
		
		return $result;
	}

    function getAlbumSongID($songId) {
		$result = getAlbumSongsId($songId);
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
	
	function addAlbum($title, $artist_array) {
		// Check if the album exists already.
		
		$link = get_mysqli_link();
		$query = "INSERT INTO album(`name`) VALUES(?)";
		$params = array($title);
		mysqli_prepared_query($link, $query, "s", $params);
		if (mysqli_error($link)) die("Unable to create album " . $title);
		foreach ($artist_array as $a) {
			$query = "INSERT INTO albumcontributor VALUES(?, ?)";
			$params = array(mysqli_insert_id(), $a);
			mysqli_prepared_query($link, $query, "dd", $params);
			if (mysqli_error($link)) die("Unable to add artist to album " . $a);
		}
	}
}

?>

