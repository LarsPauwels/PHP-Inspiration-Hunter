$(document).ready(function() {

	var dropdown = true;

	$(".bell-open").click(function() {
		$(".extra").removeClass("active");
		$(this).addClass("active");
		$(".pop-up-container").addClass("open");
		$(".pop-up").load("notifications");
	});

	$(".upload-open").click(function() {
		$(".extra").removeClass("active");
		$(this).addClass("active");
		$(".pop-up-container").addClass("open");
		$(".pop-up").load("choose");
	});

	$(".followers-open").click(function() {
		$(".extra").removeClass("active");
		$(this).addClass("active");
		$(".pop-up-container").addClass("open");
		$(".pop-up").load("followers");
	});

	$("section").click(function() {
		$(".pop-up-container").removeClass("open");
	});

	$(".pop-up").load("notifications");

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