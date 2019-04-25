$(document).ready(function() {
	var amount = 20;
	$(".load-more").on("click", function(e){
		amount += 10;
		$(".posts-container").load("load-more.php", {
			amount: amount
		});

		e.preventDefault();
	});

});