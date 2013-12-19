<?php

require_once "./common/common.php";
require_once "./workers/user_worker.php";
require_once "./workers/playlist_worker.php";
require_once "./workers/friend_worker.php";

$userid = isset($_GET["id"]) ? $_GET["id"] : usrid();
$user_worker = new UserWorker();
$user = $user_worker->getById($userid);
if (!$user) { header("Location: index.php"); die(); }

$friend_worker = new FriendWorker();
$friends = $friend_worker->getUserFriend($user["UserId"]);

$mypage = $user["UserId"] == usrid();
$isfriend = $friend_worker->isFriend(usrid(), $user["UserId"]);

$plw = new PlaylistWorker();
$playlists = $plw->getPlaylists($userid);
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Musika - Music Library</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <?php
        load_bootstrap_css();
        ?>
		<style>
			.btn-pad-top {
				margin-top: 15px;
			}
		</style>
		<script src="libs/typeahead.js/typeahead.min.js"></script>
		<script src="js/rating.js"></script>
		<script>
			$(function() {
				setup_raters("handlers/playlist_rating_handler.php", false);
				
				$("#user-name-search .typeahead").typeahead({
					name: 'user-search',
					prefetch: 'handlers/user_search_handler.php",
					limit: 10
				});
			});
		</script>		
    </head>
    <body>
		<?php
		require_once "./common/navbar.php";
		?>
		<div class = "container">
			<div class = "row">
				<div class = "col-md-12">
					<div class = "panel panel-default">
						<div class = "panel-heading">
							<div class="row">
								<div class="col-md-6">
									<h3><?=$user["username"];?></h3>
								</div>
								<div class="col-md-6 pull-right">
								<?php
								if (!$mypage && $isfriend) {
								?>
									<a class="btn btn-danger btn-pad-top pull-right" href="handlers/friend_handler.php?type=2&userid=<?=$user["UserId"];?>" type="submit">
										Remove Friend
									</a>
								<?php
								} else if (!$mypage && !$isfriend) {
								?>
								
									<a class="btn btn-success btn-pad-top pull-right" href="handlers/friend_handler.php?type=1&userid=<?=$user["UserId"];?>" type="submit">
										Add Friend
									</a>	
								<?php								
								}
								?>
								</div>
							</div>
						</div>
						<div class = "panel-body">
							<div class = "row"> 
								<div class = "col-md-12">
									<h4>User Biography</h4>
									<p>
									<?php
									if (!empty($user["bio"]) && !$mypage) {
										echo $user["bio"];
									} else if (!$mypage) {
										echo "The user has not set a bio.";
									} else {
									?>
										<form action="handlers/user_handler.php" method="POST">
											<input type="hidden" name="type" value="bio" />
											<textarea placeholder="Input your biography here!" name="bio" class="form-control" style="resize:none;"><?php if (!empty($user["bio"])) echo $user["bio"];?></textarea>
									<?php
										if (isset($_GET["error"]) && $_GET["error"] == 1) {
									?>
											<button class="btn btn-info form-control" type="submit">Your Bio Was Updated</button>
									<?php
										} else {
									?>
											<button class="btn btn-success form-control" type="submit">Update Your Bio</button>
									<?php
										}
									?>
										</form>
									<?php
									}
									?>
									</p>
								</div>
							</div>
							<div class = "row">
								<div class = "col-md-6">
									<h4>Friends</h4>
									<ul class="list-group">
									<?php
									if ($friends) {
										foreach ($friends as $f) {
									?>
										<li class="list-group-item">
											<a href="user.php?id=<?=$f["UserId"];?>">
												<?=$f["username"];?>
											</a>
										</li>
									<?php
										}
									} else {
									?>
										<li class="list-group-item">
											The user hasn't added anyone as a friend. 
										</li>
									<?php
									}
									?>
										<li class="list-group-item">
											<div class="input-group">
												<span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
												<input type="text" id="user-name-search" name="user-name" class="form-control typeahead" placeholder="Search for new friends" />
												<span class="input-group-btn">
													<button class="btn btn-default" type="submit">Add As Friend</button>
												</span>
											</div>
										</li>
									</ul>
								</div>
								<div class = "col-md-6">
									<h4>Playlists</h4>
									<ul class="list-group">
										<?php
										if($playlists){
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
													<span class="pull-right">
														<div class="song-rating" data-average="<?=$plw->getAverageRating($pl["pId"]);?>" data-id="<?=$pl["pId"];?>"></div>
													</span>
												</div>
											</div>
										</li>
										<?php
										}
									} else {
									?>
										<li class="list-group-item">
											User has no playlists
										</li>
									<?php
									}
									?>										
									</ul>
								</div>
							</div>
						</div>
					<div>
				</div>
			</div>
		</div>
	</body>
</html>
