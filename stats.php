<?php
require_once "./common/common.php";
require_once "./workers/stats_worker.php";
require_once "./workers/song_worker.php";

$sw = new StatsWorker();
$songw = new SongWorker();
$pop = $sw->mostPopularSongs();
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
			<div class="row">
				<div class="col-md-6">
					<table class="table table-hover">
						<thead>
							<th style="width:25%;">Statistic</th>
							<th>Value</th>
						</thead>
						<tbody>
							<tr>
								<td><strong>Total Songs</strong></td>
								<td><?=number_format($sw->totalNumberSongs());?></td>
							</tr>
							<tr>
								<td><strong>Total Artists</strong></td>
								<td><?=number_format($sw->totalNumberArtists());?></td>
							</tr>
							<tr>
								<td><strong>Total Albums</strong></td>
								<td><?=number_format($sw->totalNumberAlbums());?></td>
							</tr>
						</tbody>
					</table>
				</div>
				<div class="col-md-6">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h4>Popular Songs</h4>
						</div>
						<div class="panel-body">
							<ul class="list-group">
							<?php
							foreach ($pop as $s) {
								$song = $songw->getSong($s["SID"]);
							?>
								<li class="list-group-item">
									<a href="song.php?id=<?=$song["SID"];?>"><?=$song["title"];?></a>
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
	</body>
</html>
