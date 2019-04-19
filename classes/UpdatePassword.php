<?php
    /**
	 * UpdatePassword class
	 * @return boolean
	 * true if security is successful
	 * false if security is unsuccessful 
	 */
    class UpdatePassword extends RegisterSecurity {
        public function canUpdatePassword($pw1, $pw2, $pw3) {
            $_SESSION["errors"] = "";

            // Check if fields are empty
			if (!$this->emptyFields($pw1, $pw2, $pw3)) {
				$_SESSION["errors"] .= "<li>All fields are required to fill in!</li>";
            }
            
            // Check if password contains 7 characters
			if (!$this->isPasswordSecure($pw2)) {
				$_SESSION["errors"] .= "<li>Your password needs to contain at least 7 characters!</li>";
			}

			// Check if password is same as confirm password
			if (!$this->isEqual($pw2, $pw3)) {
				$_SESSION["errors"] .= "<li>Your confirm password doesn't match with your password!</li>";
			}

			// Check if password contains at least one number
			if (!$this->containNumber($pw2)) {
		        $_SESSION["errors"] .= "<li>Password must include at least one number!</li>";
		    }

		    // Check if password contains at least one letter
		    if (!$this->containLetter($pw2)) {
		    	$_SESSION["errors"] .= "<li>Password must include at least one letter!</li>";
		    }

		    // Check if password contains at least one uppercase 
		    if (!$this->containUppercase($pw2)) {
		    	$_SESSION["errors"] .= "<li>Password must include at least one uppercase!</li>";
		    }

			if (!empty($_SESSION["errors"])) {
				return false;
			}
			return true;
        }

        private function emptyFields($pw2, $pw3) {
			if (empty($pw2) || empty($pw3)) {
				return false;
			}
			return true;
        }
        
        private function isPasswordSecure($pw2) {
			if (strlen($pw2) < 7) {
				return false;
			}
			return true;
		}

		private function isEqual($pw2, $pw3) {
            if ($pw2 != $pw3) {
				return false;
			}
			return true;
		}

		private function containNumber($pw2) {
			if (!preg_match("#[0-9]+#", $pw2)) {
				return false;
			}
			return true;
		}

		private function containLetter($pw2) {
			if (!preg_match("#[a-zA-Z]+#", $pw2)) {
				return false;
		    }
		    return true;
		}

		private function containUppercase($pw2) {
			if(!preg_match('/[A-Z]/', $pw2)){
				return false;
			}
			return true;
		}
    }
