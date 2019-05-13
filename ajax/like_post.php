<?php
	require_once("../bootstrap/bootstrap.php");

	if (!empty($_POST)) {
		$like = new Like();
		$like->setPostId($_POST["postId"]);
		$like->setUserId($_SESSION["user"]["id"]);

		if ($like->alreadyLiked($_SESSION["user"]["id"],$_POST["postId"])) {
			$like->like();
			$result = [
				"status" => "success",
				"message" => "Like was saved"
			];	
		} else {
			$like->dislike();
			$result = [
				"status" => "fails",
				"message" => "Already liked"
			];
		}

		echo json_encode($result);
	}