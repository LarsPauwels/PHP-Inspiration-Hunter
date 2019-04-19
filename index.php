<?php
	require_once("bootstrap.php");

	if (!isset($_SESSION["user"])) {
		header("Location: login");
	}
?><!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title></title>
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
	<link href="https://fonts.googleapis.com/css?family=Raleway:400,500,600,700" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>

	<?php if(!empty($_SESSION["errors"]["message"])) {
		require_once("error.php");
	}?>

	<header>
		<img src="images/full_logo.png" class="logo">
		<div id="header-right" class="clearfix">
			<div class="search-container">
				<input type="text" name="search" placeholder="Search for everything" class="search">
				<button class="fas fa-search"></button>
			</div>
			<ul>
				<li class="active extra bell-open">
					<i class="fas fa-bell"></i>
				</li>
				<li class="extra followers-open">
					<i class="fas fa-user-friends"></i>
				</li>
				<li class="extra upload-open">
					<i class="fas fa-cloud-upload-alt"></i>
				</li>
				<li class="user-container">
					<div class="user" style="background-image: url(<?php echo "uploads/profile_pic/".$_SESSION["user"]["profile_pic"] ?>);"></div>
					<p class="name">
						<?php
						echo $_SESSION["user"]["firstname"]." ".$_SESSION["user"]["lastname"];
						?>
					</p>
					<div class="status">
						<span></span>
						<p>Online</p>
					</div>
					<i class="fas fa-angle-down"></i>

					<ul class="dropdown profile-settings">
						<li>
							<ul class="dropdown-items">
								<li>
									<a href="profile.php" class="dropdown-item">
										<i class="fa fa-user" aria-hidden="true"></i>
										<span>Profile</span>
									</a>
								</li>
								<li>
									<a href="#" class="dropdown-item">
										<i class="fa fa-cog" aria-hidden="true"></i>
										<span>Settings</span>
									</a>
								</li>
								<li class="dropdown-line extra-reverse">
								</li>
								<li class="extra-reverse bell-open">
									<a href="#" class="dropdown-item">
										<i class="fas fa-bell" aria-hidden="true"></i>
										<span>Notifications</span>
									</a>
								</li>
								<li class="extra-reverse upload-open">
									<a href="#" class="dropdown-item">
										<i class="fas fa-plus" aria-hidden="true"></i>
										<span>Add Adventure</span>
									</a>
								</li>
								<li class="extra-reverse followers-open">
									<a href="#" class="dropdown-item">
										<i class="fas fa-user-friends" aria-hidden="true"></i>
										<span>Followers</span>
									</a>
								</li>
								<li class="dropdown-line">
								</li>
								<li>
									<a href="logout" class="dropdown-item">
										<i class="fa fa-sign-out-alt" aria-hidden="true"></i>
										<span>Log Out</span>
									</a>
								</li>
							</ul>
						</li>
					</ul>
				</li>
			</ul>
		</div>
	</header>

	<nav>
		<div class="hamburger">
			<i class="fas fa-bars"></i>
		</div>

		<ul id="menu">
			<li class="active">
				<a href="index">
					<i class="fas fa-compass"></i>
					<span class="tooltiptext">Explore</span>
				</a>
			</li>
			<li>
				<i class="fas fa-ghost"></i>
				<span class="tooltiptext">Stories</span>
			</li>
			<li>
				<i class="fas fa-user"></i>
				<span class="tooltiptext">Users</span>
			</li>
			<li>
				<i class="fas fa-map-marker-alt"></i>
				<span class="tooltiptext">Locations</span>
			</li>
		</ul>
		<ul id="submenu">
			<li>
				<i class="fas fa-cog"></i>
				<span class="tooltiptext">Settings</span>
			</li>
			<li>
				<a href="logout">
					<i class="fas fa-sign-out-alt"></i>
					<span class="tooltiptext">Log Out</span>
				</a>
			</li>
		</ul>
	</nav>

	<div class="pop-up-container">
		<div class="pop-up">
			
		</div>
	</div>

	<section>
		<?php
			foreach (Post::getPost() as $post):
		?>
			<article>
				<div class="post-header">
					<div class="user-container">
						<div class="user" style="background-image: url(<?php echo "uploads/profile_pic/".$post["profile_pic"]; ?>);"></div>
						<p class="name"><?php echo $post["firstname"]." ".$post["lastname"]; ?></p>
						<span>
							<?php echo Post::getTime($post["postTimestamp"]); ?>
						</span>
					</div>
				</div>
				<div class="post-image" style="background-image: url(<?php echo "uploads/feed/".$post["image"] ?>);"></div>
				<ul class="info">
					<li>
						<a href="#" class="like" data-id="<?php echo $post['postId']?>">
							<i class="fas fa-heart <?php if(!PostLike::alreadyLiked($_SESSION['user']['id'], $post['postId'])) { echo 'already-liked'; } ?>"></i>
						</a>
						<span class="likes"><?php echo Post::getLikes($post['postId']); ?></span>
					</li>
					<li>
						<i class="fas fa-comment"></i>
						<span class="comments">485</span>
					</li>
					<li>
						<a href="#">
							<i class="fas fa-share-alt"></i>
						</a>
					</li>
				</ul>
				<p class="comment"><a href="#" class="username"><?php echo $post["username"]; ?></a> <?php echo $post["postDescription"]; ?></p>
				<div class="chat">
					<div class="load-comments" data-post="<?php echo $post['postId']?>">
						
					</div>
					<hr>
					<input type="text" name="message" placeholder="Add a comment..." class="message" data-post="<?php echo $post['postId']; ?>">
				</div>
			</article>
		<?php
			endforeach;
		?>
	</section>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="js/post_like.js"></script>
	<script src="js/send_comment.js"></script>
	<script src="js/index.js"></script>
</body>
</html>