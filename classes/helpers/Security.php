<?php
	/**
	 * 
	 */
	class Security {
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

		public function isSecure() {
			$_SESSION["errors"]["title"] = "Security Failed:";
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

		private function isPasswordSecure($pw) {
			if (strlen($pw) < 7) {
				$_SESSION["errors"]["message"] .= "<li>Your password needs to contain at least 7 characters!</li>";
				return false;
			}
			return true;
		}
		
		private function containNumber($pw) {
			if (!preg_match("#[0-9]+#", $pw)) {
				$_SESSION["errors"]["message"] .= "<li>Password must include at least one number!</li>";
				return false;
			}
			return true;
		}

		private function containLetter($pw) {
			if (!preg_match("#[a-zA-Z]+#", $pw)) {
				$_SESSION["errors"]["message"] .= "<li>Password must include at least one letter!</li>";
				return false;
		    }
		    return true;
		}

		private function containUppercase($pw) {
			if(!preg_match('/[A-Z]/', $pw)){
				$_SESSION["errors"]["message"] .= "<li>Password must include at least one uppercase!</li>";
				return false;
			}
			return true;
		}

		public static function pwHash($pw) {
			$options = [
			    'cost' => 12,
			];
			return password_hash($pw, PASSWORD_BCRYPT, $options);
		}

		public static function pwVerify($pw, $pw2) {
			if (password_verify($pw, $pw2)) {
				return true;
			}
			return false;
		}
	}