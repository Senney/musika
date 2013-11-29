<?php
include_once("./gracenote.php");
include_once("../php-gracenote/Gracenote.class.php");

function populate_cache_song($song_title, $album_name="", $artist_name="") {
	$search_type = Gracenote\WebAPI\GracenoteWebAPI::ALL_RESULTS;
	if ($album_name != "" || $artist_name != "")
		$search_type = Gracenote\WebAPI\GracenoteWebAPI::BEST_MATCH_ONLY;
	
	$api = get_gracenote_api();
	$results = $api->searchTrack($artist_name, $album_name, $song_title);
	echo "Result Array: " . sizeof($results);
	
	// Loop over all the albums returned and get all songs from those albums for caching.
	foreach ($results as $res) {
		$gnid = $res["album_gnid"];
		populate_cache_album_gnid($gnid);
	}
}

function populate_cache_album_gnid($album_gnid) {
	$api = get_gracenote_api();
	$results = $api->fetchAlbum($album_gnid);
	
	// Parse the album information into an album object.
	// Parse the artist information into an artist object.
		// Ensure that "Various Artists" is handled properly. 
		// Essentially this means that we step through each track on
		// the record and attribute each artist to the album.
	// Parse the track information.
}

populate_cache_song("Funkytown");

?>
