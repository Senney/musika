
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
	
	load_music_table_ajax(0);
	reset_paginator(1);
	setup_search();
});

function setup_search() {
	$("#library-search").keyup(keypress_filter);
}

var typingTimer;
var doneTypingInterval = 300;
var currentRequest;
function keypress_filter(event) {
	var search = $("#library-search");
	// Filter out non-ascii and non-backspace and non-space keypresses.
	var c = String.fromCharCode(event.keyCode);
	if (!c.match(/[\w\d]/) && event.keyCode != 32 && event.keyCode != 8) {
		return;
	}
	
	clearTimeout(typingTimer);
	if (currentRequest) {
		// Abort the previous ajax request if one existed.
		currentRequest.abort();
		currentRequest = null;
	}
	typingTimer = setTimeout(function() {
		load_music_table_ajax(0);
		reset_paginator(1);
	}, doneTypingInterval);
}

function reset_paginator(page) {
	$.ajax({
		url:"handlers/library_handler.php",
		data:{type:"count", filter:$("#library-search").val()}
	}).success(function(data) {
		var options = {
			currentPage: page,
			totalPages: Math.ceil(data/15),
			bootstrapMajorVersion: 3,
			onPageClicked: function(e, originalEvent, type, page) {
				load_music_table_ajax(page-1);
			}
		}
	
		$("#library-paginator").bootstrapPaginator(options);
	});
}

function load_music_table_ajax(page) {
	if (page < 0) return false;
	$.ajax({
		url: "handlers/library_handler.php",
		type: "GET",
		data: {type:"song", limit:15, page:page, filter:$("#library-search").val()}
	}).done(function(data) {
		var parsed_data = $.parseJSON(data);
		$("#music-display-table-head").empty();
		$("#music-display-table-body").empty();
		
		
		if (parsed_data.data.length == 0) {
			$("#error").text("You have not added any songs. Add some music now!").addClass("alert alert-danger");
			
			return 0;
		} else {
			$("#error").empty().removeClass("alert").removeClass("alert-danger");
		}
		
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
	});
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

