$(document).ready(function() {

	$(".search-btn").on("click", function(e){
		search();
		e.preventDefault();
	});

	$(".search").keypress(function(e){
		if (e.which == 13) {
			search();
		}
	});

});