<?php
if (!isset($_GET["id"])) { header("Location: index.php"); die(); }

require_once "./common/common.php";
require_once "./workers/artist_worker.php";

$aid = $_GET["id"];
$artist_worker = new ArtistWorker();
$artist = $artist_worker->getArtist($aid);
if (!$artist) { header("Location: index.php"); die(); }
$albums = $artist_worker->getArtistAlbums($aid);
$songs = $artist_worker->getArtistSongs($aid);
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
							<h3><?php echo $artist["name"]; ?></h3>
						</div>
						<div class="panel-body">
							<div class="row">
								<div class="col-md-12">
									<?php
									if (empty($empty["description"])) {
										echo "No description available.";
									} else {
										echo $artist["description"];
									}
									?>
								</div>
							</div>
							<div class="row">
								<hr />
								<div class="col-md-12">
									<h4>Albums (<?=count($albums);?>)</h4>
									<ul class="list-group">
									<?php
									foreach ($albums as $album) {
									?>
										<li class="list-group-item">
											<a href="album.php?id=<?=$album["albumID"];?>">
												<?=$album["name"];?>
											</a>
										</li>
									<?php
									}
									?>	
									</ul>
								</div>
								<!--
								<div class="col-md-6">
									<h4>Songs</h4>
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
								-->
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>
