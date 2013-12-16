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
			<div class="panel panel-default">
				<div class="panel-body">
					<h2>My Playlist</h2>
					<table class="table table-hover">
					
					</table>
				</div>
			</div>
		</div>
	</body>
</html>
