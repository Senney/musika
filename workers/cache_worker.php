<?php

require_once __DIR__ . "/album_worker.php";
require_once __DIR__ . "/artist_worker.php";
require_once __DIR__ . "/song_worker.php";
require_once __DIR__ . "/itunes_worker.php";

class CacheWorker {
	public function should_cache($artist_name) {
		$link = get_mysqli_link();
		$query = "SELECT ic.* FROM itunescache AS ic ".
		"JOIN artist AS ar ON ic.artistId = ar.artistId ".
		"WHERE ar.name = ?";
		$res = mysqli_prepared_query($link, $query, "s", array($artist_name));
		return empty($res);
	}
	
	private function set_cache($artist_id) {
		$link = get_mysqli_link();
		$query = "INSERT INTO itunescache VALUES(?)";
		mysqli_prepared_query($link, $query, "d", array($artist_id));
	}

	public function cache_artist($artist_name) {
		$itunes = new iTunesWorker();
		$albums = $itunes->get_artist_albums($artist_name);
		if ($albums == -1) {
			return -1;
		}
		
		$artist_worker = new ArtistWorker();
		$artist = $artist_worker->getArtistName($albums[0]["artistName"]);
		if (!$artist) {
			$a = $albums[0];
			$id = $artist_worker->saveArtist($a["artistName"]);
			$artist = $artist_worker->getArtist($id);
		}
		if (isset($albums[0]["primaryGenreName"])) $artist_worker->setGenre($artist["artistId"], $albums[0]["primaryGenreName"]);

		$count = 0;
		foreach ($albums as $alb) {
			if ($alb["wrapperType"] == "collection") {
				$count += $this->cache_album($alb, $artist["artistId"], $itunes);
			}
		}
		
		$this->set_cache($artist["artistId"]);
		return $count;
	}
	
	public function cache_album($alb, $aid, $itunes) {
		// Cache the album.
		$album_worker = new AlbumWorker();
		$aname = $alb["collectionName"];
		$album = $album_worker->getAlbumArtist($aname, $aid);
		if (!$album) {
			$date = date_parse($alb["releaseDate"])["year"];
			$albid = $album_worker->addAlbum($aname, $aid, $date);
			$album = $album_worker->getAlbum($albid);
		}
		if (isset($alb["primaryGenreName"])) $album_worker->setGenre($album["albumID"], $alb["primaryGenreName"]);
		
		$songs = $itunes->get_album_songs($alb["collectionId"]);
		$count = 0;
		foreach ($songs as $song) {
			if ($song["wrapperType"] == "track") {
				$count += $this->cache_song($song, $album["albumID"], $aid, $album_worker);
			}
		}
		
		return $count;
	}
	
	public function cache_song($song, $albid, $aid, $album_worker) {
		$song_worker = new SongWorker();
		
		$sname = $song["trackName"];
		$cached = $song_worker->findSongArtistName($sname, $aid);
		$ret = 0;
		if (!$cached) {
			$sid = $song_worker->addSong($sname, $aid);
			$cached = $song_worker->getSong($sid);
			$ret = 1;
		}
		$album_worker->addSong($albid, $cached["SID"]);
		if (isset($song["trackTimeMillis"])) $song_worker->setLength($cached["SID"], $song["trackTimeMillis"]);
		if (isset($song["primaryGenreName"])) $song_worker->setGenre($cached["SID"], $song["primaryGenreName"]);
		return $ret;
	}
}

?>
