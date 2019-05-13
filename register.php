<?php
	require_once("bootstrap/bootstrap.php");

	if (isset($_POST['register'])) {
			// Start new class user
		$user = new User();
			// Send posts to class setters
		$user->setEmail($_POST["email"]);
		$user->setPassword($_POST["password"]);
		$user->setConfirmPassword($_POST["confirmPassword"]);
		$user->setFirstname($_POST["firstname"]);
		$user->setLastname($_POST["lastname"]);
		$user->setUsername($_POST["username"]);

		if($user->register()) {
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
	<link rel="stylesheet" type="text/css" href="css/register.css">
</head>
<body>

	<?php if(!empty($_SESSION["errors"]["message"])) {
		require_once("error.php");
	}?>

	<div class="form-modal">

		<div class="form-toggle">
			<button id="login-toggle" onclick="toggleLogin()">log in</button>
			<button id="signup-toggle">sign up</button>
		</div>

		<div id="signup-form">
			<form action method="post">
				<div class="input-container small">
					<input type="text" id="firstname" name="firstname" value="<?php if(isset($_POST['firstname'])){ echo $_POST['firstname'];} ?>" autofocus required/>
					<label for="firstname">First Name</label>
				</div>
				<div class="input-container small">
					<input type="text" id="lastname" name="lastname" autofocus required value="<?php if(isset($_POST['lastname'])){ echo $_POST['lastname'];} ?>"/>
					<label for="lastname">Last Name</label>
				</div>
				<div class="input-container">
					<input type="email" id="email-register" name="email" autofocus required value="<?php if(isset($_POST['email'])){ echo $_POST['email'];} ?>"/>
					<label for="email-register">Email Address</label>
				</div>
				<div class="input-container">
					<input type="text" id="username-register" name="username" autofocus required value="<?php if(isset($_POST['username'])){ echo $_POST['username'];} ?>"/>
					<label for="username-register">Username</label>
				</div>
				<div class="input-container">
					<input type="password" id="password-register" name="password" autofocus required value="<?php if(isset($_POST['password'])){ echo $_POST['password'];} ?>"/>
					<label for="password-register">Password</label>
				</div>
				<div class="input-container">
					<input type="password" id="passwordConfirm" name="confirmPassword" autofocus required value="<?php if(isset($_POST['confirmPassword'])){ echo $_POST['confirmPassword'];} ?>"/>
					<label for="passwordConfirm">Confirm</label>
				</div>
				<div class="clearfix extra-settings">
					<div class="checkbox">
						<input type="checkbox" name="remember" id="remember-register">
						<label for="remember-register">
							Remember me
						</label>
					</div>
				</div>
				<button name="register" class="btn login">Sign up and explore</button>
			</form>
		</div>

	</div>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script type="text/javascript" src="js/login.js"></script>
</body>
</html>