<?php

require_once __DIR__ . "/itunes_worker.php";

class CacheWorker {
	public function cache_artist($artist_name) {
		$itunes = new iTunesWorker();
		$albums = $itunes->get_artist_albums($artist_name);
		if ($albums == -1) {
			return -1;
		}
		print_r($albums);
		die();
	}
	
	public function cache_album($album_name, $artist_name) {
	
	}
}

?>
