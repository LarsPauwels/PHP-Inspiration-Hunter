<?php
	/**
	 * 
	 */
	class Validation {
		private $data;
		private $rules;

		/**
	     * @return mixed
	     */
	    public function getData() {
	        return $this->data;
	    }

	    /**
	     * @param mixed $data
	     *
	     * @return self
	     */
	    public function setData($data) {
	        $this->data = $data;

	        return $this;
	    }

	    /**
	     * @return mixed
	     */
	    public function getRules() {
	        return $this->rules;
	    }

	    /**
	     * @param mixed $rules
	     *
	     * @return self
	     */
	    public function setRules($rules) {
	        $this->rules = $rules;

	        return $this;
	    }

		public function isValid() {
			$_SESSION["errors"]["title"] = "Validation Failed:";
			$_SESSION["errors"]["message"] = "";

			$i = 0;
			foreach ($this->rules as $key => $rule) {
				foreach ($rule as $func) {
					if ($this->$func($this->data[$key])) {
						$validdation[$i] = true;
					} else {
						$validdation[$i] = false;
					}
				}

				$i++;
			}

			if (count(array_unique($validdation)) == 1 && end($validdation) == 1) {
				return true;
			}
			return false;
		}
		
		private function emptyFields($value) {
			if (empty($value)) {
				$_SESSION["errors"]["message"] .= "<li>All fields are required to fill in!</li>";
				return false;
			}
			return true;
		}

		private function validEmail($email) {
			if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
				$_SESSION["errors"]["message"] .= "<li>Your email is not a valid one!</li>";
				return false;
			}
			return true;
		}

		private function usernameExists($username) {
			$conn = DB::getInstance();
			$statement = $conn->prepare("SELECT * FROM users WHERE username = :username");
			$statement->bindParam(":username", $username);
			$statement->execute();

			if ($statement->rowCount() >= 1) {
				$_SESSION["errors"]["message"] .= "<li>This username is already in use!</li>";
				return false;
			}
			return true;
		}

		private function emailExists($email) {
			$conn = DB::getInstance();
			$statement = $conn->prepare("SELECT * FROM users WHERE email = :email");
			$statement->bindParam(":email", $email);
			$statement->execute();

			if ($statement->rowCount() >= 1) {
				$_SESSION["errors"]["message"] .= "<li>This email is already in use!</li>";
				return false;
			}
			return true;
		}

		private function isEqual($pw) {
			if ($pw != $this->data["passwordConfirm"]) {
				$_SESSION["errors"]["message"] .= "<li>Your confirm password doesn't match with your password!</li>";
				return false;
			}
			return true;
		}

		private function isEqualDatabase($pw) {
			$conn = DB::getInstance();

			$statement = $conn->prepare("SELECT * FROM users WHERE email = :email");
	    	$statement->bindParam(":email", $_SESSION["user"]["email"]);
	    	$statement->execute();
	    	$user = $statement->fetch(PDO::FETCH_ASSOC);

	    	if(!Security::pwVerify($pw, $user["password"])) {
				// Password is the same => return true
	    		return true;
	    	}
			$_SESSION["errors"]["message"] = "<li>You can't have the same password as your old one.</li>";
			return false;
		}

		public function checkPassword($email, $pw) {
			// Getting database connection in class DB
			$conn = DB::getInstance();
			// Query for getting the user
	    	$statement = $conn->prepare("SELECT * FROM users WHERE email = :email");
	    	$statement->bindParam(":email", $email);
	    	$statement->execute();
	    	$user = $statement->fetch(PDO::FETCH_ASSOC);

	    	// Checking if password is the same as database password
	    	if(Security::pwVerify($pw, $user["password"])) {
				// Password is the same => return true
	    		return true;
	    	}
	    	// Password isn't the same => return false
	    	$_SESSION["errors"]["message"] = "<li>Your email or password is incorrect.</li>";
	    	return false;
		} 

		private function checkSize($fileSize) {
	    	if ($fileSize < 10000000) { //if filezize is less than 100 mb
	    		return true;
	    	}
	    	$_SESSION["errors"]["message"] .= "<li>Your file is too big!</li>";	
	    	return false;
	    }

	    private function checkErrors($fileError) {
	    	if ($fileError === 0) { //if theres no error
	    		return true;
	    	}
	    	$_SESSION["errors"]["message"] .= "<li>There was an error uploading your file!</li>";
	    	return false;
	    }

	    private function checkExtensionImage($FileName) {
	    	//Explode function to get the extension, this to allow certain extensions and others not
	    	$fileActualExt = File::getExtension($FileName);
			$allowed = array('jpg', 'jpeg', 'png'); //Different types of extensions that are allowed

			if (in_array($fileActualExt, $allowed)) { //if the extension is allowed then...
				return true;
			}
			$_SESSION["errors"]["message"] .= "<li>You cannot upload this type of file!</li>";
			return false;
		}
	}