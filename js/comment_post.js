$(document).ready(function() {
	$(".load-comments").each(function() {
		var postId = $(this).data("post");
		$(this).load("comments_post", {
			postId: postId
		});
	});

	$("section").keypress(function(e) {
		if (e.target.matches(".message")) {
			if (e.which == 13) {
				sendMessage($(e.target));
			}
		}
	});

	$("section").click(function(e) {
		if (e.target.matches(".fa-paper-plane")) {
			sendMessage($(e.target).siblings("input"));
		}
	});

	function sendMessage(input) {
		var message = input.val();
		var postId = input.data("post");
		var that = input;

		if (message != "" && postId != "") {
			$.ajax({
				method: "POST",
				url: "ajax/comment_post.php",
				data: {
					message: message,
					postId: postId
				},
				dataType: "json"
			}).done(function(res) {
				if (res.status == "success") {
					that.val("");
					that.parent().siblings(".load-comments").load("comments_post", {
						postId: postId
					});
				}
			});
		}
	}

});