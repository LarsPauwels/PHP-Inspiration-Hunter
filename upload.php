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
								<span>PNG, JPG, GIF</span>
							</div>
						</div>
						<div class="accepted-files">
							<svg xmlns="http://www.w3.org/2000/svg" width="46" height="32" viewBox="0 0 46 32" fill="none" role="img" class="icon ">
								<rect width="46" height="32" fill="#242a32"></rect>
								<path fill-rule="evenodd" clip-rule="evenodd" d="M5.5 2C2.60051 2 2 3.567 2 5.5V26.5C2 28.433 2.60051 30 5.5 30H40.5C43.3995 30 44 28.433 44 26.5V5.5C44 3.567 43.3995 2 40.5 2H5.5ZM18.044 21.1C17.208 22.658 15.707 23.323 13.978 23.323C11.964 23.323 10.33 22.582 9.17104 21.347C7.93604 20.017 7.29004 18.155 7.29004 15.989C7.29004 13.576 8.16404 11.467 9.74104 10.137C10.881 9.168 12.344 8.617 14.206 8.617C17.778 8.617 19.868 10.517 20.381 13.215H17.151C16.809 12.17 15.916 11.296 14.301 11.296C11.793 11.296 10.577 13.329 10.577 15.989C10.577 18.706 12.021 20.682 14.339 20.682C16.334 20.682 17.531 19.333 17.55 17.908V17.851H14.7V15.438H20.609V23H18.367L18.101 21.1H18.044ZM25.9895 23H22.7405V8.864H25.9895V23ZM37.5956 14.697V17.338H31.6296V23H28.3996V8.864H38.7736V11.619H31.6296V14.697H37.5956Z" fill="#242a32"></path>
								<path d="M18.044 20.1H17.7878C18.2673 19.4784 18.5393 18.722 18.55 17.9213L18.55 17.9213V17.908V17.851V16.851H17.55H15.7V16.438H19.609V22H19.2368L19.0914 20.9614L18.9708 20.1H18.101H18.044ZM14.339 21.682C15.4125 21.682 16.3377 21.3591 17.0452 20.8298C16.4084 21.8453 15.3493 22.323 13.978 22.323C12.2275 22.323 10.8626 21.6872 9.90192 20.6645C8.87467 19.557 8.29004 17.9577 8.29004 15.989C8.29004 13.8103 9.07648 12.0056 10.3857 10.9014L10.3858 10.9014L10.3887 10.8989C11.3308 10.0981 12.5579 9.617 14.206 9.617C15.8133 9.617 16.9983 10.0423 17.8226 10.6904C18.3367 11.0945 18.7395 11.6079 19.0222 12.215H17.8023C17.5636 11.7836 17.2344 11.3852 16.8015 11.0622C16.1399 10.5685 15.2963 10.296 14.301 10.296C12.7394 10.296 11.5047 10.9473 10.6926 12.053C9.9094 13.1194 9.57704 14.5245 9.57704 15.989C9.57704 17.5144 9.98166 18.9207 10.8005 19.9697C11.6367 21.0408 12.8654 21.682 14.339 21.682ZM31.6296 16.338H30.6296V17.338V22H29.3996V9.864H37.7736V10.619H31.6296H30.6296V11.619V14.697V15.697H31.6296H36.5956V16.338H31.6296ZM5.5 1C3.87746 1 2.65628 1.4434 1.88534 2.39605C1.1511 3.30336 1 4.46954 1 5.5V26.5C1 27.5305 1.1511 28.6966 1.88534 29.6039C2.65628 30.5566 3.87746 31 5.5 31H40.5C42.1225 31 43.3437 30.5566 44.1147 29.6039C44.8489 28.6966 45 27.5305 45 26.5V5.5C45 4.46954 44.8489 3.30336 44.1147 2.39605C43.3437 1.4434 42.1225 1 40.5 1H5.5ZM24.9895 9.864V22H23.7405V9.864H24.9895Z" stroke="white" stroke-width="2"></path>
							</svg>
							<div class="info">
								<strong>Animated GIFs</strong>
								<span>800×600 or 400×300</span>
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