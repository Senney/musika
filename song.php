<?php
require_once "./common/common.php";
require_once "./workers/song_worker.php";
require_once "./workers/artist_worker.php";
require_once "./workers/album_worker.php";
require_once "./workers/ownership_worker.php";

$worker = new SongWorker();
$artist = new ArtistWorker();
$album = new AlbumWorker();
$owner = new OwnershipWorker(usrid());

if (!isset($_GET["id"])) {
	$errmsg = "A song ID is required to view a song.";
}
else {
	$song_data = $worker->getSong($_GET["id"]);
	if ($song_data == -1 || empty($song_data)) {
		$errmsg = "Invalid song ID.";
	} else {
		$song_data = $song_data;
		$artist_data = $artist->getArtist($song_data["AID"]);
		$album_data = $album->getAlbumsSongID($_GET["id"]);
	}
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
    </head>
    <body>
		<?php
		require_once "./common/navbar.php";
		
		// Handle missing ID.
		if (isset($errmsg)) {
		?>
		<div class="alert alert-danger">
			<?php echo $errmsg; ?>
		</div>
	</body>
</html>
		<?php
			exit(1);
		}
		?>
		
		<div class = "container">
			<div class = "row">
				<div class="col-md-12">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h3><?php echo $song_data["title"]; ?></h3>
						</div>
						<div class="panel-body">
							<div class="row">
								<div class="col-md-6">
									<h4>By <a href="artist.php?id=<?=$artist_data["artistId"];?>"><?=$artist_data["name"];?></a></h4>
								</div>
								<div class="col-md-6">
								</div>
							</div>
							<div class="row">
									<hr />
								<div class="col-md-6">
									<h4>Description</h4>
									<p><?php
									if (empty($song_data["description"])) {
									?>
										No description entered.
									<?php
									} else {
										echo $song_data["description"];
									}
									?></p>
								</div>
								<div class="col-md-3">
									<h4>Attributes</h4>
									<table class="table table-bordered table-condensed">
										<thead>
											<th>Attribute</th>
											<th>Value</th>
										</thead>
										<tbody>
											<tr>
												<td>Song Length</td>
												<td><?=fmt_milliseconds($song_data["length"]);?></td>
											</tr>
											<tr>
												<td>Genre</td>
												<td><?=$worker->getGenre($song_data["genre"]);?></td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<h4>Albums</h4>
									<ul class="list-group">
									<?php
									foreach ($album_data as $album) {
									?>
										<li class="list-group-item">
											<div class="row">
												<div class="col-md-8">
													<a href="album.php?id=<?=$album["albumId"];?>">
														<?=$album["name"];?>
													</a>
												</div>
												<div class="col-md-4">
												<?php
												$url = "handlers/song_handler.php?songid=".$_GET["id"]."&albumid=".$album["albumId"];
												if ($owner->ownsSong($_GET["id"], $album["albumId"])) {
												?>
													<a href="<?=$url;?>" class="btn badge badge-danger pull-right">
														Remove Song From Library
													</a>
												<?php
												} else {
												?>
													<a href="<?=$url;?>" class="btn badge badge-success pull-right">Add Song To Library</a>
												<?php
												}
												?>
												</div>
											</div>
										</li>
									<?php
									}
									?>
									</ul>
								</div>
							</div>
							<div class = "row">
								<hr />
								<div class="col-md-12">
									<a href = "./handlers/cache_handler.php?artistid=<?=$artist_data["artistId"];?>">
										<strong>Are we missing something? Click here to automatically update the data.</strong>
									</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		
	</body>
</html>
