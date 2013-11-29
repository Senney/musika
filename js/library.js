
$(function() {
	$(".btn-group-toggle").children("button").each(function(i) {
		var child_btn = $(this);
		var selected = child_btn.attr('selected');
		if (typeof selected != "undefined") {
			toggle_button(child_btn);
		}
		child_btn.click(function() {
			toggle_button($(this));
		});
	});
	
	load_music_table();
});

function load_music_table() {
	var data = '{ "head":["Song Title", "Artist"], "data":'+ 
		'[{"title":"Funkytown", "artist":"Lipps, Inc."}, {"title":"The Memory Remains", "artist":"Metallica"}, {"title":"Don\'t Stop Believing", "artist":"Journey"}] }';
	var parsed_data = $.parseJSON(data);
	for (header in parsed_data.head) {
		$("#music-display-table-head").append($("<th>").text(parsed_data.head[header]));
	}
	for (song in parsed_data.data) {
		var s = parsed_data.data[song];
		$("#music-display-table-body").append($("<tr>"));
		for (ele in s) {
			$("#music-display-table-body tr:last").append($("<td>").text(s[ele]));
		}
	}
}

function clear_button_toggles() {
	$(".btn-group-toggle").children("button").each(function(i) {
		var child = $(this);
		child.removeClass("active");
		child.removeAttr("selected");
	});
}

function toggle_button(elem) {	
	clear_button_toggles();
	elem.toggleClass("active");
	elem.attr("selected", 'true');
}

