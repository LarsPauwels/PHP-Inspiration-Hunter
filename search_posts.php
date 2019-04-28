<?php
	foreach (Post::getPost($_POST["search"]) as $post):
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