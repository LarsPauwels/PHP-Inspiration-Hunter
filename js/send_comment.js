$(document).ready(function() {
	$(".load-comments").each(function() {
		var postId = $(this).data("post");
		$(this).load("comments", {
			postId: postId
		});
	});

	$(".message").keypress(function (e) {
		if (e.which == 13) {
			var message = $(this).val();
			var postId = $(this).data("post");
			var that = $(this);

			$.ajax({
				method: "POST",
				url: "ajax/send_comment.php",
				data: {
					message: message,
					postId: postId
				},
				dataType: "json"
			}).done(function(res) {
				if (res.status == "success") {
					that.val("");
					that.siblings(".load-comments").load("comments", {
						postId: postId
					});
				}
			});
		}
	});

});