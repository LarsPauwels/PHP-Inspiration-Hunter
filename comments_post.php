<?php
	require_once("bootstrap/bootstrap.php");

	$count = Comment::countComments($_POST["postId"]);
	if ($count > 5):
?>
<a href="#" class="view-all">View all <?php echo $count ?> comments</a>
<?php endif; ?>
<ul class="chat-inner">
	<?php
		foreach (Comment::getComment($_POST["postId"]) as $comment):
	?>
		<li>
			<p class="comment"><a href="#" class="username"><?php echo $comment["username"]; ?></a> <?php echo $comment["message"]; ?></p>
		</li>
	<?php
		endforeach;
	?>
</ul>