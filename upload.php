<?php
	require_once("bootstrap/bootstrap.php");
	if (!empty($_POST)) {
		// Start new class user
		$file = new File();
		// Send posts to class setters
		$file->setFile($_FILES['file']);
		$file->setType("Image");
		if($file->uploadFile("feed")) {
			header("Location: post");
		}
	}
?><!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title></title>
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
	<link href="https://fonts.googleapis.com/css?family=Raleway:400,500,600,700" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="css/upload.css">
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
				Show your adventure in more then 1000 words!
			</h1>
		</article>
		<article class="upload-container">
			<form action method="post" enctype="multipart/form-data">
				<div class="upload">
					<input type="file" name="file" id="image-input">
					<div class="top-content">
						<div class="accepted-files">
							<svg xmlns="http://www.w3.org/2000/svg" width="46" height="32" viewBox="0 0 46 32" fill="none" role="img" class="icon ">
								<rect width="46" height="32" fill="#242a32"></rect>
								<path fill-rule="evenodd" clip-rule="evenodd" d="M5.5 2C2.60051 2 2 3.567 2 5.5V26.5C2 28.433 2.60051 30 5.5 30H40.5C43.3995 30 44 28.433 44 26.5V5.5C44 3.567 43.3995 2 40.5 2H5.5ZM34.5 9.30446C34.5 7.62276 33.156 6.26065 31.5 6.26065C29.844 6.26065 28.5 7.62276 28.5 9.30446C28.5 10.9862 29.844 12.3483 31.5 12.3483C33.156 12.3483 34.5 10.9862 34.5 9.30446ZM19.5 9.06416L9 25.2845H36L28.5 14.6311L25.545 17.8273L19.5 9.06416Z" fill="#242a32"></path>
								<path d="M34.073 24.2845H10.8386L19.5264 10.8636L24.7219 18.3951L25.4312 19.4234L26.2793 18.5062L28.3945 16.2183L34.073 24.2845ZM5.5 1C3.87746 1 2.65628 1.4434 1.88534 2.39605C1.1511 3.30336 1 4.46954 1 5.5V26.5C1 27.5305 1.1511 28.6966 1.88534 29.6039C2.65628 30.5566 3.87746 31 5.5 31H40.5C42.1225 31 43.3437 30.5566 44.1147 29.6039C44.8489 28.6966 45 27.5305 45 26.5V5.5C45 4.46954 44.8489 3.30336 44.1147 2.39605C43.3437 1.4434 42.1225 1 40.5 1H5.5ZM31.5 7.26065C32.5904 7.26065 33.5 8.16165 33.5 9.30446C33.5 10.4473 32.5904 11.3483 31.5 11.3483C30.4096 11.3483 29.5 10.4473 29.5 9.30446C29.5 8.16165 30.4096 7.26065 31.5 7.26065Z" stroke="white" stroke-width="2"></path>
							</svg>
							<div class="info">
								<strong>High resolution images</strong>
								<span>PNG & JPG</span>
							</div>
						</div>
					</div>

					<div class="middle-content">
						<div class="upload-cloud-container">
							<svg height="121" viewBox="0 0 161 121" width="161" id="upload-shot-cloud" role="img" aria-labelledby="73kdmp9ymlkhgb80nrdz7scm9bplc8"><title id="73kdmp9ymlkhgb80nrdz7scm9bplc8">New shot/upload shot cloud</title>
								<path d="m127.451625 47.2236111c.006708-26.1561667-21.017208-47.2236111-46.951625-47.2236111-25.9344167 0-46.9583333 21.0674444-46.9583333 47.0555556-18.79675 1.8620555-33.5416667 17.6861666-33.5416667 36.9722222 0 20.4221112 16.5159167 36.9722222 36.8958333 36.9722222h30.1875 26.8333334 30.1875003c20.379916 0 36.895833-16.550111 36.895833-36.9722222 0-19.2860556-14.744917-35.1101667-33.548375-36.8041667z"></path>
							</svg>
							<div class="upload-shot-arrow">
								<svg height="48" viewBox="0 0 75 48" width="75" id="upload-shot-arrow" role="img" aria-labelledby="710dk0jweeclcxm7cztsz3d5tg2eyjz"><title id="710dk0jweeclcxm7cztsz3d5tg2eyjz">New shot/upload shot arrow</title>
									<path d="m67 84.1111111h-17.2644167c-5.977125 0-8.9690416-7.2398333-4.7427916-11.4748333l35.5072083-35.5807222 35.507208 35.5807222c4.22625 4.235 1.234334 11.4748333-4.742791 11.4748333h-17.2691711z" fill="#242a32" transform="translate(-43 -37)"></path>
								</svg>
							</div>
						</div>
						<p>Drag and drop to upload</p>
						<small>or <span>browse</span> to choose a file</small>
						<em>(up to 10MB)</em>
					</div>
				</div>
				<div class="bottom-content">
					<button type="submit" name="submit" id="btn">Send Image</button>
				</div>
			</form>
		</article>
	</section>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script type="text/javascript" src="js/upload.js"></script>
</body>
</html>