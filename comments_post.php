<?php
	require_once("bootstrap.php");

	$count = CommentPost::countComments($_POST["postId"]);
	if ($count > 5):
?>
<a href="#" class="view-all">View all <?php echo $count ?> comments</a>
<?php endif; ?>
<ul class="chat-inner">
	<?php
		foreach (CommentPost::getComment($_POST["postId"]) as $comment):
	?>
		<li>
			<i class="fas fa-heart"></i>
			<p class="comment"><a href="#" class="username"><?php echo $comment["username"]; ?></a> <?php echo $comment["message"]; ?></p>
		</li>
	<?php
		endforeach;
	?>
</ul>