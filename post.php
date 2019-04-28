<?php
	require_once("bootstrap.php");
	if (isset($_SESSION["path"])) {
		if (!empty($_POST)) {
			$upload = new UploadPost();
			$upload->setTitle($_POST["title"]);
			$upload->setDescription($_POST["description"]);
			$upload->setCountry($_POST["country"]);
			$upload->setStreetname($_POST["streetname"]);
			$upload->setHouseNumber($_POST["houseNumber"]);

			if($upload->checkPost()) {
				$upload->uploadToDatabase($_SESSION["path"]);
				unset($_SESSION["path"]);
			}
		}
	} else {
		header("Location: upload");
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