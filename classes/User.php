<?php
	/**
	 * All functions for user
	 * Creating a user in database (register)
	 * Finding user in databse (login)
	 */
	class User {
		private $email;
		private $password;
		private $confirmPassword;
		private $firstname;
		private $lastname;
		private $username;

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
	     * @return mixed
	     */
	    public function getConfirmPassword() {
	        return $this->confirmPassword;
	    }

	    /**
	     * @param mixed $confirmPassword
	     *
	     * @return self
	     */
	    public function setConfirmPassword($confirmPassword) {
	        $this->confirmPassword = $confirmPassword;

	        return $this;
	    }

	    /**
	     * @return mixed
	     */
	    public function getFirstname() {
	        return $this->firstname;
	    }

	    /**
	     * @param mixed $firstname
	     *
	     * @return self
	     */
	    public function setFirstname($firstname) {
	        $this->firstname = $firstname;

	        return $this;
	    }

	    /**
	     * @return mixed
	     */
	    public function getLastname() {
	        return $this->lastname;
	    }

	    /**
	     * @param mixed $lastname
	     *
	     * @return self
	     */
	    public function setLastname($lastname) {
	        $this->lastname = $lastname;

	        return $this;
	    }

	    /**
	     * @return mixed
	     */
	    public function getUsername() {
	        return $this->username;
	    }

	    /**
	     * @param mixed $username
	     *
	     * @return self
	     */
	    public function setUsername($username) {
	        $this->username = $username;

	        return $this;
	    }

	    /**
	     * @return boolean
	     * true if logging in is successful
	     * false if logging in is unsuccessful 
	     */
	    public function login() {
	    	try {
	    		require_once("RegisterChecks.php");

	    		if(canLogin($email, $password)) {
		    		// Getting database connection in class DB
		    		$conn = DB::getInstance();

		    		// Query for getting the user
					$statement = $conn->prepare("SELECT * FROM users WHERE email = :email");
					$statement->bindParam(":email", $this->email);
					$statement->execute();
					$user = $statement->fetch(PDO::FETCH_ASSOC);

					// Checking if password is the same as database password
					if(password_verify($this->password, $user['password'])) {
						// Password is the same => return true
						return true;
					}
					// Password isn't the same => return false
					$_SESSION["errors"] = "Error: Something went wrong! Try again later.";
					return false;
				}
	    	} catch(Throwable $t) {
	    		// If database connection fails
	    		$_SESSION["errors"] = "Error: " . $t;
	    		return false;
	    	}
	    }

	    /**
	     * @return boolean
	     * true if registering is successful
	     * false if registering is unsuccessful 
	     */
	    public function register() {
	    	try {
	    		require_once("RegisterChecks.php");
	    		//Hash password
		    	$password = pwHash($this->password);

	    		if (canRegister($this->firstname, $this->lastname, $this->username, $this->email, $this->password, $this->confirmPassword)) {
	    			// Getting database connection in class DB
		    		$conn = DB::getInstance();

		    		// Query for adding the user
					$statement = $conn->prepare("INSERT INTO users (firstname, lastname, username, email, password) VALUES (:firstname, :lastname, :username, :email, :password)");
					$statement->bindParam(":firstname", $this->firstname);
					$statement->bindParam(":lastname", $this->lastname);
					$statement->bindParam(":username", $this->username);
					$statement->bindParam(":email", $this->email);
					$statement->bindParam(":password", $this->password);
					// Chacking if user is succesfully added to the database
					if($statement->execute()) {
						// User is successfully added => return true
						return true;
					}
					// Failed to add user => return false
					$_SESSION["errors"] = "Error: Something went wrong! Try again later.";
					return false;
	    		}
	    	} catch(Throwable $t) {
	    		// If database connection fails
	    		$_SESSION["errors"] = "Error: " . $t;
	    		return false;
	    	}
	    }
	}