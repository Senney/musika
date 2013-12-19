<?php
require_once "../common/common.php";
require_once "../workers/song_worker.php";
require_once "../workers/artist_worker.php";
require_once "../workers/album_worker.php";
require_once "../workers/ownership_worker.php";
require_once "../workers/cache_worker.php";

if (keys_exist($_GET, array("albumid"))) {
	$album_worker = new AlbumWorker();
	$owner_worker = new OwnershipWorker(usrid());
	$aid = $_GET["albumid"];
	if (!$album_worker->getAlbum($aid)) {
		header("Location: index.php");
		die();
	}
	
	if ($owner_worker->ownsAlbum($aid)) {
		$owner_worker->removeAlbum($aid);
	} else {
		$owner_worker->addAlbum($aid);
	}
	
	redirect_back();
}

?>
