<?php
	require_once("../bootstrap/bootstrap.php");

	if (!empty($_POST)) {
		$l = new Like();
		$l->setPostId($_POST["postId"]);
		$l->setUserId($_SESSION["user"]["id"]);

		if ($l->alreadyLiked($_SESSION["user"]["id"],$_POST["postId"])) {
			$l->saveLike();
			$result = [
				"status" => "success",
				"message" => "Like was saved"
			];	
		} else {
			$l->dislike();
			$result = [
				"status" => "fails",
				"message" => "Already liked"
			];
		}

		echo json_encode($result);
	}