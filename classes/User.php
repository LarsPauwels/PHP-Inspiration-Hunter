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
		private $oldPassword;
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
	    public function getOldPassword() {
	    	return $this->oldPassword;
	    }

	    /**
	     * @param mixed $oldPassword
	     *
	     * @return self
	     */
	    public function setOldPassword($oldPassword) {
	    	$this->oldPassword = $oldPassword;

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
	    		$data = [
	    			"email" => $this->email, 
	    			"password" => $this->password
	    		];

	    		$rules = [
	    			"email" => [
	    				"emptyFields",
	    				"validEmail"
	    			],
	    			"password" => [
	    				"emptyFields"
	    			]
	    		];

	    		$validation = new Validation;
	    		$validation->setData($data);
	    		$validation->setRules($rules);
	    		if($validation->isValid()) {
	    			if(Validation::checkPassword($this->email, $this->password)) {
	    				$this->setDetails();
	    				$this->setOnline(1);
	    				return true;
	    			}
	    			return false;
	    		}
	    	} catch(Throwable $t) {
	    		// If database connection fails
	    		$_SESSION["errors"]["message"] = "<li>".$t."<li>";
	    		return false;
	    	}
	    }

	    private function setDetails() {
	    	// Getting database connection in class DB
	    	$conn = DB::getInstance();
			// Query for getting the user
	    	$statement = $conn->prepare("SELECT * FROM users WHERE email = :email");
	    	$statement->bindParam(":email", $this->email);
	    	$statement->execute();
	    	$user = $statement->fetch(PDO::FETCH_ASSOC);

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

	    private function setOnline($status) {
	    	$conn = DB::getInstance();
			// Query for getting the user
	    	$statement = $conn->prepare("UPDATE users SET online = :status WHERE id = :id");
	    	$statement->bindParam(":status", $status);
	    	$statement->bindParam(":id", $_SESSION["user"]["id"]);
	    	$statement->execute();
	    }

	    /**
	     * @return boolean
	     * true if registering is successful
	     * false if registering is unsuccessful 
	     */
	    public function register() {
	    	try {
	    		$data = [
	    			"firstname" => $this->firstname, 
	    			"lastname" => $this->lastname, 
	    			"username" => $this->username, 
	    			"email" => $this->email,
	    			"password" => $this->password, 
	    			"passwordConfirm" => $this->confirmPassword
	    		];

	    		$rules = [
	    			"firstname" => [
	    				"emptyFields"
	    			],
	    			"lastname" => [
	    				"emptyFields"
	    			],
	    			"username" => [
	    				"emptyFields",
	    				"usernameExists"
	    			],
	    			"email" => [
	    				"emptyFields",
	    				"validEmail",
	    				"emailExists"
	    			],
	    			"password" => [
	    				"emptyFields",
	    				"isEqual"
	    			],
	    			"passwordConfirm" => [
	    				"emptyFields"
	    			]
	    		];

	    		$validation = new Validation;
	    		$validation->setData($data);
	    		$validation->setRules($rules);
	    		if ($validation->isValid()) {

	    			$rules = [
	    				"password" => [
	    					"isPasswordSecure",
	    					"containNumber",
	    					"containLetter",
	    					"containUppercase"
	    				]
	    			];

	    			$security = new Security;
	    			$security->setData($data);
	    			$security->setRules($rules);
	    			if ($security->isSecure()) {
		    			//Hash password
	    				$password = Security::pwHash($this->password);
	    				$image = "standerd.jpg";

		    			// Getting database connection in class DB
	    				$conn = DB::getInstance();

			    		// Query for adding the user
	    				$statement = $conn->prepare("INSERT INTO users (firstname, lastname, username, email, password, profile_pic, background_pic, active) VALUES (:firstname, :lastname, :username, :email, :password, :profile_pic, :background_pic, 1)");
	    				$statement->bindParam(":firstname", $this->firstname);
	    				$statement->bindParam(":lastname", $this->lastname);
	    				$statement->bindParam(":username", $this->username);
	    				$statement->bindParam(":email", $this->email);
	    				$statement->bindParam(":password", $password);
	    				$statement->bindParam(":profile_pic", $image);
	    				$statement->bindParam(":background_pic", $image);
						// Checking if user is succesfully added to the database
	    				if($statement->execute()) {
							// User is successfully added => return true
							$this->setDetails();
	    					return true;
	    				}
						// Failed to add user => return false
	    				$_SESSION["errors"]["message"] = "<li> Something went wrong! Try again later.</li>";
	    				return false;
	    			}
	    		}
	    	} catch(Throwable $t) {
	    		// If database connection fails
	    		$_SESSION["errors"]["message"] = "<li>".$t."<li>";
	    		return false;
	    	}
	    }

	    public function logout() {
	    	session_destroy();
	    	$this->setOnline(0);
	    }

	    public function updateDescription() {
	    	try {
	    		$data = [
	    			"description" => $this->description
	    		];

	    		$rules = [
	    			"description" => [
	    				"emptyFields"
	    			]
	    		];

	    		$validation = new Validation;
	    		$validation->setData($data);
	    		$validation->setRules($rules);
	    		if ($validation->isValid()) {
	    			$conn = DB::getInstance();
	    			$statement = $conn->prepare("UPDATE users SET description = :description WHERE id = :id");
	    			$statement->bindParam(":id", $_SESSION["user"]["id"]);
	    			$statement->bindParam(":description", $this->description);
	    			$statement->execute();
	    			return true;
	    		}
	    		return false;

	    	} catch (Throwable $t) {
	    		$_SESSION["errors"]["message"] = "Error: " . $t;
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
	    		$data = [
	    			"email" => $this->email,
	    			"password" => $this->password
	    		];

	    		$rules = [
	    			"email" => [
	    				"emptyFields",
	    				"validEmail"
	    			],
	    			"password" => [
	    				"emptyFields",
	    			]
	    		];

	    		$validation = new Validation;
	    		$validation->setData($data);
	    		$validation->setRules($rules);
	    		if ($validation->isValid()) {
					// check if entered password is the right password
	    			if (Validation::checkPassword($_SESSION["user"]["email"], $this->password)) {
	    				$conn = DB::getInstance();
	    				$statement = $conn->prepare("UPDATE users SET email = :email WHERE id = :id");
	    				$statement->bindParam(":id", $_SESSION["user"]["id"]);
	    				$statement->bindParam(":email", $this->email);
	    				$statement->execute();

	    				$_SESSION["user"]["email"] = $this->email;
	    				return true;
	    			}
	    			return false;
	    		}
	    	} catch (Throwable $t) {
	    		$_SESSION["errors"]["message"] = "Error: " . $t;
	    		return false;
	    	}
	    }

	    public function updatePassword() {
	    	try {
	    		if (Validation::checkPassword($_SESSION["user"]["email"], $this->oldPassword)) {
	    			$data = [
	    				"oldPassword" => $this->oldPassword,
	    				"password" => $this->password,
	    				"passwordConfirm" => $this->confirmPassword
	    			];

	    			$rules = [
	    				"oldPassword" => [
	    					"emptyFields"
	    				],
	    				"password" => [
	    					"emptyFields",
	    					"isEqual",
	    					"isEqualDatabase"
	    				],
	    				"passwordConfirm" => [
	    					"emptyFields"
	    				]
	    			];

	    			$validation = new Validation;
	    			$validation->setData($data);
	    			$validation->setRules($rules);
	    			if ($validation->isValid()) {
	    				$rules = [
	    					"password" => [
	    						"isPasswordSecure",
	    						"containNumber",
	    						"containLetter",
	    						"containUppercase"
	    					]
	    				];

	    				$security = new Security;
	    				$security->setData($data);
	    				$security->setRules($rules);
	    				if ($security->isSecure()) {
					    	//Hash password
	    					$password = Security::pwHash($this->password);
	    					$conn = DB::getInstance();
	    					$stmnt = $conn->prepare("UPDATE users SET password = :password WHERE id = :id");
	    					$stmnt->bindParam(":password", $password);
	    					$stmnt->bindParam(":id", $_SESSION["user"]["id"]);
	    					$stmnt->execute();

	    					return true;
	    				}
	    				return false;
	    			}
	    			return false;
	    		}
	    	} catch (Throwable $t) {
	    		$_SESSION["errors"]["message"] = "Error: " . $t;
	    		return false;
	    	}
	    }

	    public function updateProfilePic() {
	    	$image = str_replace("uploads/profile_pic/", "", $_SESSION["path"]);

	    	try {
	    		$conn = DB::getInstance();

	    		$statement = $conn->prepare("UPDATE users SET profile_pic = :image WHERE id = :id");
	    		$statement->bindParam(":image", $image);
	    		$statement->bindParam(":id", $_SESSION["user"]["id"]);
	    		if ($statement->execute()) {
	    			$_SESSION["user"]["profile_pic"] = $image;
	    		}
	    	} catch (Throwable $t) {
	    		$_SESSION["errors"]["message"] = "Error: " . $t;
	    		return false;
	    	}
	    }

	    public static function getUser($user) {
	    	try {
	    		$conn = DB::getInstance();

	    		$statement = $conn->prepare("SELECT * FROM users WHERE username = :user");
	    		$statement->bindParam(":user", $user);
	    		$statement->execute();
	    		$user = $statement->fetch(PDO::FETCH_ASSOC);
	    		$_SESSION["userDetails"] = $user;
	    	} catch (Throwable $t) {
	    		$_SESSION["errors"]["message"] = "Error: " . $t;
	    		return false;
	    	}
	    }

	    public static function getFollowers($user) {
	    	try {
	    		$conn = DB::getInstance();

	    		$statement = $conn->prepare("SELECT count(*) AS count FROM followers, users WHERE users.id = followers.following AND users.username = :user");
	    		$statement->bindParam(":user", $user);
	    		$statement->execute();
	    		$result = $statement->fetch(PDO::FETCH_ASSOC);

	    		return Number::transform($result["count"]);
	    	} catch (Throwable $t) {
	    		$_SESSION["errors"]["message"] = "Error: " . $t;
	    		return false;
	    	}
	    }

	    public static function getFollowing($user) {
	    	try {
	    		$conn = DB::getInstance();

	    		$statement = $conn->prepare("SELECT count(*) AS count FROM followers, users WHERE users.id = followers.follower AND users.username = :user");
	    		$statement->bindParam(":user", $user);
	    		$statement->execute();
	    		$result = $statement->fetch(PDO::FETCH_ASSOC);

	    		return Number::transform($result["count"]);
	    	} catch (Throwable $t) {
	    		$_SESSION["errors"]["message"] = "Error: " . $t;
	    		return false;
	    	}
	    }
	}