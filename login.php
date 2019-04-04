<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>LogIn</title>
</head>
<body>

    <div class="form__field">
		<label for="Email">Email</label>
		<input type="text" name="email">
	</div>

	<div class="form__field">
		<label for="Password">Password</label>
		<input type="password" name="password">
	</div>

    <div class="form__field">
		<input type="submit" value="Sign in" class="btn btn--primary">	
		<input type="checkbox" id="rememberMe"><label for="rememberMe" class="label__inline">Remember me</label>
	</div>

    <div>
		<p>No account yet?<a href="register.php">Sign up here</a></p>
	</div>
    
</body>
</html>