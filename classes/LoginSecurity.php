<?php
	/**
	 * Login Security class
	 * @return boolean
	 * true if security is successful
	 * false if security is unsuccessful 
	 */
	class LoginSecurity {
		/* VALIDATE LOGIN FORM */
		public function canLogin($email, $pw) {
			$_SESSION["errors"] = "";

			if (!$this->emptyFields($email, $pw)) {
				$_SESSION["errors"] .= "<li>All fields are required to fill in!</li>";
			}

			if (!$this->validEmail($email)) {
				$_SESSION["errors"] .= "<li>Your email is not a valid one!</li>";
			}

			if (!empty($_SESSION["errors"])) {
				return false;
			}
			return true;
		}

		private function emptyFields($email, $pw) {
			if (empty($email) || empty($pw)) {
				return false;
			}
			return true;
		}

		public function validEmail($email) {
			if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
				return false;
			}
			return true;
		}

		public static function pwVerify($pw, $pwDatabse) {
			if (password_verify($pw, $pwDatabse)) {
				return true;
			}
			return false;
		}
	}