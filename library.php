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
						<div class="input-group">
							<strong>View: </strong>
							<div class="btn-group btn-group-toggle">
								<button type="button" class="btn btn-default" selected>Song</button>
								<button type="button" class="btn btn-default">Album</button>
								<button type="button" class="btn btn-default">Artist</button>
							</div>
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
