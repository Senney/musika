<?php

require_once "album_worker.php";

$w = new AlbumWorker();

print_r($w->getAlbumArtistName("Always", "Blink-182"));

?>
