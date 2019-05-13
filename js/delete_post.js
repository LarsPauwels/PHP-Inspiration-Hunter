$(document).ready(function() {

	$("section").on("click", function(e){
		if (e.target.matches(".delete")) {
			var postId = $(e.target).parent("a").data("post");

			$.ajax({
				method: "POST",
				url: "ajax/delete_post.php",
				data: {postId: postId},
				dataType: "json"
			}).done(function(res) {
				/*if (res.status == "success") {
					$(".posts-container").load("");
				}*/
			});

			e.preventDefault();
		}
	});

});