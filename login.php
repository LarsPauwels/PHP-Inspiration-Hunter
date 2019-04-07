<?php
	require_once("bootstrap.php");
	if(!empty($_POST)) {
		// Start new class user
		$user = new User();
		// Send posts to class setters
		$user->setEmail($_POST["email"]);
		$user->setPassword($_POST["password"]);

		if($user->login()) {
			session_start();
			$_SESSION["user"] = $user->getEmail();
			header("Location: index.php");
		}
	}
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>LogIn</title>
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
					<label for="email">Email</label>
					<input type="email" name="email" id="email">
				</div>

				<div>
					<label for="password">Password</label>
					<input type="password" name="password" id="password">
				</div>

				<div class="form__field">
					<input type="submit" value="Sign in">	
					<input type="checkbox" id="rememberMe"> 
					<label for="rememberMe">Remember me</label>
				</div>

				<br>

				<div>
					<p>No account yet?<a href="register.php">Sign up here</a></p>
				</div>
			</form>
		</div>
	</div>
</body>
</html>