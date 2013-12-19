<?php
require_once "./common/common.php";
require_once "./workers/playlist_worker.php";
require_once "./workers/song_worker.php";
require_once "./workers/song_rating_worker.php";
require_once "./workers/user_worker.php";

if (!isset($_GET["id"])) {
	header("Location: playlist.php");
	die();
}

$plw = new PlaylistWorker();
$sw = new SongWorker();
$pl = $plw->getPlaylist($_GET["id"]);
$songs = $plw->getPlaylistSongs($_GET["id"]);
$srate = new SongRatingWorker();
$uw = new UserWorker();

?>

<!DOCTYPE html>
<html>
    <head>
        <title>Musika - Music Library</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
		<script src="js/rating.js"></script>
        <?php
        load_bootstrap_css();
        ?>
		<script>
		$(function(){
			setup_raters("handlers/song_rating_handler.php", false);
			setup_raters_class(".playlist-rate", "handlers/playlist_rating_handler.php", false);
			});
		</script>
		
    </head>
    <body>
		<?php
		require_once "./common/navbar.php";
		?>
		<div class="container">
			<div class = "row">
				<div class="col-md-8">
					<h4><a href="playlist.php">My Playlists</a> > <?=$pl["name"];?> <small><?=count($songs);?> song<?=count($songs)==1?"":"s";?></small></h4>	
				</div>
				<div class="col-md-4">
					<span class="pull-right">
						Playlist Rating
						<div class="playlist-rate" data-average="<?=$plw->getAverageRating($pl["pId"]);?>" data-id="<?=$pl["pId"];?>"></div>
					</span>	
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
				<?php
				if (!empty($songs)) {
				?>
					<table class="table table-hover search-table">
						<thead>
							<th class="song-row">Song Title</th>
							<th>Album</th>
							<th>Artist</th>
							<th>Rating</th>
							<th>Control</th>
						</thead>
						<tbody>
							<?php
							foreach ($songs as $sr) {
								$s = $sw->getSongData($sr["sId"], $sr["aId"]);
								$rating = $srate->getAverage($s["SID"]);
								$url = "handlers/add_playlist_handler.php?type=4";
							?>
							<tr>
								<td><a href="song.php?id=<?=$s["SID"];?>"><?=$s["title"];?></a></td>
								<td><a href="album.php?id=<?=$s["albumID"];?>"><?=$s["albumname"];?></a></td>
								<td><a href="artist.php?id=<?=$s["artistId"];?>"><?=$s["artistname"];?></a></td>
								<td><div class="song-rating" data-average="<?=$rating;?>" data-id="<?=$s["SID"];?>"></div></td>
								<td>
								<?php
									if (usrid() == $pl["userId"]) {
								?>
									<div class="btn-group">
										<button class="btn btn-xs btn-danger dropdown-toggle" data-toggle="dropdown">Options</button>
										<button class="btn btn-xs btn-danger dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></button>
										<ul class="dropdown-menu">
											<li>
												<a href="<?=$url;?>&song-id=<?=$s["SID"];?>&album-id=<?=$s["albumID"];?>&playlist-id=<?=$_GET["id"];?>" id="reviewhover" rel="popover" placement="right" data-content="">
													Remove From Playlist
												</a>
											</li>
										</ul>
									</div>
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
				<?php
				} else {
				?>
					<div class="alert alert-info">
						No songs have been added to this playlist.
					</div>
				<?php
				}
				?>
				</div>
			</div>
		</div>
	</body>
</html>
