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
        <div class="jumbotron">
			<div class="container">
				<h1>Musika</h1>
				<p>Musika is an open platform for music management
				across multiple users. It was developed for CPSC471 at
				the University of Calgary.</p>
				<p>
					<a class="btn btn-primary btn-lg" role="button" href="register.php">Register</a>
					<a class="btn btn-success btn-lg" role="button" href="login.php">Login</a>
				</p>
			</div>
        </div>
    </body>
</html>

