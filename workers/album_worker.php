<?php
require_once "../database/database.php";

class AlbumWorker {
    function getAlbumSongID($songId) {
        $link = get_mysqli_link();
        $query = "SELECT * FROM albumsongs JOIN album ON " .
                 "albumsongs.albumId = album.albumID WHERE " .
                 "albumsongs.songId = ?";
        $result = mysqli_prepared_query($link, $query, "d", array($songId));
        return $result;
    }    
}

?>

