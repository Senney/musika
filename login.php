<?php
require_once "common/common.php";

$error = null;
$errmsg = array(
	1 => "Registration successful. Please log in.",
	-1 => "Login failed. Invalid username.",
	-2 => "Login failed. Invalid password.",
	-3 => "A required form parameter was not set.",
	-4 => "You are required to log in to use this page."
);
if (isset($_GET["error"])) {
	$error = $_GET["error"];
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
		?>
        <div class="container">
			<h3 class="text-center">Musika requires you to login before you can manage your music!</h3>
			<div class="row">
				<div class="col-md-4 col-md-offset-4">
					<div class="panel panel-default">
						<div class="panel-body">
							<h3 class="text-center">Login</h3>
							<form class="form form-login" role="form" action="handlers/login_handler.php" method="POST">
								<div class="form-group">
									<div class="input-group">
										<span class = "input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
										<input type="text" class="form-control" placeholder="Username" name="username" />
									</div>
								</div>
								<div class="form-group">
									<div class="input-group">
										<span class = "input-group-addon"><span class="glyphicon glyphicon-asterisk"></span></span>
										<input type="password" class="form-control" placeholder="Password" name="password" />
									</div>
								</div>
								<button type="submit" class="btn btn-primary btn-block">
									<i class="glyphicon glyphicon-share-alt"></i> Sign In
								</button>
							</form>
							<br />
<?php
						if (isset($error)) {
							if ($error < 0) $class = "alert-danger";
							else $class = "alert-info";
?>							
							<div class="alert <?php echo $class; ?>">
								<?php echo $errmsg[$error]; ?>
							</div>
<?php
						}
?>
						</div>
					</div>
				</div>
			</div>
			<h4 class="text-center">Don't have an account? <a href="register.php">Register</a></h4>
        </div>
	</body>
</html>
