<?php
require_once "../common/common.php";
require_once "../workers/ownership_worker.php";
require_once "../workers/song_worker.php";
require_once "../workers/song_rating_worker.php";
require_once "../workers/playlist_worker.php";

logged_in_redirect();

$type = $_GET["type"];
$limit = isset($_GET["limit"]) ? $_GET["limit"] : 100;
$page = isset($_GET["page"]) ? $_GET["page"] : 0;
$filter = isset($_GET["filter"]) ? $_GET["filter"] : false;
$sort = isset($_GET["sort"]) ? $_GET["sort"] : false;
$userid = usrid();

$worker = new OwnershipWorker($userid);
$sw = new SongWorker();
$plw = new PlaylistWorker();
$playlists = $plw->getPlaylists($userid);
if ($type == "song") {
	$returndata = array("head" => array("Title", "Artist", "Album", "Genre", "Rating", "Options"), "data" => array());
	$songs = $worker->getUserSongData($limit, $page, $filter, $sort);
	$retsongs = array();
	for ($i = 0; $i < count($songs); $i++) {
		$newsong = array();
		$song = $songs[$i];
		$genre = "<span>" . (empty($song["genretype"]) ? "-" : $song["genretype"]) . "</span>";
		$newsong["title"] = "<a href='song.php?id=".$song["songid"]."'>".$song["songtitle"]."</a>";
		$newsong["artist"] = "<a href='artist.php?id=".$song["artistid"]."'>".$song["artistname"]."</a>";
		$newsong["album"] = "<a href='album.php?id=".$song["albumid"]."'>".$song["albumname"]."</a>";
		$newsong["genre"] = $genre;
		$newsong["rating"] = "<span>My Rating</span>";
		
		$pl_list = "";
		if ($playlists) {
			foreach ($playlists as $pl) {
				$pl_list .= '<li><a href="handlers/add_playlist_handler.php?type=3&song-id='.$song["songid"].'&album-id='.$song["albumid"].
							'&playlist-id='.$pl["pId"].'" id="reviewhover" rel="popover" placement="right" data-content="">'.$pl["name"].'</a></li>';
			}
		}
		$newsong["playlist"] = '
			<div class="btn-group">
				<button class="btn btn-xs btn-info dropdown-toggle" data-toggle="dropdown">Add to Playlist</button>
				<button class="btn btn-xs btn-info dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></button>
				<ul class="dropdown-menu">' . $pl_list . '
				</ul>
			</div>';
		array_push($retsongs, $newsong);
	}
	$returndata["data"] = $retsongs;
	die(json_encode($returndata));
} else if ($type == "count") {
	echo $worker->getUserSongCount($filter);
	die();
}

die(json_encode(array("error"=>"Invalid")));

?>
