<?php
require_once("bootstrap/bootstrap.php");

if (isset($_SESSION["path"])) {
	if (isset($_POST["send"])) {
		$location = new Location();
		$location->setCountry($_POST["country"]);
		$location->setPostcode($_POST["postcode"]);
		$location->setStreetname($_POST["streetname"]);
		$location->setTown($_POST["town"]);
		$location->setLat($_POST["lat"]);
		$location->setLng($_POST["lng"]);

		$post = new Post();
		$post->setDescription($_POST["description"]);
		$post->setPath($_SESSION["path"]);
		$post->setFilter($_POST["filter"]);

		if($location->setLocation()) {
			if($post->createPost($_POST["lat"], $_POST["lng"])) {
				header("Location: index");
				unset($_SESSION["path"]);
			}
		}
	}

	if (isset($_POST["cancel"])) {
		$file = new File;
		$file->setPath($_SESSION["path"]);
		if ($file->deleteFile()) {
			header("Location: index");
		}
	}
} else {
	header("Location: upload");
}
?><!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title></title>
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
	<link href="https://fonts.googleapis.com/css?family=Raleway:400,500,600,700" rel="stylesheet">
	<link rel="stylesheet" href="https://cssgram-cssgram.netdna-ssl.com/cssgram.min.css">
	<link rel="stylesheet" type="text/css" href="css/post.css">
</head>
<body>

	<?php if(!empty($_SESSION["errors"]["message"])) {
		require_once("error.php");
	}?>

	<header>
		<a href="index">
			<img src="images/full_logo.png" class="logo">
		</a>
	</header>
	<section>
		<article class="title">
			<h1>
				Add details
			</h1>
			<p>
				Tell us about your adventure and how you experienced this place.
			</p>
		</article>
		<article class="container">
			<div class="container-inner">
				<div class="post-image">
					<div class="frame">
						<div id="filter-image">
							<img src="<?php if(isset($_SESSION['path'])){ echo $_SESSION['path']; } ?>">
						</div>
					</div>
				</div>
				<div class="scroll">
					<div class="filters">
						<div class="filter" data-filter="0">
							<div class="filter-inner"></div>
							<p>No Filter</p>
						</div>
					</div>
				</div>
				<form method="post" action>
					<input type="text" id="filter-input" name="filter" hidden required value="0">
					<div class="input-container textarea">
						<textarea name="description" id="description"></textarea>
						<label for="description">Description</label>
					</div>
					<input type="text" name="lat" id="lat" readonly hidden>
					<input type="text" name="lng" id="lng" readonly hidden>
					<div class="input-container">
						<input type="text" name="country" id="country">
						<label for="country">Country</label>
					</div>
					<div class="input-container">
						<input type="text" name="postcode" id="postcode">
						<label for="postcode">Post Code</label>
					</div>
					<div class="input-container">
						<input type="text" name="town" id="town">
						<label for="town">Town</label>
					</div>
					<div class="input-container">
						<input type="text" name="streetname" id="streetname">
						<label for="streetname">Streetname</label>
					</div>
					<div class="buttons">
						<button name="send" class="btn" id="send">Publish</button>
						<button name="cancel" class="btn cancel">Cancel</button>
					</div>
				</form>
			</div>
		</article>
	</section>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="js/filters.js"></script>
	<script src="js/location.js"></script>
</body>
</html>