$(document).ready(function() {

	$("section").on("click", function(e){
		if (e.target.matches(".like")) {
			var postId = $(e.target).parent("a").data("id");
			var that = $(e.target).parent("a");

			$.ajax({
				method: "POST",
				url: "ajax/like_post.php",
				data: {postId: postId},
				dataType: "json"
			}).done(function(res) {
				if (res.status == "success") {
					var likes = that.next().text();
					likes++;
					that.next().text(likes);
					that.find("i").css("color", "#2b8ced");
				} else if (res.status == "fails") {
					var likes = that.next().text();
					likes--;
					that.next().text(likes);
					that.find("i").css("color", "#fff");
				}
			});

			e.preventDefault();
		}
	});

});