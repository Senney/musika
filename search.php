<?php
require_once "./common/common.php";
require_once "./workers/artist_worker.php";
require_once "./workers/album_worker.php";
require_once "./workers/song_worker.php";
require_once "./workers/ownership_worker.php";
require_once "./workers/song_rating_worker.php";

if (!isset($_GET["song-name"]) && !isset($_GET["album-name"]) && !isset($_GET["artist-name"])) {
	header("Location: add.php");
	die();
}

$song = new SongWorker();
$album = new AlbumWorker();
$artist = new ArtistWorker();

$artist_results = array();
$album_results = array();
$song_results = array();

$song_name = isset($_GET["song-name"]) ? $_GET["song-name"] : null;
$artist_name = isset($_GET["artist-name"]) ? $_GET["artist-name"] : null;
$album_name = isset($_GET["album-name"]) ? $_GET["album-name"] : null;

if (empty($song_name) && empty($album_name) && !empty($artist_name)) {
	// Search for artists.
	$decstr = "Searching for artists like: <strong>" . $artist_name . "</strong>.";
	$artist_results = $artist->findArtistName($artist_name);
} else if (empty($song_name) && !empty($album_name)) {
	// Search for albums and artists (if isset).
	$decstr = "Searching for albums like: <strong>" . $album_name . "</strong>";
	if (!empty($artist_name)) $decstr .= " by <strong>" . $artist_name . "</strong>";
	$decstr .= ".";
	$album_results = $album->findAlbumArtistName($album_name, $artist_name);
} else if (!empty($song_name)) {
	$decstr = "Searching for songs with titles like <strong>" . $song_name . "</strong>";
	if (!empty($album_name)) $decstr .= " on albums named like <strong>" . $album_name . "</strong>";
	if (!empty($artist_name)) $decstr .= " by artists named similar to <strong>" . $artist_name . "</strong>";
	$decstr .= ".";

	// Search for songs with artist and album if isset.
	$song_name = "%" . $song_name . "%";
	$artist_name = (!empty($artist_name)) ? "%" . $artist_name . "%" : $artist_name;
	$album_name = (!empty($album_name)) ? "%" . $album_name . "%" : $album_name;
	$song_results = $song->findSongArtistAlbumName($song_name, $artist_name, $album_name, 100);
} else {
	$decstr = "No search parameters included.";
}

function renderSongTable($song_results) {
	$owner = new OwnershipWorker(usrid());
	$rw = new SongRatingWorker();
?>
<div class="row">
	<div class="col-md-12">
		<h4>Song Results (<?=count($song_results);?>)</h4>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<table class="table table-hover search-table">
			<thead>
				<th class="song-row">Song Title</th>
				<th>Album</th>
				<th>Artist</th>
				<th>Rating</th>
				<th>&nbsp;</th>
			</thead>
			<tbody>
				<?php
				foreach ($song_results as $s) {
					$rating = $rw->getAverage($s["SID"]);
				?>
				<tr>
					<td><a href="song.php?id=<?=$s["SID"];?>"><?=$s["title"];?></a></td>
					<td><a href="album.php?id=<?=$s["albumID"];?>"><?=$s["albumname"];?></a></td>
					<td><a href="artist.php?id=<?=$s["artistId"];?>"><?=$s["artistname"];?></a></td>
					<td><?=round($rating, 2);?> Stars</td>
					<td>
					<?php
					$url = "handlers/song_handler.php?songid=".$s["SID"]."&albumid=".$s["albumID"];
					if ($owner->ownsSong($s["SID"], $s["albumID"])) {
					?>
						<a href="<?=$url;?>" class="btn badge badge-danger pull-right">
							Remove From Library
						</a>
					<?php
					} else {
					?>
						<a href="<?=$url;?>" class="btn badge badge-success pull-right">Add To Library</a>
					<?php
					}
					?>
					</td>
				</tr>
				<?php
				}
				?>
			</tbody>
		</table>
	</div>
</div>
<?php
}

function renderArtistTable($artist_results) {
?>
<div class="row">
	<div class="col-md-12">
		<h4>Artist Results (<?=count($artist_results);?>)</h4>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<table class="table table-hover search-table">
			<thead>
				<th>Artist Name</th>
			</thead>
			<tbody>
				<?php
				foreach ($artist_results as $s) {
				?>
				<tr>
					<td><a href="artist.php?id=<?=$s["artistId"];?>"><?=$s["name"];?></a></td>
				</tr>
				<?php
				}
				?>
			</tbody>
		</table>
	</div>
</div>
<?php
}

function renderAlbumTable($album_results) {
	$owner = new OwnershipWorker(usrid());
	$aw = new AlbumWorker();
?>
<div class="row">
	<div class="col-md-12">
		<h4>Album Results (<?=count($album_results);?>)</h4>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<table class="table table-hover search-table">
			<thead>
				<th class="song-row">Album Title</th>
				<th>Artist</th>
				<th>Total Songs</th>
				<th>&nbsp;</th>
			</thead>
			<tbody>
				<?php
				foreach ($album_results as $s) {
					$total_songs = count($aw->getAlbumSongs($s["albumId"]));
				?>
				<tr>
					<td><a href="album.php?id=<?=$s["albumId"];?>"><?=$s["albumname"];?></a></td>
					<td><a href="artist.php?id=<?=$s["artistId"];?>"><?=$s["artistname"];?></a></td>
					<td><?=$total_songs;?></td>
					<td>
					<?php
					$url = "handlers/album_handler.php?albumid=".$s["albumId"];
					if ($owner->ownsAlbum($s["albumId"])) {
					?>
						<a href="<?=$url;?>" class="btn badge badge-danger pull-right">
							Remove From Library
						</a>
					<?php
					} else {
					?>
						<a href="<?=$url;?>" class="btn badge badge-success pull-right">Add To Library</a>
					<?php
					}
					?>
					</td>
				</tr>
				<?php
				}
				?>
			</tbody>
		</table>
	</div>
</div>
<?php
}

?>

<!DOCTYPE html>
<html>
    <head>
        <title>Musika - Music Library</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <?php
        load_bootstrap_css();
        ?>
		<script src="js/rating.js"></script>
		<script>
			$(function() {
				setup_raters("null", true);
			});
		</script>
    </head>
    <body>
		<?php
		require_once "./common/navbar.php";
		?>
		
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<h4><?=$decstr;?></h4>
				</div>
			</div>
			<?php
			if (!empty($song_results)) {
				renderSongTable($song_results);
			} else if (!empty($artist_results)) {
				renderArtistTable($artist_results);
			} else if (!empty($album_results)) {
				renderAlbumTable($album_results);
			} else {
				
			}
			?>			
		</div>
	</body>
</html>
