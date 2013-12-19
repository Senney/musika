<?php
if (!isset($_GET["id"])) { header("Location: index.php"); die(); }

require_once "./common/common.php";
require_once "./workers/artist_worker.php";
require_once "./workers/ownership_worker.php";

$aid = $_GET["id"];
$artist_worker = new ArtistWorker();
$artist = $artist_worker->getArtist($aid);
if (!$artist) { header("Location: index.php"); die(); }
$albums = $artist_worker->getArtistAlbums($aid);
$songs = $artist_worker->getArtistSongs($aid);
$owner = new OwnershipWorker(usrid());
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
							<hr />					
							<div class="row">
								<div class="col-md-3">
									<h4>Artist Information</h4>
									<table class="table table-bordered table-condensed">
										<thead>
											<th>Attribute</th>
											<th>Value</th>											
										</thead>
										<tbody>
											<tr>
												<td>Genre</td>
												<td><?=$owner->getGenre($artist["genre"]);?></td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<h4>Albums (<?=count($albums);?>)</h4>
									<ul class="list-group">
									<?php
									foreach ($albums as $album) {
									?>
										<li class="list-group-item">
										<div class="row">
											<div class="col-md-8">
												<a href="album.php?id=<?=$album["albumID"];?>">
													<?=$album["name"];?>
												</a>
											</div>
											<div class="col-md-4">
												<?php
												$url = "handlers/album_handler.php?albumid=".$album["albumID"];
												if ($owner->ownsAlbum($album["albumID"])) {
												?>
													<a href="<?=$url;?>" class="btn badge badge-danger pull-right">
														Remove From Library
													</a>
												<?php
												} else {
												?>
													<a href="<?=$url;?>" class="btn badge badge-success pull-right">
														Add To Library
													</a>
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
									<a href = "./handlers/cache_handler.php?artistid=<?=$_GET["id"];?>">
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
