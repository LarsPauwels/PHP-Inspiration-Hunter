<?php
	require_once("../bootstrap/bootstrap.php");

	if (!empty($_POST)) {
		$comment = new Comment();
		$comment->setMessage($_POST["message"]);
		$comment->setPostId($_POST["postId"]);
		$comment->setUserId($_SESSION["user"]["id"]);

		if ($comment->save()) {
			$result = [
				"status" => "success",
				"message" => "Message successfully saved."
			];
		} else {
			$result = [
				"status" => "error",
				"message" => "Something went wrong."
			];
		}

		echo json_encode($result);
	}