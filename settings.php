<?php
	require_once("bootstrap/bootstrap.php");

	// update description part
    if (isset($_POST["updateDescription"])) {
        $user = new User();
        $user->setDescription($_POST["description"]);
        if ($user->updateDescription()) {
        	header("Location: index");
        }
        
    }

    // update email part
    if (isset($_POST["updateEmail"])) {
        $user = new User();
        $user->setEmail($_POST["email"]);
        $user->setPassword($_POST["password"]);
        if ($user->updateEmail()) {
        	header("Location: index");
        }
    }

    // update password part
    if (isset($_POST["updatePassword"])) {
        $user = new User();
        $user->setPassword($_POST["newPassword"]);
        $user->setConfirmPassword($_POST["confirmPassword"]);
        $user->setOldPassword($_POST["oldPassword"]);
        if ($user->updatePassword()) {
        	header("Location: index");
    	}
    }
?><!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Settings</title>
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
	<link href="https://fonts.googleapis.com/css?family=Raleway:400,500,600,700" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="css/post.css">
	<link rel="stylesheet" type="text/css" href="css/settings.css">
</head>
<body>

	<?php if(!empty($_SESSION["errors"]["message"])) {
		require_once("error.php");
	}?>

	<header>
		<a href="index">
			<img src="images/full_logo.png" class="logo">
		</a>
	</header>

	<nav>
		<a href="index">
			<div class="hamburger">
				<i class="fas fa-bars"></i>
			</div>
		</a>

		<ul id="menu">
			<a href="index">
				<li class="active">
					<i class="fas fa-compass"></i>
					<span class="tooltiptext">Explore</span>
				</li>
			</a>
			<a href="locations">
				<li>
					<i class="fas fa-map-marker-alt"></i>
					<span class="tooltiptext">Locations</span>
				</li>
			</a>
			<a href="profile?user=<?php echo htmlspecialchars($_SESSION['user']['username'])?>">
				<li>
					<i class="fas fa-user"></i>
					<span class="tooltiptext">Profile</span>
				</li>
			</a>
		</ul>
		<ul id="submenu">
			<li>
				<a href="settings">
					<i class="fas fa-cog"></i>
					<span class="tooltiptext">Settings</span>
				</a>
			</li>
			<li>
				<a href="logout">
					<i class="fas fa-sign-out-alt"></i>
					<span class="tooltiptext">Log Out</span>
				</a>
			</li>
		</ul>
	</nav>

	<section>
		<article class="title">
			<h1>
				Settings
			</h1>
			<p>
				Change your profile details here.
			</p>
		</article>
		<article class="container">
			<div class="container-inner">
				<form method="post" action>
					<h1>Change your description:</h1>
					<div class="input-container textarea">
						<textarea name="description" id="description"><?php if(isset($_POST["description"])) { echo htmlspecialchars($_POST["description"]); } ?></textarea>
						<label for="description">Description</label>
					</div>
					<div class="buttons">
						<button name="updateDescription" class="btn" id="send">Publish</button>
					</div>
				</form>

				<form method="post" action>
					<h1>Change your email:</h1>
					<div class="input-container">
                   		<input type="email" name="email" id="email" value="<?php if(isset($_POST["email"])) { echo htmlspecialchars($_POST["email"]); } ?>">
                   		<label for="email">New email</label>
					</div>
					<div class="input-container">
						<input type="password" name="password" id="password" value="<?php if(isset($_POST["password"])) { echo htmlspecialchars($_POST["password"]); } ?>">
                   		<label for="password">Password</label>
					</div>
					<div class="buttons">
						<button name="updateEmail" class="btn" id="send">Publish</button>
					</div>
				</form>

				<form method="post" action class="changePassword">
					<h1>Change your password:</h1>
					<div class="input-container">
                    	<input type="password" name="oldPassword" id="oldPassword" value="<?php if(isset($_POST["oldPassword"])) { echo htmlspecialchars($_POST["oldPassword"]); } ?>">
                    	<label for="oldPassword">Current password</label>
					</div>
					<div class="input-container">
						<input type="password" name="newPassword" id="newPassword" value="<?php if(isset($_POST["newPassword"])) { echo htmlspecialchars($_POST["newPassword"]); } ?>">
						<label for="newPassword">New password</label>
					</div>
					<div class="input-container">
						<input type="password" name="confirmPassword" id="confirmPassword" value="<?php if(isset($_POST["confirmPassword"])) { echo htmlspecialchars($_POST["confirmPassword"]); } ?>">
						<label for="confirmPassword">Confirm new password</label>
					</div>
					<div class="buttons">
						<button name="updatePassword" class="btn" id="send">Publish</button>
					</div>
				</form>
			</div>
		</article>
	</section>

</body>
</html>