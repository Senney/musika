<?php
require_once "common/common.php"
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Musika - Music Library</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <?php
        load_bootstrap_css();
        ?>
        <link href="css/register.css" rel="stylesheet">
    </head>
    <body>
		<?php
		require_once "./common/navbar.php";
		?>
		<div class="container">
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-4 col-md-offset-4 well well-sm">
					<legend>Register for Musika</legend>
					<form action="handlers/register_handler.php" method="post" class="form" role="form">
						<input class="form-control" name="username" placeholder="Username" type="text" />
						<input class="form-control" name="email" placeholder="Email Address" type="email" />
						<input class="form-control" name="password" placeholder="Password" type="password" />
						<input class="form-control" name="passwordconfirm" placeholder="Re-Enter Your Password" type="password" />
						<button class="btn btn-lg btn-primary btn-block" type="Submit">Submit Registration</button>
					</form>
				</div>
			</div>
		</div>
	</body>
</html>
