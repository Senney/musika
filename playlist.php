<?php
require_once "./common/common.php";
require_once "./workers/playlist_worker.php";

logged_in_redirect();

$plw = new PlaylistWorker();
$playlists = $plw->getPlaylists(usrid());

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
		<div class="container">
			<div class="row">
				<div class="panel panel-default">
					<div class="panel-body">
						<h3>Create a New Playlist</h3>
						<h5>Create a new playlist to organize and view your favorite songs!</h5>
						<form class="form form-add-song" role="form" method="GET" action="handlers/add_playlist_handler.php" />
							<input type="hidden" value="1" name="type" />
							<div class="row">
								<div class="col-xs-8 col-md-8">
									<div class="input-group">
										<span class="input-group-addon"><span class="glyphicon glyphicon-music"></span></span>
										<input type="text" id="playlist-name" name="playlist-name" class="form-control" placeholder="Playlist Name" autofocus />
									</div>
								</div>
								<div class="col-md-4">
									<button class="btn btn-success" type="submit">Create Playlist</button>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="panel panel-default">
					<div class="panel-body">
						<h3>My Playlists</h3>
						<ul class="list-group">
						<?php
						if ($playlists) {
							foreach ($playlists as $pl) {
							?>
							<li class="list-group-item">
								<div class="row">
									<div class="col-md-8">
										<a href="view_playlist.php?id=<?=$pl["pId"];?>">
											<?=$pl["name"];?>
										</a>
									</div>
									<div class="col-md-4">
										<span class="pull-right">Rating Here</span>
									</div>
								</div>
							</li>
							<?php
							}
						} else {
						?>
							<li class="list-group-item">
								You haven't created any playlists yet!
							</li>
						<?php
						}
						?>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>
