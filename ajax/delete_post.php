<?php
	require_once("../bootstrap/bootstrap.php");

	if (!empty($_POST)) {
		$post = new Post();
		$post->setPostId($_POST["message"]);

		if ($post->deletePost()) {
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