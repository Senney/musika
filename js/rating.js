
function setup_raters(php_path, disabled) {
	$(".song-rating").jRating({
		rateMax: 5,
		step: true,
		bigStarsPath: "libs/jrating/jquery/icons/stars.png",
		phpPath: php_path,
		isDisabled: disabled
	});
}

