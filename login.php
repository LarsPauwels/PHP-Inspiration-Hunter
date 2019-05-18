<?php
	require_once("bootstrap/bootstrap.php");

	if(isset($_POST['login'])) {
		// Start new class user
		$user = new User();
		// Send posts to class setters
		$user->setEmail($_POST["email"]);
		$user->setPassword($_POST["password"]);

		if($user->login()) {
			header("Location: index");
		}
	}
?><html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title></title>
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
	<link href="https://fonts.googleapis.com/css?family=Raleway:400,500,600,700" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="css/login.css">
</head>
<body>

	<?php if(!empty($_SESSION["errors"]["message"])) {
		require_once("error.php");
	}?>

	<div class="form-modal">

		<div class="form-toggle">
			<button id="login-toggle">log in</button>
			<button id="signup-toggle" onclick="toggleSignup()">sign up</button>
		</div>

		<div id="login-form">
			<form action method="post">
				<div class="input-container">
					<input type="text" id="email" name="email" autofocus required value="<?php if(isset($_POST['email'])){ echo htmlspecialchars($_POST['email']);} ?>"/>
					<label for="email">Email Address</label>
				</div>
				<div class="input-container">
					<input type="password" id="password" name="password" required value="<?php if(isset($_POST['password'])){ echo htmlspecialchars($_POST['password']);} ?>"/>
					<label for="password">Password</label>
				</div>
				<div class="clearfix extra-settings">
					<div class="checkbox">
						<input type="checkbox" name="remember" id="remember">
						<label for="remember">
							Remember me
						</label>
					</div>
				</div>
				<button name="login" class="btn login">log in and explore</button>
			</form>
		</div>

	</div>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script type="text/javascript" src="js/login.js"></script>
</body>
</html>