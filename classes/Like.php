<?php
	/**
	 * 
	 */
	class Like {
		private $postId;
        private $userId;

        /**
         * Get the value of postId
         */ 
        public function getPostId() {
            return $this->postId;
        }

        /**
         * Set the value of postId
         *
         * @return  self
         */ 
        public function setPostId($postId) {
            $this->postId = $postId;

            return $this;
        }

        /**
         * Get the value of userId
         */ 
        public function getUserId() {
            return $this->userId;
        }

        /**
         * Set the value of userId
         *
         * @return  self
         */ 
        public function setUserId($userId) {
            $this->userId = $userId;

            return $this;
        }

        public function saveLike() {
            try {
                $conn = DB::getInstance();
                $statement = $conn->prepare("INSERT INTO likes_posts (post_id, user_id) values (:post_id, :user_id)");
                $statement->bindValue(":post_id", $this->postId);
                $statement->bindValue(":user_id", $this->userId);
                $statement->execute();
            } catch (Throwable $t) {
                // If database connection fails
                $_SESSION["errors"]["message"] = "<li>".$t."<li>";
                return false;
            }
        }

        public function dislike() {
            try {
                $conn = DB::getInstance();

                $statement = $conn->prepare("DELETE FROM likes_posts WHERE post_id = :post_id AND user_id = :user_id");
                $statement->bindValue(":post_id", $this->postId);
                $statement->bindValue(":user_id", $this->userId);
                $statement->execute();
            } catch (Throwable $t) {
                // If database connection fails
                $_SESSION["errors"]["message"] = "<li>".$t."<li>";
                return false;
            }
        }

        public function alreadyLiked($userid, $postid) {
            $conn = DB::getInstance();

            $statement = $conn->prepare("SELECT count(*) AS count FROM likes_posts WHERE user_id = :userid AND post_id = :postid");
            $statement->bindValue(":userid", $userid);
            $statement->bindValue(":postid", $postid);
            $statement->execute();
            $result = $statement->fetch(PDO::FETCH_ASSOC);

            if ($result["count"] == 0) {
                return true;
            }
            return false;
        }
        
		public static function getLikes($id){
	    	$conn = Db::getInstance();
	    	$statement = $conn->prepare("SELECT count(*) AS count FROM likes_posts where post_id = :postid");
	    	$statement->bindValue(":postid", $id);
	    	$statement->execute();
	    	$result = $statement->fetch(PDO::FETCH_ASSOC);
	    	return $result['count'];
	    }
	}