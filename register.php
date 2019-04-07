<?php
	require_once("bootstrap.php");
	if (!empty($_POST)) {
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
			session_start();
			$_SESSION["user"] = $user->getEmail();
			header("Location: index.php");
		}
	}
?><!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<div>
		<div>
			<form action="" method="post">
				<h2>Sign In</h2>

				<!-- If return is false - show div form-error-->
				<?php if(isset($_SESSION["errors"])): ?>
				<div class="form__error">
					<p>
						<?php echo $_SESSION["errors"]; ?>
					</p>
				</div>
				<?php endif; ?>

				<div>
					<label for="firstname">Firts Name</label>
					<input type="text" name="firstname" id="firstname">
				</div>

				<div>
					<label for="lastname">Last Name</label>
					<input type="text" name="lastname" id="lastname">
				</div>

				<div>
					<label for="username">Username</label>
					<input type="text" name="username" id="username">
				</div>

				<div>
					<label for="email">Email</label>
					<input type="email" name="email" id="email">
				</div>

				<div>
					<label for="password">Password</label>
					<input type="password" name="password" id="password">
				</div>

				<div>
					<label for="confirmPassword">Confirm Password</label>
					<input type="password" name="confirmPassword" id="confirmPassword">
				</div>

				<div class="form__field">
					<input type="submit" value="Sign up">	
				</div>

				<br>

				<div>
					<p>Already have a account?<a href="register.php">Sign in here</a></p>
				</div>
			</form>
		</div>
	</div>
</body>
</html>