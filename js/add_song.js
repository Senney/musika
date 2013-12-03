
$(function() {
	var song_input = $("#song-name");
	song_input.on('input', function() {
		var val = song_input.val();
		// Don't start pestering AJAX until 4 characters.
		if (val.length >= 4) {
			$.ajax({
				url: "handlers/song_search_handler.php",
				type: "GET",
				data: {song_name: val}
			}).done(function(msg) {
				console.log(msg);
			});
		}
	});
});
