$(document).ready(function() {

	var dropdown = true;

	$(".followers-open").click(function() {
		$(".extra").removeClass("active");
		$(this).addClass("active");
		$(".pop-up-container").addClass("open");
		$(".pop-up").load("followers");
	});

	$("section").click(function() {
		$(".pop-up-container").removeClass("open");
	});

	$(".pop-up").load("followers");

	$("#menu li").click(function() {
		$("#menu li").removeClass("active");
		$(this).addClass("active");
	});

	$("header .user-container").click(function() {
		if (dropdown) {
			$(".dropdown").addClass("open");
			dropdown = false;
		} else {
			$(".dropdown").removeClass("open");
			dropdown = true;
		}
	});

});