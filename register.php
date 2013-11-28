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
						<div class="row">
							<div class="col-xs-6 col-md-6">
								<input class="form-control" name="firstname" placeholder="First Name" type="text" required autofocus />
							</div>
							<div class="col-xs-6 col-md-6">
								<input class="form-control" name="lastname" placeholder="Last Name" type="text" required />
							</div>
						</div>
						<input class="form-control" name="email" placeholder="Email Address" type="email" />
						<input class="form-control" name="emailconfirm" placeholder="Re-Enter Your Email" type="email" />
						<input class="form-control" name="password" placeholder="Password" type="password" />
					</form>
				</div>
			</div>
		</div>
	</body>
</html>
