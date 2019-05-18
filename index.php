<?php
	require_once("bootstrap/bootstrap.php");

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
	<link rel="stylesheet" href="https://cssgram-cssgram.netdna-ssl.com/cssgram.min.css">
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
				<form action method="get">
					<input type="text" name="q" placeholder="Search for everything" class="search" value="<?php if(isset($_GET['q'])) { echo htmlspecialchars($_GET['q']); } ?>">
					<button class="fas fa-search search-btn"></button>
				</form>
			</div>
			<ul>
				<li class="extra active followers-open">
					<i class="fas fa-user-friends"></i>
				</li>
				<a href="upload">
					<li class="extra upload-open">
						<i class="fas fa-cloud-upload-alt"></i>
					</li>
				</a>
				<li class="user-container">
					<div class="user" style="background-image: url(<?php echo "uploads/profile_pic/".$_SESSION["user"]["profile_pic"] ?>);"></div>
					<p class="name">
						<?php
						echo htmlspecialchars($_SESSION["user"]["firstname"]." ".$_SESSION["user"]["lastname"]);
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
									<a href="profile?user=<?php echo htmlspecialchars($_SESSION['user']['username']); ?>" class="dropdown-item">
										<i class="fa fa-user" aria-hidden="true"></i>
										<span>Profile</span>
									</a>
								</li>
								<li>
									<a href="settings" class="dropdown-item">
										<i class="fa fa-cog" aria-hidden="true"></i>
										<span>Settings</span>
									</a>
								</li>
								<li class="dropdown-line extra-reverse">
								</li>
								<li class="extra-reverse followers-open">
									<a href="#" class="dropdown-item">
										<i class="fas fa-user-friends" aria-hidden="true"></i>
										<span>Followers</span>
									</a>
								</li>
								<li class="extra-reverse upload-open">
									<a href="upload" class="dropdown-item">
										<i class="fas fa-cloud-upload-alt" aria-hidden="true"></i>
										<span>Add Adventure</span>
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

	<div class="pop-up-container">
		<div class="pop-up">
			
		</div>
	</div>

	<div id="reload">
		<section>
			<?php
				if (isset($_POST["amount"])) {
					$amount = $_POST["amount"];
				} else {
					$amount = 20;
				}

				if (isset($_GET["q"]) && !empty($_GET["q"])) {
					$posts = Post::searchPost($_GET["q"], $amount);
				} else if(isset($_GET["post"]) && !empty($_GET["post"])) {
					$posts = Post::getPostById($_GET["post"], $amount);
				} else {
					$posts = Post::getPost($amount);
				}

				if (!empty($posts)):
					foreach ($posts as $post):
			?>
				<div class="posts-container">
					<article>
						<div class="post-header">
							<div class="user-container size">
								<a href="profile?user=<?php echo htmlspecialchars($post['username']); ?>">
									<div class="user" style="background-image: url(<?php echo "uploads/profile_pic/".$post["profile_pic"]; ?>);"></div>
								</a>
								<a href="profile?user=<?php echo htmlspecialchars($post['username']); ?>">
									<p class="name"><?php echo htmlspecialchars($post["username"]); ?></p>
								</a>
								<span>
									<?php echo Date::getTimePast($post["postTimestamp"]); ?>
								</span>
							</div>
						</div>
						<div class="post-image <?php echo $post['class']?>" style="background-image: url(<?php echo "uploads/feed/".$post["image"] ?>);"></div>
						<ul class="info">
							<li>
								<a href="#" data-id="<?php echo $post['postId']?>">
									<i class="fas fa-heart like <?php if(!Like::alreadyLiked($_SESSION['user']['id'], $post['postId'])) { echo 'already-liked'; } ?>"></i>
								</a>
								<span class="likes"><?php echo Like::getLikes($post['postId']); ?></span>
							</li>
							<li>
								<i class="fas fa-comment"></i>
								<span class="comments"><?php echo Comment::countComments($post['postId']); ?></span>
							</li>
							<li class="right">
								<?php if(Post::notYetReported($post["postId"])):?>
									<a href="#" data-id = "<?php echo $post["postId"]?>">
										<i class="fas fa-flag <?php $post["postId"]?>"></i>
									</a>
								<?php else: ?>
									<a href="#" class="reported" data-id = "<?php echo $post["postId"]?>">
										<i class="fas fa-flag <?php $post["postId"]?>"></i>
									</a>
								<?php endif; ?>
							</li>
						</ul>
						<p class="comment"><a href="profile?user=<?php echo htmlspecialchars($post['username']); ?>" class="username"><?php echo htmlspecialchars($post["username"]); ?></a> <?php echo $post["postDescription"]; ?></p>
						<div class="chat">
							<div class="load-comments" data-post="<?php echo $post['postId']?>">

							</div>
							<hr>
							<div class="message-container">
								<input type="text" name="message" placeholder="Add a comment..." class="message" data-post="<?php echo $post['postId']; ?>">
								<i class="fas fa-paper-plane"></i>
							</div>
						</div>
					</article>
					</div>
				<?php
					endforeach;
						if(sizeof($posts) < Post::getAmountPost()[0]):
				?>
					<div class="load-more-container">
						<button type="button" class="load-more">Load More</button>
					</div>
				<?php
						endif;
					else:
				?>
					<div class="empty-state">
						<img src="images/empty.png">
						<h1>No entry found!</h1>
						<p>There are no posts with this tag. So this tag can be for you alloon. <a href="upload">Wan't to use it?</a></p>
					</div>
				<?php
					endif;
				?>
		</section>
	</div>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="js/header.js"></script>
	<script src="js/like_post.js"></script>
	<script src="js/load_more.js"></script>
	<script src="js/comment_post.js"></script>
	<script src="js/search.js"></script>
	<script src="js/report.js"></script>
</body>
</html>