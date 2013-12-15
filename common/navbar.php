<div class="navbar navbar-default" role="navigation">
	<div class="container">
		<div class = "navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse">
				<span class="sr-only">Toggle Navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="index.php">Musika</a>
		</div>
		<div class="collapse navbar-collapse">
			<ul class="nav navbar-nav">
				<li><a href="library.php">My Music</a></li>
				<li><a href="add.php">Add New Music</a></li>
				<li><a href="playlist.php">Playlists</a></li>
				<li><a href="discover.php">Discover</a></li>
				<li><a href="search.php">Search</a></li>
			</ul>
			<ul class="nav navbar-nav navbar-default navbar-right">
				<?php
				if (!user_logged_in()) {
?>
				<li><a href="login.php">Login</a></li>
				<li><a href="register.php">Register</a></li>
<?php
				} else {
?>
				<li>
					<a href="#">
						<?php 
						echo $_SESSION["user.name"]; 
						?>
					</a>
				</li>
				<li>
					<a href="logout.php">
						Logout
					</a>
				</li>
<?php
				}
				?>
			</ul>
		</div>
	</div>
</div>
