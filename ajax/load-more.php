<?php
	require_once('database/settings.php');

	$amountNew = $_POST["amountNew"];
	$filterNew = $_POST["filterNew"];

	$con=mysqli_connect($server, $user, $password, $databank);
	if (mysqli_connect_errno()) {
	    $bericht = "Failed to connect to MySQL: " . mysqli_connect_error();
	}

	$result = mysqli_query($con,"SELECT * FROM `items` WHERE class LIKE '%$filterNew%' ORDER BY `orderDate` DESC LIMIT $amountNew");

	$results = mysqli_query($con,"SELECT * FROM `items` WHERE class LIKE '%$filterNew%'");

	$rowcount = mysqli_num_rows($results);
	if ($amountNew >= $rowcount) {
		echo "
			<style>
				#load-more {
					display: none !important;
				}
			</style>
		";
	} else {
		echo "
			<style>
				#load-more {
					display: block !important;
				}
			</style>
		";
	}

	while($row = mysqli_fetch_array($result)) {
		echo "
			<div class='project ".$row['class']."' data-id=". $row["id"] .">
				<div class='project-img' style='background-image: url(".$row['img'].");'>
				</div>
				<div class='info'>
					<span data-id=". $row["id"] .">
						".$row['title']."
					</span>
					<p>
						".$row['skills']."
					</p>
				</div>
			</div>
		";
	}
?>

<script src="js/portfolio.js"></script>