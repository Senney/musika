<?php

?>

<!DOCTYPE html>
<html>
    <head>
        <title>Musika - Music Library</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="libs/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="libs/bootstrap/bootstrap-theme.css" rel="stylesheet">
    </head>
    <body>
        <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <div class="container">
                <div class = "navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="#">Musika</a>
                </div>
                <div class="collapse navbar-collapse">
                    <ul class="nav navbar-nav">
                        <li class="active"><a href="#">Home</a></li>
                        <li><a href="#">Library</a></li>
                        <li><a href="#">Search</a></li>
                    </ul>
                </div>
            </div>
        </div>
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

