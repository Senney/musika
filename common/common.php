<?php
function load_bootstrap_css() {
echo '
<link rel="icon" type="image/png" href="favicon.png">
<link href="libs/bootstrap/css/bootstrap.min.css" rel="stylesheet">
<link href="libs/bootstrap/css/bootstrap-theme.css" rel="stylesheet">
<link href="css/musika-common.css" rel="stylesheet">
<script src="libs/jquery.min.js"></script>
<script src="libs/bootstrap/js/bootstrap.min.js"></script>
<link rel="stylesheet" type="text/css" href="libs/jrating/jquery/jRating.jquery.css" media="screen" />
<!-- jQuery files -->
<script type="text/javascript" src="libs/jrating/jquery/jRating.jquery.js"></script>
';
}

define("IMAGE_CACHE_FOLDER", dirname(__FILE__) . "/../cached_images/");
function cache_image($image_name, $image_url) {
	$target_loc = IMAGE_CACHE_FOLDER . $image_name;
	// Create the image folder if it doesn't exist.
	if (!file_exists(IMAGE_CACHE_FOLDER)) mkdir(IMAGE_CACHE_FOLDER);  
	if (file_exists($target_loc)) return;
	
	$contents = file_get_contents($image_url);
	$ret = file_put_contents($target_loc, $contents);
	return $target_loc;
}

function safe_session_start() {
	if (!isset($_SESSION)) {
		session_start();
	}
}

function keys_exist($array, $elements) {
	foreach ($elements as $e) {
		if (!isset($array[$e])) {
			return false;
		}
	}
	
	return true;
}

function usrid() {
	if (!user_logged_in()) return -1;
	return $_SESSION["user.id"];
}

function user_logged_in() {
	if (!isset($_SESSION)) {
		session_start();
	}
	
	if (!isset($_SESSION["user.id"])) {
		return false;
	}
	
	return true;
}

function logged_in_redirect() {
	if (!user_logged_in()) {
		header("Location: /musika/login.php?error=-4");
		die();
	}
}

function fmt_milliseconds($ms) {
	if ($ms <= 0) {
		return "-";
	}

	$seconds = ceil($ms / 1000);
	$minutes = floor($seconds / 60);
	$seconds = $seconds - ($minutes * 60);
	if ($seconds < 10) {
		$seconds = "0" . $seconds;
	}
	
	return $minutes . ":" . $seconds;
}

function redirect_back() {
	if (!isset($_SERVER["HTTP_REFERER"])) {
		header("Location: /musika/index.php");
	} else {
		header("Location: " . $_SERVER["HTTP_REFERER"]);
	}
	die();
}

// Start the session for all pages that include common.
safe_session_start();

?>
