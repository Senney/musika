
function setup_raters(php_path, disabled) {
	$(".song-rating").jRating({
		rateMax: 5,
		step: true,
		bigStarsPath: "libs/jrating/jquery/icons/stars.png",
		phpPath: php_path,
		isDisabled: disabled
	});
}

function setup_raters_class(class_name, php_path, disabled) {
	$(class_name).jRating({
		rateMax: 5,
		step: true,
		bigStarsPath: "libs/jrating/jquery/icons/stars.png",
		phpPath: php_path,
		isDisabled: disabled
	});
}
