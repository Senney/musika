<?php
function load_bootstrap_css() {
echo '
<link href="libs/bootstrap/css/bootstrap.min.css" rel="stylesheet">
<link href="libs/bootstrap/css/bootstrap-theme.css" rel="stylesheet">';
}

define("IMAGE_CACHE_FOLDER", "./cached_images/");
function cache_image($image_name, $image_url) {
	$contents = file_get_contents($image_url);
	$ret = file_put_contents(IMAGE_CACHE_FOLDER . $image_name);
	return IMAGE_CACHE_FOLDER . $image_name;
}

?>
