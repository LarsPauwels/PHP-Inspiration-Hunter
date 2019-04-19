$(document).ready(function() {

	$(".upload").mouseenter(function() {
		$(".middle-content p").text("Click to choose a file");
		$(".middle-content small").fadeOut(300);
	});

	$(".upload").mouseleave(function() {
		$(".middle-content p").text("Drag and drop to upload");
		$(".middle-content small").fadeIn(300);
	});

	$('.bottom-content').mouseenter(function(e) {
		$(".middle-content p").text("Drag and drop to upload");
		$(".middle-content small").fadeIn(300);
		e.stopPropagation();
	});

	$("#image-input").change(function() {
		$(".bottom-content").fadeIn(750);
	});

});