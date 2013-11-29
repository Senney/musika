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
		<div class="container">
			<div class="row">
				<div class="panel panel-default">
					<div class="panel-body">
						<h3>Add a Song to your Library</h3>
						<form class="form form-add-song" role="form" method="handlers/add_song_handler.php" />
							<div class="row">
								<div class="col-xs-3 col-md-3">
									<div class="input-group">
										<span class="input-group-addon"><span class="glyphicon glyphicon-music"></span></span>
										<input type="text" name="song-name" class="form-control" placeholder="Song Title" required autofocus />
									</div>
								</div>
								<div class="col-xs-3 col-md-3">
									<div class="input-group">
										<span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
										<input type="text" name="artist-name" class="form-control" placeholder="Artist Name" />
									</div>
								</div>
								<div class="col-xs-3 col-md-3">
									<div class="input-group">
										<span class="input-group-addon"><span class="glyphicon glyphicon-headphones"></span></span>
										<input type="text" name="album-name" class="form-control" placeholder="Album Name" />
									</div>
								</div>
								<div class="col-xs-3 col-md-3">
									<button class="btn btn-primary btn-block" type="submit">Add Song</button>
								</div>
							</div>
							<div class="form-group">							
							</div>
						</form>
					</div>
					<div class="panel-body">
						<h4>Search Results:</h4>
						<ul>
							<li>Song Result 1</li>
							<li>Song Result 2</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>
