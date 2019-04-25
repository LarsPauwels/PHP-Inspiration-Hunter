<?php
	require_once("../bootstrap.php");

	if (!empty($_POST)) {
		$comment = new Comment();
		$comment->setMessage(htmlspecialchars($_POST["message"]));
		$comment->setPostId(htmlspecialchars($_POST["postId"]));
		$comment->setUserId(htmlspecialchars($_SESSION["user"]["id"]));

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