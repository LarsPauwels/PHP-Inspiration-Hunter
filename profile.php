<?php

    require_once("bootstrap.php");

    // upload profile picture part
    if (!empty($_POST["profilePic"])) {
        echo "test1";
        $upload = new UploadProfilePic();
        var_dump($_FILES);
        $upload->setFile($_FILES["profilePic"]);
		$upload->checkFile();
	}

    // update description part
    if (!empty($_POST["updateDescription"])) {
        $user = new User();
        $user->setDescription($_POST["description"]);
        $user->updateDescription();
    }

    // update email part
    if (!empty($_POST["updateEmail"])) {
        $user = new User();
        $user->setEmail($_POST["email"]);
        $user->setPassword($_POST["password"]);
        $user->updateEmail();
    }

    // update password part
    if (!empty($_POST["updatePassword"])) {
        $user = new User();
        $user->setPassword($_POST["newPassword"]);
        $user->setConfirmPassword($_POST["confirmNewPassword"]);
        $user->setCurrentPassword($_POST["currentPassword"]);
        $user->updatePassword();
    }

?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Update email</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Raleway:400,500,600,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
</head>
<body>
    <div>
        <div>

            <?php if(!empty($_SESSION["errors"]["message"])) {
                require_once("error.php");
            }?>

            <form action="" method="POST" enctype="multipart/form-data">
                <h2>Upload profile picture</h2>

                <div>
                    <label for="profilePic">Upload profile pic</label>
                    <input type="file" name="profilePic">
                </div>

                <div class="form__field">
                    <input  name="profilePic" type="submit" value="Upload profile pic">
                </div>

            </form>

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