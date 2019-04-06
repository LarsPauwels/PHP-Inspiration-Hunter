<?php
	if( !empty($_POST) ) {
		//Connection
		$conn = new PDO("mysql:host=localhost;dbname=urbex", "root", "root");
		//Get value out of POST
		$email = $_POST['email'];
		$password = $_POST['password'];

		//Query
		$statement = $conn->prepare("select * from users where email = :email");
		//Placeholder for SQL-injection
		$statement->bindParam(":email", $email);
		$statement->execute();
		$user = $statement->fetch(PDO::FETCH_ASSOC);
	
		//Checks if password matches the hash from database		
		if( password_verify($password, $user['password'] ) ) {
			//Yes? -> Go to index.php page
			header('location: index.php');
		} else {
			$error = "Login failed";
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

				<!--  if return is false - show div form-error-->
				<?php if( isset($error) ): ?>
				<div class="form__error">
					<p>
						Sorry, we can't log you in with that email address and password. Can you try again?
					</p>
				</div>
				<?php endif; ?>

				<div>
					<label for="Email">Email</label>
					<input type="text" name="email">
				</div>

				<div>
					<label for="Password">Password</label>
					<input type="password" name="password">
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