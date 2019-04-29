<?php
    /**
	 * UpdatePassword class
	 * @return boolean
	 * true if security is successful
	 * false if security is unsuccessful 
	 */
    class UpdatePassword extends RegisterSecurity {
        public function canUpdatePassword($pw1, $pw2, $pw3) {
            $_SESSION["errors"]["title"] = "Updating Password Failed:";
			$_SESSION["errors"]["message"] = "";

            // Check if fields are empty
			if (!$this->emptyFields($pw1, $pw2, $pw3)) {
				$_SESSION["errors"]["message"] .= "<li>All fields are required to fill in!</li>";
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

        private function emptyFields($pw1, $pw2, $pw3) {
			if (empty($pw1) || empty($pw2) || empty($pw3)) {
				return false;
			}
			return true;
		}
    }
