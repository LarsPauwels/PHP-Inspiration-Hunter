<?php
	/* VALIDATE LOGIN FORM */
	function canLogin($email, $pw) {
		$_SESSION["errors"] = "";

		if (!emptyFields($email, $pw)) {
			$_SESSION["errors"] .= "<li>All fields are required to fill in!</li>";
		}

		if (!validEmail($email)) {
			$_SESSION["errors"] .= "<li>Your email is not a valid one!</li>";
		}

		if (!empty($_SESSION["errors"])) {
			return false;
		}
		return true;
	}

	function emptyFields($email, $pw) {
		if (empty($email) || empty($pw)) {
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