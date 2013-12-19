<?php
require_once "./common/common.php";

logged_in_redirect();
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Musika - Music Library</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <?php
        load_bootstrap_css();
        ?>
        <script src="js/add_song.js"></script>
    </head>
    <body>
		<?php
		require_once "./common/navbar.php";
		?>
		<div class="container">
			<div class="row">
				<div class="panel panel-default">
					<div class="panel-body">
						<h3>Add From Our Database</h3>
						<h5>Musika maintains a database of over 900,000 songs! Enter your search parameter into one or more of the fields below
						to start populating your library.</h5>
						<form class="form form-add-song" role="form" method="GET" action="search.php" />
							<div class="row">
								<div class="col-xs-12 col-md-12">
									<div class="input-group">
										<span class="input-group-addon"><span class="glyphicon glyphicon-music"></span></span>
										<input type="text" id="song-name" name="song-name" class="form-control" placeholder="Song Title" autofocus />
									</div>
								</div>
							</div>
							<div class="row row-pad-top">
								<div class="col-xs-4 col-md-4">
									<div class="input-group">
										<span class="input-group-addon"><span class="glyphicon glyphicon-headphones"></span></span>
										<input type="text" id="album-name" name="album-name" class="form-control" placeholder="Album Name" />
									</div>
								</div>
								<div class="col-xs-4 col-md-4">
									<div class="input-group">
										<span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
										<input type="text" id="artist-name" name="artist-name" class="form-control" placeholder="Artist Name" />
									</div>
								</div>
								<div class="col-xs-4 col-md-4">
									<button class="btn btn-success btn-block" type="submit">Search Database</button>
								</div>					
							</div>
						</form>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="panel panel-default">
					<div class="panel-body">
						<h3>Add Your Own Music</h3>
						<h5>Obscure artist? Your own personal music? Add it below.</h5>
						<form class="form form-add-song" role="form" method="POST" action="handlers/album_handler.php" />
							<div class="row">
								<div class="col-xs-9 col-md-9">
									<div class="input-group">
										<span class="input-group-addon"><span class="glyphicon glyphicon-headphones"></span></span>
										<input type="text" name="album-name" class="form-control" placeholder="Album Name" required autofocus />
									</div>
								</div>
							</div>
							<div class="row row-pad-top">
								<div class="col-xs-3 col-md-3">
									<div class="input-group">
										<span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
										<input type="text" name="artist-name" class="form-control" placeholder="Artist Name" />
									</div>
								</div>
								<div class="col-xs-3 col-md-3">
								</div>
								<div class="col-xs-3 col-md-3">
									<div class="input-group">
										<span class="input-group-addon"><span class="glyphicon glyphicon-floppy-disk"></span></span>				
										<select class="form-control" name="media-type">
											<option value="digital">Digital</option>
											<option value="cd">CD</option>
											<option value="record">Record</option>
										</select>	
									</div>			
								</div>	
								<div class="col-xs-3 col-md-3">
									<button class="btn btn-success btn-block" type="submit">Add Album</button>
								</div>					
							</div>
						</form>
					</div>
				</div>				
			</div>
			<div class="row">
				<div class="panel panel-default">
					<div class="panel-body">
						<h3>Are We Missing Something?</h3>
						<h5>Enter the name of an artist and we'll go pull in some more data for you. We interact with iTunes to ensure that
						our database is always up to date with the newest data.</h5>
						<form class="form form-cache-artist" role="form" method="GET" action="handlers/cache_handler.php" />
							<div class="row">
								<div class="col-xs-9 col-md-9">
									<div class="input-group">
										<span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
										<input type="text" name="artist-name" class="form-control" placeholder="Artist Name" />
									</div>
								</div>
								<div class="col-xs-3 col-md-3">
									<button class="btn btn-success btn-block" type="submit">Load Data</button>
								</div>					
							</div>
						</form>
						<?php
						if (isset($_GET["import"])) {
						?>
						<br />
						<div class="alert alert-info">
							Thank you! We imported <?=$_GET["import"]?> songs!
						</div>
						<?php
						}
						?>
					</div>
				</div>				
			</div>
		</div>
	</body>
</html>
