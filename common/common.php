<?php
function load_bootstrap_css() {
echo '
<link rel="icon" type="image/png" href="favicon.png">
<link href="libs/bootstrap/css/bootstrap.min.css" rel="stylesheet">
<link href="libs/bootstrap/css/bootstrap-theme.css" rel="stylesheet">
<link href="css/musika-common.css" rel="stylesheet">
<script src="libs/bootstrap/js/bootstrap.min.js"></script>
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

?>
