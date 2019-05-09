<?php

    class ReportPost {
        private $postId;
        private $userId;

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
        
        public function report() {
	    	try {
				$conn = DB::getInstance();
		
				$statement = $conn->prepare("INSERT INTO posts_report (post_id, user_id) values (:postId, :userId)");
                $statement->bindValue(":postId", $this->getPostId());
				$statement->bindValue(":userId", $this->getUserId());
				
				$statement->execute();
				return true;
				
            } catch (Throwable $t) {
                // If database connection fails
				$_SESSION["errors"]["message"] = "<li>".$t."<li>";
                return false;
            }
		}
		
		public static function notYetReported($postId, $userId) {
			try {
				$conn = DB::getInstance();

				$statement = $conn->prepare("SELECT count(*) AS count FROM posts_report WHERE post_id = :postId AND user_id = :userId");
				$statement->bindValue(":userId", $userId);
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

		public static function deletePost($postId) {
			try {
				$conn = DB::getInstance();

				$statement = $conn->prepare("SELECT count(*) AS count FROM posts_report WHERE post_id = :postId");
				$statement->bindValue(":postId", $postId);
				$statement->execute();

				$result = $statement->fetch(PDO::FETCH_ASSOC);

				if ($result["count"] == 3) {
					$stmnt = $conn->prepare("UPDATE posts SET active = 0 WHERE id = :postId");
					$stmnt->bindValue(":postId", $postId);
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