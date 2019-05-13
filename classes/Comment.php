<?php

	/**
	 * 
	 */
	class Comment {
		private $message;
		private $postId;
		private $userId;

	    /**
	     * @return mixed
	     */
	    public function getMessage() {
	    	return $this->message;
	    }

	    /**
	     * @param mixed $message
	     *
	     * @return self
	     */
	    public function setMessage($message) {
	    	$this->message = $message;

	    	return $this;
	    }

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
	    public function getUserId() {
	        return $this->userId;
	    }

	    /**
	     * @param mixed $userId
	     *
	     * @return self
	     */
	    public function setUserId($userId) {
	        $this->userId = $userId;

	        return $this;
	    }

	    public function save() {
	    	try {
                $conn = DB::getInstance();

                $statement = $conn->prepare("INSERT INTO comments (message, user_id, post_id) values (:message, :userid, :postid)");
                $statement->bindValue(":message", $this->getMessage());
                $statement->bindValue(":userid", $this->getUserId());
                $statement->bindValue(":postid", $this->getPostId());
                if ($statement->execute()) {
                	return true;
                }
                return false;
            } catch (Throwable $t) {
                // If database connection fails
                $_SESSION["errors"]["message"] = "<li>".$t."<li>";
                return false;
            }
	    }

	    public static function getComment($postId) {
	    	try {
                $conn = DB::getInstance();

                $statement = $conn->prepare("SELECT * FROM comments, users WHERE post_id = :postid AND user_id = users.id ORDER BY comments.timestamp DESC LIMIT 5");
                $statement->bindValue(":postid", $postId);
                $statement->execute();
            	$result = array_reverse($statement->fetchAll());
            	return Hashtags::getTags($result, "message");
            } catch (Throwable $t) {
                // If database connection fails
                $_SESSION["errors"]["message"] = "<li>".$t."<li>";
                return false;
            }
	    }

	    public static function countComments($postId) {
	    	try {
                $conn = DB::getInstance();

                $statement = $conn->prepare("SELECT count(*) AS count FROM comments WHERE post_id = :postid");
                $statement->bindValue(":postid", $postId);
                $statement->execute();
            	$result = $statement->fetch(PDO::FETCH_ASSOC);
            	return $result["count"];
            } catch (Throwable $t) {
                // If database connection fails
                $_SESSION["errors"]["message"] = "<li>".$t."<li>";
                return false;
            }
	    }
	}