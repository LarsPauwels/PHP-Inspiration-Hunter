<?php

    require_once("bootstrap.php");

    // update description part
    if (!empty($_POST["updateDescription"])) {
        $user = new User();
        $user->setDescription($_POST["description"]);
        $_SESSION["username"] = $user->getDescription();

        if ($user->updateDescription()) {
            $_SESSION["user"] = $user->getEmail();
        }
    }
    
    // update email part
    if (!empty($_POST["updateEmail"])) {
        $user = new User();
        $user->setEmail($_POST["email"]);
        $user->setPassword($_POST["password"]);
        $_SESSION["username"] = $user->getDescription();

        if ($user->updateEmail()) {
            $_SESSION["user"] = $user->getEmail();
        }
    }

    // update password part
    if (!empty($_POST["updatePassword"])) {
        $user = new User();
        $user->setCurrentPassword($_POST["currentPassword"]);
        $user->setPassword($_POST["newPassword"]);
        $user->setConfirmPassword($_POST["confirmNewPassword"]);

        if ($user->updatePassword()) {
            $_SESSION["user"] = $user->getEmail();
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

                <!-- If return is false - show div form-error-->
				<?php if(isset($_SESSION["errors"])): ?>
				<div class="form__error">
					<p>
						<?php echo $_SESSION["errors"]; ?>
					</p>
				</div>
				<?php endif; ?>

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