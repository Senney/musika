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
		<link href="css/library.css" rel="stylesheet">
		
		<!-- Bootstrap paginator -->
		<script src="libs/bootstrap-paginator/bootstrap-paginator.min.js"></script>
        <script src="js/library.js"></script>
    </head>
    <body>
		<?php
		require_once "./common/navbar.php";
		?>
		<div class="container">
			<div class="row">
				<div class="panel panel-default">
					<div class="panel-body">
						<h2>My Music</h2>
						<div class = "row">
							<div class="col-md-3">
								<div class="input-group">
									<strong>Sort: </strong>
									<div class="btn-group btn-group-toggle">
										<button type="button" class="btn btn-default" value="song" selected>Song</button>
										<button type="button" class="btn btn-default" value="album">Album</button>
										<button type="button" class="btn btn-default" value="artist">Artist</button>
									</div>
								</div>
							</div>
							<div class="col-md-4">
								<form class="form-search">
									<div class="input-group">
										<span class="input-group-addon"><span class="glyphicon glyphicon-search"></span></span>
										<input type="text" id="library-search" name="library-search" class="form-control" placeholder="Search Parameter" />
									</div>
								</form>
							</div>
							<div class = "col-md-5">
								<div class="pull-right">
									<ul class="pagination" id="library-paginator">

									</ul>
								</div>
							</div>
						</div>
						<div id="error">
						
						</div>
						<table class="table table-hover">
							<thead id="music-display-table-head">
								
							</thead>
							<tbody id="music-display-table-body">
							
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>
