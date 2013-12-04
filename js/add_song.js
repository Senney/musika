
var song_seconds_between = 1;
var song_next_request = 0;
$(function() {
	var song_input = $("#song-name");
	song_input.on('input', function() {
		var val = song_input.val();
		// Don't start pestering AJAX until 4 characters.
		var curtime = (new Date().getTime()) / 1000;
		if (val.length >= 4 && curtime > song_next_request) {
			song_next_request = (new Date().getTime() / 1000) + song_seconds_between;
			$.ajax({
				url: "handlers/song_search_handler.php",
				type: "GET",
				data: {song_name: val}
			}).done(function(msg) {
				$.each(msg, function(i, data) {
					console.log(data);
				});
			});
		}
	});
});
