<?php
if (!isset($_GET["id"])) { header("Location: index.php"); die(); }

require_once "./common/common.php";
require_once "./workers/album_worker.php";

$album_worker = new AlbumWorker();
$album = $album_worker->getAlbum($_GET["id"]);
if (!$album) { header("Location: index.php"); die(); }
$contributors = $album_worker->getContributors($_GET["id"]);
if (!$contributors) { header("Location: index.php"); die(); }
$songs = $album_worker->getAlbumSongs($_GET["id"]);
$artist = $contributors[0];
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
		?>
		<div class = "container">
			<div class = "row">
				<div class="col-md-12">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h3><?php echo $album["name"]; ?></h3>
						</div>
						<div class="panel-body">
							<div class="row">
								<div class="col-md-6">
									<h4>By <a href="artist.php?id=<?=$artist["artistId"];?>"><?=$artist["name"];?></a></h4>
								</div>
								<div class="col-md-6">
									<p class="text-right">
										Add to Library
									</p>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<hr />
									<h4>Songs (<?=count($songs);?>)</h4>
									<ul class="list-group">
									<?php
									foreach ($songs as $song) {
									?>
										<li class="list-group-item">
											<a href="song.php?id=<?=$song["SID"];?>">
												<?=$song["title"];?>
											</a>
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
									<a href = "./handlers/cache_handler.php?artistid=<?=$artist["artistId"];?>">
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
