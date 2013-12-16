<?php
require_once "./common/common.php";
require_once "./workers/song_worker.php";
require_once "./workers/artist_worker.php";

$worker = new SongWorker();
$artist = new ArtistWorker();

if (!isset($_GET["id"])) {
	$errmsg = "A song ID is required to view a song.";
}
else {
	$song_data = $worker->getSong($_GET["id"])[0];
	$artist_data = $artist->getArtist($song_data["AID"]);
	print_r($song_data);
	print_r($artist_data);
}

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
		
		// Handle missing ID.
		if (isset($errmsg)) {
		?>
			<div class="alert alert-danger">
			<?php echo $errmsg; ?>
			</div>
		<?php
			die();
		}
		?>
		
		<div class = "container">
			<div class = "row">
				<div class="col-md-12">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h3><?php echo $song_data["title"]; ?></h3>
						</div>
						<div class="panel-body">
							
						</div>
					</div>
				</div>
			</div>
		</div>
		
	</body>
</html>
