<?php
	require_once("../bootstrap.php");

	if (!empty($_POST)) {
		require_once("../search-posts.php");

		$result = [
			"status" => "success",
			"message" => "Like was saved"
		];

		echo json_encode($result);
	}