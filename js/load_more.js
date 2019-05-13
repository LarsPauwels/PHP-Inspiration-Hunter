$(document).ready(function() {
	var amount = 20;
	/*$(".load-more").on("click", function(e){
		amount += 1;
		$(".posts-container").load("ajax/load-more.php", {
			amount: amount
		});

		e.preventDefault();
	});*/


	$("section").on("click", function(e){
		if (e.target.matches(".load-more")) {
			amount += 20;
			
			$("#reload").load("index.php section", {
				amount: amount
			}, function() {
				$(".load-comments").each(function() {
					var postId = $(this).data("post");
					$(this).load("comments_post", {
						postId: postId
					});
				});
			});

			e.preventDefault();
		}
	});
});