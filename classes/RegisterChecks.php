<?php
	/* VALIDATE REGISTER FORM */
	function canRegister($firstname, $lastname, $username, $email, $pw1, $pw2) {
		$_SESSION["errors"] = "";

		// Check if fields are empty
		if (!emptyFields($firstname, $lastname, $username, $email, $pw1, $pw2)) {
			$_SESSION["errors"] .= "<li>All fields are required to fill in!</li>";
		}

		// Check if email is valid
		if (!validEmail($email)) {
			$_SESSION["errors"] .= "<li>Your email is not a valid one!</li>";
		}

		// Check if username already exists
		if (!usernameExists($username)) {
			$_SESSION["errors"] .= "<li>This username is already in use!</li>";
		}

		// Check if email already exists
		if (!emailExists($email)) {
			$_SESSION["errors"] .= "<li>This email is already in use!</li>";
		}

		// Check if password contains 7 characters
		if (!isPasswordSecure($pw1)) {
			$_SESSION["errors"] .= "<li>Your password needs to contain at least 7 characters!</li>";
		}

		// Check if password is same as confirm password
		if (!isEqual($pw1, $pw2)) {
			$_SESSION["errors"] .= "<li>Your confirm password doesn't match with your password!</li>";
		}

		// Check if password contains at least one number
		if (!containNumber($pw1)) {
	        $_SESSION["errors"] .= "<li>Password must include at least one number!</li>";
	    }

	    // Check if password contains at least one letter
	    if (!containLetter($pw1)) {
	    	$_SESSION["errors"] .= "<li>Password must include at least one letter!</li>";
	    }

	    // Check if password contains at least one uppercase 
	    if (!containUppercase($pw1)) {
	    	$_SESSION["errors"] .= "<li>Password must include at least one uppercase!</li>";
	    }

		if (!empty($_SESSION["errors"])) {
			return false;
		}
		return true;
	}

	function emptyFields($firstname, $lastname, $username, $email, $pw1, $pw2) {
		if (empty($username) || empty($lastname) || empty($firstname) || empty($email) || empty($pw1) || empty($pw2)) {
			return false;
		}
		return true;
	}

	function validEmail($email) {
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			return false;
		}
		return true;
	}

	function usernameExists($username) {
		$conn = DB::getInstance();
		$statement = $conn->prepare("SELECT * FROM users WHERE username = :username");
		$statement->bindParam(":username", $username);
		$statement->execute();

		if ($statement->rowCount() >= 1) {
			return false;
		}
		return true;
	}

	function emailExists($email) {
		$conn = DB::getInstance();
		$statement = $conn->prepare("SELECT * FROM users WHERE email = :email");
		$statement->bindParam(":email", $email);
		$statement->execute();

		if ($statement->rowCount() >= 1) {
			return false;
		}
		return true;
	}

	function isPasswordSecure($pw) {
		if (strlen($pw) < 7) {
			return false;
		}
		return true;
	}

	function isEqual($pw1, $pw2) {
		if ($pw1 != $pw2) {
			return false;
		}
		return true;
	}

	function containNumber($pw) {
		if (!preg_match("#[0-9]+#", $pw)) {
			return false;
		}
		return true;
	}

	function containLetter($pw) {
		if (!preg_match("#[a-zA-Z]+#", $pw)) {
			return false;
	    }
	    return true;
	}

	function containUppercase($pw) {
		if(!preg_match('/[A-Z]/', $pw)){
			return false;
		}
		return true;
	}

	/* TRANSFORM PASSWORD TO HASH */
	function pwHash($pw) {
		$options = [
		    'cost' => 12,
		];
		return password_hash($pw, PASSWORD_BCRYPT, $options);
	}