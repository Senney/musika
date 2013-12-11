
var song_seconds_between = 1;
var song_next_request = 0;

function searchSong(song, artist, album) {
    if (song.length >= 4) {
        $.ajax({
            url: "handlers/song_search_handler.php",
            type: "GET",
            data: {song_name: song, artist_name: artist, album_name: album}
        }).done(handleSongAjax);
    }
}

function handleSongAjax(data) {
    console.log(data);
    obj = $.parseJSON(data);
    $("#song-search-result").empty();
    if (obj.error != undefined) {
         $("#song-search-result").append("<li>Please wait a moment then search again.</li>");
         return;
    }
    var items = [];
    $.each(obj, function(i, data) {
        var element = "<li>" + data.title +' - '+data.album+' by '+data.artist+'</li>';
        items.push(element);
    });
    if (items.length == 0) {
		$("#song-search-result").append("<li>No results found.</li>");
	} else {
		$("#song-search-result").append(items.join(''));
	}
}

function keypress_song_search(event) {
	// Ensure that we don't run the function on non-character
	// keypresses.
	var song_input = $("#song-name");
	var artist_input = $("#artist-name");
	var album_input = $("#album-name");
	var c = String.fromCharCode(event.keyCode);
	if (!c.match(/[\w\d]/) && event.keyCode != 32 && event.keyCode != 8) {
		return;
	}

	clearTimeout(typingTimer);
	if (song_input.val) {
		typingTimer = setTimeout(function() {
			searchSong(song_input.val(), artist_input.val(), album_input.val());
		}, doneTypingInterval);
	}
}

var typingTimer;
var doneTypingInterval = 300;
$(function() {
	var song_input = $("#song-name");
	var artist_input = $("#artist-name");
	var album_input = $("#album-name");
    song_input.keyup(keypress_song_search);
	artist_input.keyup(keypress_song_search);
	album_input.keyup(keypress_song_search);
});
