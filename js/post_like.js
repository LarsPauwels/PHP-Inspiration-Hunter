$(document).ready(function() {

	$("a.like").on("click", function(e){
		var postId = $(this).data("id");
		var that = $(this);

		$.ajax({
			method: "POST",
			url: "ajax/post_like.php",
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
	});

});