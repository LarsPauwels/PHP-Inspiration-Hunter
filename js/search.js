$(document).ready(function() {

	$(".search-btn").on("click", function(e){
		search;
		e.preventDefault();
	});

	$(".search-btn").keypress(function(e){
		if (e.which == 13) {
			search();
		}
	});

	function search(e) {
		var search = $(".search").val();

		$.ajax({
			method: "POST",
			url: "ajax/search.php",
			data: {search: search},
			dataType: "json"
		}).done(function(res) {
			if (res.status == "success") {
				$(".search").val("");
			}
		});
	}

});