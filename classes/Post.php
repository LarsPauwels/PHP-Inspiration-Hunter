<?php
	/**
	 * All functions for the feed
	 * Uploading image to database
	 */
	class Post {
		public function getPost() {
	    	try {
		    	// Getting database connection in class DB
	    		$conn = DB::getInstance();

	    		$statement = $conn->prepare("SELECT *, posts.id AS postId, posts.timestamp AS postTimestamp, posts.description AS postDescription FROM posts, users WHERE posts.user_id = users.id LIMIT 20");
	    		$statement->execute();
	    		$result = $statement->fetchAll();

	    		if ($statement->rowCount() > 0) {
	    			return Hashtags::getTags($result, "postDescription");
	    		}
	    		$_SESSION["errors"]["message"] = "<li>There are no posts to show.<li>";
	    		return false;
	    	} catch(Throwable $t) {
	    		// If database connection fails
	    		$_SESSION["errors"]["message"] = "<li>".$t."<li>";
	    		return false;
	    	}
	    }

	    public function getTime($timestamp) {
	    	$timestamp = strtotime($timestamp);
	    	$strTime = array("second", "minute", "hour", "day", "month", "year");
	    	$length = array("60","60","24","30","12","10");
	    	$currentTime = time();

	    	if($currentTime >= $timestamp) {
	    		$diff = $currentTime - $timestamp;
	    		for($i = 0; $diff >= $length[$i] && $i < count($length)-1; $i++) {
	    			$diff = $diff / $length[$i];
	    		}

	    		$diff = round($diff);
	    		if ($diff == 1) {
	    			return $diff . " " . $strTime[$i] . " ago ";
	    		}
	    		return $diff . " " . $strTime[$i] . "s ago ";
	    	}
	    }

	    public function searchPost($search) {
	    	try {
		    	// Getting database connection in class DB
	    		$conn = DB::getInstance();

	    		$statement = $conn->prepare("SELECT *, posts.id AS postId, posts.timestamp AS postTimestamp, posts.description AS postDescription FROM posts, users WHERE posts.user_id = users.id OR posts.description LIKE :search LIMIT 20");
	    		$statement->bindValue(":search", "%#".$search."%", PDO::PARAM_INT);
	    		$statement->execute();
	    		$result = $statement->fetchAll();

	    		if ($statement->rowCount() > 0) {
	    			return Hashtags::getTags($result, "postDescription");
	    		}
	    		$_SESSION["errors"]["message"] = "<li>There are no posts to show with the tag(s) ".$search.".<li>";
	    		return false;
	    	} catch(Throwable $t) {
	    		// If database connection fails
	    		$_SESSION["errors"]["message"] = "<li>".$t."<li>";
	    		return false;
	    	}
	    }
	}