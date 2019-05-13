<?php
	/**
	 * All functions for the feed
	 * Uploading image to database
	 */
	class Post {
		private $postId;
		private $description;
		private $path;
		private $filter;

		/**
	     * @return mixed
	     */
	    public function getPostId() {
	        return $this->postId;
	    }

	    /**
	     * @param mixed $postId
	     *
	     * @return self
	     */
	    public function setPostId($postId) {
	        $this->postId = $postId;

	        return $this;
	    }

	    /**
	     * @return mixed
	     */
	    public function getDescription() {
	    	return $this->description;
	    }

	    /**
	     * @param mixed $file
	     *
	     * @return self
	     */
	    public function setDescription($description) {
	    	$this->description = $description;

	    	return $this;
	    }

	    /**
	     * @return mixed
	     */
	    public function getPath() {
	        return $this->path;
	    }

	    /**
	     * @param mixed $path
	     *
	     * @return self
	     */
	    public function setPath($path) {
	        $this->path = $path;

	        return $this;
	    }

	    /**
	     * @return mixed
	     */
	    public function getFilter() {
	        return $this->filter;
	    }

	    /**
	     * @param mixed $filter
	     *
	     * @return self
	     */
	    public function setFilter($filter) {
	        $this->filter = $filter;

	        return $this;
	    }

		public static function getPost($amount) {
			try {
		    	// Getting database connection in class DB
	    		$conn = DB::getInstance();

	    		$statement = $conn->prepare("SELECT *, posts.id AS postId, posts.timestamp AS postTimestamp, posts.description AS postDescription FROM posts, users, filters WHERE posts.user_id = users.id AND posts.filter_id = filters.id AND posts.active = 1 ORDER BY posts.timestamp DESC LIMIT :amount");
	    		$statement->bindValue(":amount", $amount, PDO::PARAM_INT);
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

	    public static function searchPost($search, $amount) {
	    	try {
		    	// Getting database connection in class DB
	    		$conn = DB::getInstance();

	    		$statement = $conn->prepare("SELECT *, posts.id AS postId, posts.timestamp AS postTimestamp, posts.description AS postDescription FROM posts, users, filters WHERE posts.user_id = users.id AND posts.filter_id = filters.id AND posts.active = 1 AND posts.description LIKE :search ORDER BY posts.timestamp DESC LIMIT :amount");
	    		$statement->bindValue(":search", "%#".$search."%");
	    		$statement->bindValue(":amount", $amount, PDO::PARAM_INT);
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

	    public static function getAmountPost() {
	    	try {
		    	// Getting database connection in class DB
	    		$conn = DB::getInstance();

	    		$statement = $conn->prepare("SELECT count(*) FROM posts, users WHERE posts.user_id = users.id");
	    		$statement->execute();
	    		return $statement->fetch(PDO::FETCH_NUM);
	    	} catch(Throwable $t) {
	    		// If database connection fails
	    		$_SESSION["errors"]["message"] = "<li>".$t."<li>";
	    		return false;
	    	}
	    }

	    public function createPost($lat, $lng) {
	    	$data = [
	    		"description" => $this->description,
	    		"path" => $this->path
	    	];

	    	$rules = [
	    		"description" => [
	    			"emptyFields"
	    		],
	    		"path" => [
	    			"emptyFields"
	    		]
	    	];
	 
	    	$validation = new Validation;
	    	$validation->setData($data);
	    	$validation->setRules($rules);
	    	if($validation->isValid()) {
	    		$image = str_replace("uploads/feed/", "", $this->path);

	    		try {
		    		// Getting database connection in class DB
		    		$conn = DB::getInstance();

			    	// Query for adding the post
		    		$statement = $conn->prepare("INSERT INTO posts (image, description, active, user_id, filter_id, location_id) VALUES (:image, :description, 1, :user_id, :filter, (SELECT id FROM locations WHERE latitude = :lat AND longitude = :lng))");
		    		$statement->bindParam(":image", $image);
		    		$statement->bindParam(":description", $this->description);
		    		$statement->bindParam(":lat", $lat);
		    		$statement->bindParam(":lng", $lng);
		    		$statement->bindParam(":user_id", $_SESSION["user"]["id"]);
		    		$statement->bindParam(":filter", $this->filter);
		    		// Checking if post is succesfully added to the database
		    		if($statement->execute()) {
						// Post is successfully added => return true
		    			return true;
		    		}

		    		// Failed to add user => return false
		    		$_SESSION["errors"]["message"] = "<li>Something went wrong! Try again later.</li>";
		    		return false;
		    	} catch (Throwable $t) {
		    		// If database connection fails
		    		$_SESSION["errors"]["message"] = "<li>".$t."<li>";
		    		return false;
		    	}
	    	}
	    }

	    public static function getUserAmountPost($username) {
	    	try {
		    	// Getting database connection in class DB
	    		$conn = DB::getInstance();

	    		$statement = $conn->prepare("SELECT count(*) FROM posts, users WHERE posts.user_id = users.id AND users.username = :name");
	    		$statement->bindParam(":name", $username);
	    		$statement->execute();
	    		$result = $statement->fetch(PDO::FETCH_NUM);
	    		return Number::transform($result[0]);
	    	} catch(Throwable $t) {
	    		// If database connection fails
	    		$_SESSION["errors"]["message"] = "<li>".$t."<li>";
	    		return false;
	    	}
	    }

	    public function report() {
	    	try {
				$conn = DB::getInstance();
		
				$statement = $conn->prepare("INSERT INTO posts_report (post_id, user_id) values (:postId, :userId)");
                $statement->bindValue(":postId", $this->getPostId());
				$statement->bindValue(":userId", $_SESSION["user"]["id"]);
				
				$statement->execute();
				return true;
				
            } catch (Throwable $t) {
                // If database connection fails
				$_SESSION["errors"]["message"] = "<li>".$t."<li>";
                return false;
            }
		}
		
		public static function notYetReported($postId) {
			try {
				$conn = DB::getInstance();
				$statement = $conn->prepare("SELECT count(*) AS count FROM posts_report WHERE post_id = :postId AND user_id = :userId");
				$statement->bindValue(":userId", $_SESSION["user"]["id"]);
				$statement->bindValue(":postId", $postId);
				$statement->execute();
				$result = $statement->fetch(PDO::FETCH_ASSOC);
				if ($result["count"] == 0) {
					return true;
				}
				return false;
			} catch (Throwable $t) {
				// If database connection fails
				$_SESSION["errors"]["message"] = "<li>".$t."<li>";
				return false;
			}
		}

		public function deletePost() {
			try {
				$conn = DB::getInstance();
				$statement = $conn->prepare("SELECT count(*) AS count FROM posts_report WHERE post_id = :postId");
				$statement->bindValue(":postId", $this->postId);
				$statement->execute();
				$result = $statement->fetch(PDO::FETCH_ASSOC);
				if ($result["count"] == 3) {
					$stmnt = $conn->prepare("UPDATE posts SET active = 0 WHERE id = :postId");
					$stmnt->bindValue(":postId", $this->postId);
					$stmnt->execute();
					return true;
				}
				return false;
			} catch (Throwable $t) {
				// If database connection fails
				$_SESSION["errors"]["message"] = "<li>".$t."<li>";
				return false;
			}
		}
	}