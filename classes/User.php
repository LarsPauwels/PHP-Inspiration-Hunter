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
		private $currentPassword;

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
	     * @return mixed
	     */
	    public function getCurrentPassword() {
	        return $this->currentPassword;
	    }

	    /**
	     * @param mixed $currentPassword
	     *
	     * @return self
	     */
	    public function setCurrentPassword($currentPassword) {
	        $this->currentPassword = $currentPassword;

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

					print_r($user);

					// Checking if password is the same as database password
					if(LoginSecurity::pwVerify($this->password, $user["password"])) {
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
		    	$security = new RegisterSecurity;
	    		if ($security->canRegister($this->firstname, $this->lastname, $this->username, $this->email, $this->password, $this->confirmPassword)) {

	    			//Hash password
			    	$password = RegisterSecurity::pwHash($this->password);

	    			// Getting database connection in class DB
		    		$conn = DB::getInstance();

		    		// Query for adding the user
					$statement = $conn->prepare("INSERT INTO users (firstname, lastname, username, email, password) VALUES (:firstname, :lastname, :username, :email, :password)");
					$statement->bindParam(":firstname", $this->firstname);
					$statement->bindParam(":lastname", $this->lastname);
					$statement->bindParam(":username", $this->username);
					$statement->bindParam(":email", $this->email);
					$statement->bindParam(":password", $password);
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

		public function updateDescription() {
			try {
				$conn = DB::getInstance();

				$statement = $conn->prepare("UPDATE users SET description = :description WHERE id = 2");
				$statement->bindParam(":description", $this->description);
				$user = $statement->fetch(PDO::FETCH_ASSOC);

				if ($statement->execute()) {
					return true;
				}

			} catch (Throwable $t) {
				$_SESSION["errors"] = "Error: " . $t;
				return false;
			}
		}
		
		/**
	     * @return boolean
	     * true if updaten email is successful
	     * false if updaten email is unsuccessful 
	     */
		public function updateEmail() {
			try {
				$security = new LoginSecurity;

				// check if email is a valid email and no empty fields allowed
				if ($security->canLogin($this->email, $this->password)) {

					// Connect to db
					$conn = DB::getInstance();

					// Query to select user
					$statement = $conn->prepare("SELECT * FROM users WHERE id = 2");
					// $statement->bindParam(":email", $this->email);
					// $statement->bindParam(":password", $password);
					$statement->execute();
					$user = $statement->fetch(PDO::FETCH_ASSOC);

					// print_r($user);
					// $pwuser = $user["password"];
					$emailUser = $user["email"];
					// print_r($pwuser);
					// print_r($emailUser);

					// check if entered password is the right password
					if (LoginSecurity::pwVerify($this->password, $user["password"])) {
						$stmnt = $conn->prepare("UPDATE users SET email = :email WHERE email = '$emailUser'");
						$stmnt->bindParam(":email", $this->email);
						$stmnt->execute();
						return true;
					}

					$_SESSION["errors"] = "Error: Something went wrong! Try again later.";
					return false;

				}

				
			} catch (Throwable $t) {
				$_SESSION["errors"] = "Error: " . $t;
				return false;
			}
		}

		public function updatePassword() {
			try {
				
				$security = new UpdatePassword;
				if ($security->canUpdatePassword($this->currentPassword, $this->password, $this->confirmPassword)) {
					$conn = DB::getInstance();
					$statement = $conn->prepare("SELECT * FROM users WHERE id = 2");
					$statement->execute();
					$user = $statement->fetch(PDO::FETCH_ASSOC);

					print_r($user);
					$emailUser = $user["email"];

					//Hash password
			    	$password = RegisterSecurity::pwHash($this->password);

					if (LoginSecurity::pwVerify($this->currentPassword, $user["password"])) {
						$stmnt = $conn->prepare("UPDATE users SET password = '$password' WHERE email = '$emailUser'");
						$stmnt->bindParam(":password", $password);
						$stmnt->execute();
						return true;
					}

					$_SESSION["errors"] = "Error: Something went wrong! Try again later.";
					return false;

				}


			} catch (Throwable $t) {
				$_SESSION["errors"] = "Error: " . $t;
				return false;
			}
		}
	}