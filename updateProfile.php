<?php

    require_once("bootstrap.php");

    // update description part
    if (!empty($_POST["updateDescription"])) {
        $user = new User();
        $user->setDescription($_POST["description"]);

        if ($user->updateDescription()) {
            $_SESSION["user"] = $user->getEmail();
            echo "Description succesfully updated";
        } else {
            echo "Something went wrong, please try again";
        }
    }
    
    // update email part
    if (!empty($_POST["updateEmail"])) {
        $user = new User();
        $user->setEmail($_POST["email"]);
        $user->setPassword($_POST["password"]);

        if ($user->updateEmail()) {
            $_SESSION["user"] = $user->getEmail();
            echo "Email succesfully updated";
        } else {
            echo "Something went wrong, please try again";
        }
    }

    // update password part
    if (!empty($_POST["updatePassword"])) {
        $user = new User();
        $user->setPassword($_POST["newPassword"]);

        if ($user->updatePassword()) {
            $_SESSION["user"] = $user->getEmail();
            echo "Password succesfully updated";
        } else {
            echo "Something went wrong, please try again";
        }
    }

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
                <h2>Update description</h2>

                <div>
                    <label for="description">Description</label>
                    <input type="text" name="description" id="description">
                </div>

                <div class="form__field">
                    <input name="updateDescription" type="submit" value="Update description">
                </div>

            </form>
        </div>

        <div>
            <form action="" method="POST">
                <h2>Update email</h2>

                <div>
					<label for="email">New email</label>
					<input type="email" name="email" id="email">
				</div>

				<div>
					<label for="password">Current password</label>
					<input type="password" name="password" id="password">
				</div>

                <div class="form__field">
					<input name="updateEmail" type="submit" value="Update email">	
				</div>

            </form>
        </div>

        <div>
            <form action="" method="POST">
                <h2>Update password</h2>

                <div>
                    <label for="currentPassword">Current password</label>
                    <input type="password" name="currentPassword" id="currentPassword">
                </div>

                <div>
                    <label for="newPassword">New password</label>
                    <input type="password" name="newPassword" id="newPassword">
                </div>

                <div>
                    <label for="confirmNewPassword">Confirm new password</label>
                    <input type="password" name="confirmNewPassword" id="confirmNewPassword">
                </div>

                <div class="form__field">
                    <input name="updatePassword" type="submit" value="Update password">
                </div>

            </form>
        </div>
    </div>
</body>
</html>