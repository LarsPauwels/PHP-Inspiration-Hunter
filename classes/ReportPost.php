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
        
        public function saveReport() {
	    	try {
                $conn = DB::getInstance();

                $statement = $conn->prepare("INSERT INTO posts_report (post_id /*, user_id*/) values (:postId /*, :userId*/)");
                $statement->bindValue(":postid", $this->getPostId());
                // $statement->bindValue(":userid", $this->getUserId());
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
    }