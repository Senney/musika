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
						<h3>Add a Song to your Library</h3>
						<h5>Type all or part of song details into the fields below, and view the search results below.</h5>
						<form class="form form-add-song" role="form" method="POST" action="handlers/add_song_handler.php" />
							<div class="row">
								<div class="col-xs-9 col-md-9">
									<div class="input-group">
										<span class="input-group-addon"><span class="glyphicon glyphicon-music"></span></span>
										<input type="text" id="song-name" name="song-name" class="form-control" placeholder="Song Title" required autofocus />
									</div>
								</div>
							</div>
							<div class="row row-pad-top">
								<div class="col-xs-3 col-md-3">
									<div class="input-group">
										<span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
										<input type="text" id="artist-name" name="artist-name" class="form-control" placeholder="Artist Name" />
									</div>
								</div>
								<div class="col-xs-3 col-md-3">
									<div class="input-group">
										<span class="input-group-addon"><span class="glyphicon glyphicon-headphones"></span></span>
										<input type="text" id="album-name" name="album-name" class="form-control" placeholder="Album Name" />
									</div>
								</div>
								<div class="col-xs-3 col-md-3">
									<div class="input-group">
										<span class="input-group-addon"><span class="glyphicon glyphicon-floppy-disk"></span></span>				
										<select class="form-control" name="media-type">
											<option value="1">Digital</option>
											<option value="2">CD</option>
											<option value="3">Record</option>
										</select>	
									</div>			
								</div>	
								<div class="col-xs-3 col-md-3">
									<button class="btn btn-success btn-block" type="submit">Add Song</button>
								</div>					
							</div>
						</form>
					</div>
					<div class="panel-body">
						<h4>Search Results:</h4>
						<ul class="search-result" id="song-search-result">
							<li>No Results Yet!</li>
						</ul>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="panel panel-default">
					<div class="panel-body">
						<h3>Add an Album to your Library</h3>
						<h5>Click a result from the auto-populated search results to fill in the form.</h5>
						<form class="form form-add-song" role="form" method="handlers/add_song_handler.php" />
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
					<div class="panel-body">
						<h4>Search Results:</h4>
						<ul>
							<li>Album Result 1</li>
							<li>Album Result 2</li>
						</ul>
					</div>
				</div>				
			</div>
		</div>
	</body>
</html>
