<?php
	require_once("../bootstrap.php");

	if (!empty($_POST)) {
		$post = new Post();

		if (isset($_GET["q"]) && !empty($_GET["q"])) {
			$posts = Post::searchPost($_GET["q"], 1);
		} else {
			$posts = Post::getPost($_POST["amount"]);
		}

		if (!empty($posts)) {
			foreach ($posts as $post) {
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
							<i class="fas fa-heart <?php if(!LikePost::alreadyLiked($_SESSION['user']['id'], $post['postId'])) { echo 'already-liked'; } ?>"></i>
						</a>
						<span class="likes"><?php echo LikePost::getLikes($post['postId']); ?></span>
					</li>
					<li>
						<i class="fas fa-comment"></i>
						<span class="comments"><?php echo CommentPost::countComments($post['postId']); ?></span>
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
					<div class="message-container">
						<input type="text" name="message" placeholder="Add a comment..." class="message" data-post="<?php echo $post['postId']; ?>">
						<i class="fas fa-paper-plane"></i>
					</div>
				</div>
			</article>
		<?php
			}
		}
	}