<?php

    require_once("bootstrap.php");
    if (!empty($_POST)) {
        $user = new User();
        $user->setEmail($_POST["email"]);
        $newEmail = $_POST["email"];

        if ($user->updateEmail()) {
            $_SESSION["user"] = $user->getEmail();
        }
    }

    
    $currentUser = $_SESSION["user"];
    echo session_id();
    echo $currentUser;
    echo $newEmail;

    

?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Update email</title>
</head>
<body>
    <div>
        <div>
            <form action="" method="POST">
                <h2>Update email</h2>

                <div>
					<label for="email">New email</label>
					<input type="email" name="email" id="email">
				</div>

				<div>
					<label for="currentPassword">Current password</label>
					<input type="password" name="currentPassword" id="currentPassword">
				</div>

                <div class="form__field">
					<input type="submit" value="Update email">	
				</div>

            </form>
        </div>
    </div>
</body>
</html>