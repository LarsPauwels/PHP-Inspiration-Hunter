<?php
	require_once("bootstrap.php");
	if (!empty($_POST)) {
		$post = new Post();
		$post->setTitle($_POST["title"]);
		$post->setDescription($_POST["description"]);
		$post->setCountry($_POST["country"]);
		$post->setStreetname($_POST["streetname"]);
		$post->setHouseNumber($_POST["houseNumber"]);

		if($post->checkPost()) {
			$post->uploadToDatabase($_SESSION["path"]);
		}
	}
?><!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>

	<?php if(!empty($_SESSION["errors"]["message"])) {
		require_once("error.php");
	}?>
	
	<form method="post" action>
		<input type="text" name="title">
		<textarea name="description"></textarea>
		<input type="text" name="country">
		<input type="text" name="streetname">
		<input type="text" name="houseNumber">
		<button name="send">Send Post</button>
	</form>
</body>
</html>