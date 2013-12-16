<?php
require_once "../common/common.php";
require_once "../workers/song_worker.php";
require_once "../workers/artist_worker.php";
require_once "../workers/album_worker.php";
require_once "../workers/ownership_worker.php";
require_once "../workers/cache_worker.php";

if (!keys_exist($_POST, array(
		"song-name", "artist-name", "album-name", "media-type"
	))) {
	header("Location: ../add.php?error=0");
	exit(1);
}

$artist_worker = new ArtistWorker();
$album_worker = new AlbumWorker();
$song_worker = new SongWorker();
$ownership_worker = new OwnershipWorker(usrid());
$cache_worker = new CacheWorker();

$song_name = $_POST["song-name"];
$artist_name = $_POST["artist-name"];
$album_name = $_POST["album-name"];
$media_type = $_POST["media-type"];

if ($cache_worker->should_cache($artist_name)) {
	$cache_worker->cache_artist($artist_name);
}

$artist = $artist_worker->getArtistName($artist_name);
if (!$artist)
	die("Invalid artist.");
print_r($artist);
$alid = $album_worker->getAlbumArtist($album_name, $artist["artistId"]);
if (!$alid) die("No such album exists.");
print_r($alid);
$result = $song_worker->findSongArtistAlbum($song_name, $artist["artistId"],
	$alid["albumID"]);
print_r($result);

$ownership_worker->addSong($result["SID"], $result["albumId"], $media_type);

?>