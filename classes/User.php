<?php
	/**
	 * All functions for user
	 * Creating a user in database (register)
	 * Finding user in databse (login)
	 */
	class User {
		private $email;
		private $password;

	    /**
	     * @return mixed
	     */
	    public function getEmail() {
	        return $this->email;
	    }

	    /**
	     * @param mixed $email
	     *
	     * @return self
	     */
	    public function setEmail($email) {
	        $this->email = $email;

	        return $this;
	    }

	    /**
	     * @return mixed
	     */
	    public function getPassword() {
	        return $this->password;
	    }

	    /**
	     * @param mixed $password
	     *
	     * @return self
	     */
	    public function setPassword($password) {
	        $this->password = $password;

	        return $this;
	    }

	    /**
	     * @return boolean
	     * true if logging in is successful
	     * false if logging in is unsuccessful 
	     */
	    public function login() {
	    	try {
	    		// Getting database connection in class DB
	    		$conn = DB::getInstance();

	    		// Query for getting the user
				$statement = $conn->prepare("select * from users where email = :email");
				$statement->bindParam(":email", $this->email);
				$statement->execute();
				$user = $statement->fetch(PDO::FETCH_ASSOC);

				// Checking if password is the same as database password
				if(password_verify($this->password, $user['password'])) {
					// Password is the same => return true
					return true;
				}
				// Password isn't the same => return false
				return false;
	    	} catch(Throwable $t) {
	    		return false;
	    	}
	    }
	}