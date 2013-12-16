<?php
require_once "./common/common.php";
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
							<h3><?php echo $song_data["title"]; ?></h3>
						</div>
						<div class="panel-body">
							<div class="row">
								<div class="col-md-6">
									<h4>By <a href="artist.php?id=<?=$artist_data["artistId"];?>"><?=$artist_data["name"];?></a></h4>
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
									<h4>Albums</h4>
									<ul class="list-group">
									<?php
									foreach ($album_data as $album) {
									?>
										<li class="list-group-item">
											<a href="album.php?id=<?=$album["albumId"];?>">
												<?=$album["name"];?>
											</a>
										</li>
									<?php
									}
									?>
									</ul>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>
