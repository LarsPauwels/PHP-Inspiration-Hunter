<link rel="stylesheet" type="text/css" href="css/error.css">
<div id="message">
	<div id="loader-message">
	</div>
	<div id="inner-message">
		<i class="fas fa-exclamation-triangle" id="error"></i>
		<h2>
			<?php 
				echo $_SESSION["errors"]["title"];
			?>
		</h2>
		<ul>
			<?php 
				echo $_SESSION["errors"]["message"]; 
				unset($_SESSION["errors"]); 
			?>
		</ul>
	</div>
</div>