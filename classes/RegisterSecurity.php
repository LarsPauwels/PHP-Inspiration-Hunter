<?php
	/**
	 * Register Security class
	 * @return boolean
	 * true if security is successful
	 * false if security is unsuccessful 
	 */
	class RegisterSecurity extends LoginSecurity {

		public function canRegister($firstname, $lastname, $username, $email, $pw1, $pw2) {
			$_SESSION["errors"]["title"] = "Registration Failed:";
			$_SESSION["errors"]["message"] = "";

			// Check if fields are empty
			if (!$this->emptyFields($firstname, $lastname, $username, $email, $pw1, $pw2)) {
				$_SESSION["errors"]["message"] .= "<li>All fields are required to fill in!</li>";
			}

			// Check if email is valid
			if (!$this->validEmail($email)) {
				$_SESSION["errors"]["message"] .= "<li>Your email is not a valid one!</li>";
			}

			// Check if username already exists
			if (!$this->usernameExists($username)) {
				$_SESSION["errors"]["message"] .= "<li>This username is already in use!</li>";
			}

			// Check if email already exists
			if (!$this->emailExists($email)) {
				$_SESSION["errors"]["message"] .= "<li>This email is already in use!</li>";
			}

			// Check if password contains 7 characters
			if (!$this->isPasswordSecure($pw1)) {
				$_SESSION["errors"]["message"] .= "<li>Your password needs to contain at least 7 characters!</li>";
			}

			// Check if password is same as confirm password
			if (!$this->isEqual($pw1, $pw2)) {
				$_SESSION["errors"]["message"] .= "<li>Your confirm password doesn't match with your password!</li>";
			}

			// Check if password contains at least one number
			if (!$this->containNumber($pw1)) {
		        $_SESSION["errors"]["message"] .= "<li>Password must include at least one number!</li>";
		    }

		    // Check if password contains at least one letter
		    if (!$this->containLetter($pw1)) {
		    	$_SESSION["errors"]["message"] .= "<li>Password must include at least one letter!</li>";
		    }

		    // Check if password contains at least one uppercase 
		    if (!$this->containUppercase($pw1)) {
		    	$_SESSION["errors"]["message"] .= "<li>Password must include at least one uppercase!</li>";
		    }

			if (!empty($_SESSION["errors"]["message"])) {
				return false;
			}
			return true;
		}

		private function emptyFields($firstname, $lastname, $username, $email, $pw1, $pw2) {
			if (empty($username) || empty($lastname) || empty($firstname) || empty($email) || empty($pw1) || empty($pw2)) {
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
				return false;
			}
			return true;
		}

		public function isPasswordSecure($pw) {
			if (strlen($pw) < 7) {
				return false;
			}
			return true;
		}

		public function isEqual($pw1, $pw2) {
			if ($pw1 != $pw2) {
				return false;
			}
			return true;
		}

		public function containNumber($pw) {
			if (!preg_match("#[0-9]+#", $pw)) {
				return false;
			}
			return true;
		}

		public function containLetter($pw) {
			if (!preg_match("#[a-zA-Z]+#", $pw)) {
				return false;
		    }
		    return true;
		}

		public function containUppercase($pw) {
			if(!preg_match('/[A-Z]/', $pw)){
				return false;
			}
			return true;
		}

		/* TRANSFORM PASSWORD TO HASH */
		public static function pwHash($pw) {
			$options = [
			    'cost' => 12,
			];
			return password_hash($pw, PASSWORD_BCRYPT, $options);
		}
	}