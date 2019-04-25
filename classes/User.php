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
		private $description;

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
	     * @return mixed
	     */
	    public function getDescription() {
	    	return $this->description;
	    }

	    /**
	     * @param mixed $description
	     *
	     * @return self
	     */
	    public function setDescription($description) {
	    	$this->description = $description;

	    	return $this;
	    }

	    /**
	     * @return boolean
	     * true if logging in is successful
	     * false if logging in is unsuccessful 
	     */
	    public function login() {
	    	try {
	    		$security = new LoginSecurity;
	    		if($security->canLogin($this->email, $this->password)) {
		    		// Getting database connection in class DB
	    			$conn = DB::getInstance();

		    		// Query for getting the user
	    			$statement = $conn->prepare("SELECT * FROM users WHERE email = :email");
	    			$statement->bindParam(":email", $this->email);
	    			$statement->execute();
	    			$user = $statement->fetch(PDO::FETCH_ASSOC);

					// Checking if password is the same as database password
	    			if(LoginSecurity::pwVerify($this->password, $user["password"])) {
	    				// Getting al details of the user
	    				$this->getDetails($user);
						// Password is the same => return true
	    				return true;
	    			}
					// Password isn't the same => return false
	    			$_SESSION["errors"]["message"] = "<li>Your password was incorrect.</li>";
	    			return false;
	    		}
	    	} catch(Throwable $t) {
	    		// If database connection fails
	    		$_SESSION["errors"]["message"] = "<li>".$t."<li>";
	    		return false;
	    	}
	    }

	    private function getDetails($user) {
	    	$userDetails = [
	    		"id" => $user["id"],
	    		"firstname" => $user["firstname"],
	    		"lastname" => $user["lastname"],
	    		"email" => $user["email"],
	    		"username" =>  $user["username"],
	    		"profile_pic" =>  $user["profile_pic"]
	    	];
	    	$_SESSION["user"] = $userDetails;
	    }

	    /**
	     * @return boolean
	     * true if registering is successful
	     * false if registering is unsuccessful 
	     */
	    public function register() {
	    	try {
	    		$security = new RegisterSecurity;
	    		if ($security->canRegister($this->firstname, $this->lastname, $this->username, $this->email, $this->password, $this->confirmPassword)) {

	    			//Hash password
	    			$password = RegisterSecurity::pwHash($this->password);

	    			// Getting database connection in class DB
	    			$conn = DB::getInstance();

		    		// Query for adding the user
	    			$statement = $conn->prepare("INSERT INTO users (firstname, lastname, username, email, password, profile_pic, background_pic, active) VALUES (:firstname, :lastname, :username, :email, :password, :profile_pic, :background_pic, 1)");
	    			$statement->bindParam(":firstname", $this->firstname);
	    			$statement->bindParam(":lastname", $this->lastname);
	    			$statement->bindParam(":username", $this->username);
	    			$statement->bindParam(":email", $this->email);
	    			$statement->bindParam(":password", $password);
	    			$statement->bindParam(":profile_pic", "standerd.jpg");
	    			$statement->bindParam(":background_pic", "standerd.jpg");
					// Checking if user is succesfully added to the database
	    			if($statement->execute()) {
						// User is successfully added => return true
	    				return true;
	    			}
					// Failed to add user => return false
	    			$_SESSION["errors"]["message"] = "<li> Something went wrong! Try again later.</li>";
	    			return false;
	    		}
	    	} catch(Throwable $t) {
	    		// If database connection fails
	    		$_SESSION["errors"]["message"] = "<li>".$t."<li>";
	    		return false;
	    	}
	    }

	    public function updateDescription() {
	    	try {
	    		$_SESSION["errors"]["title"] = "Updated Description:";
	    		$_SESSION["errors"]["message"] = "";

	    		$conn = DB::getInstance();
	    		$statement = $conn->prepare("UPDATE users SET description = :description WHERE id = :id");
	    		$statement->bindParam(":id", $_SESSION["user"]["id"]);
	    		$statement->bindParam(":description", $this->description);
	    		$user = $statement->fetch(PDO::FETCH_ASSOC);

	    		if ($statement->execute()) {
	    			$_SESSION["errors"]["message"] = "Description succesfully updated";
	    			return true;
	    		}

	    	} catch (Throwable $t) {
	    		$_SESSION["errors"]["title"] = "Update Description Failed:";
	    		$_SESSION["errors"]["message"] = "Error: " . $t;
	    		return false;
	    	}
	    }
	}