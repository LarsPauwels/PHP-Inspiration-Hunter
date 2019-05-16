<?php

	/**
	 * 
	 */
	class Location {
		private $country;
		private $postcode;
		private $streetname;
		private $town;
		private $lat;
		private $lng;

		/**
	     * @return mixed
	     */
		public function getCountry() {
			return $this->country;
		}

	    /**
	     * @param mixed $file
	     *
	     * @return self
	     */
	    public function setCountry($country) {
	    	$this->country = $country;

	    	return $this;
	    }

	    /**
	     * @return mixed
	     */
	    public function getPostcode() {
	    	return $this->postcode;
	    }

	    /**
	     * @param mixed $postcode
	     *
	     * @return self
	     */
	    public function setPostcode($postcode) {
	    	$this->postcode = $postcode;

	    	return $this;
	    }

	    /**
	     * @return mixed
	     */
	    public function getStreetname() {
	    	return $this->streetname;
	    }

	    /**
	     * @param mixed $file
	     *
	     * @return self
	     */
	    public function setStreetname($streetname) {
	    	$this->streetname = $streetname;

	    	return $this;
	    }

	    /**
	     * @return mixed
	     */
	    public function getTown() {
	    	return $this->town;
	    }

	    /**
	     * @param mixed $file
	     *
	     * @return self
	     */
	    public function setTown($town) {
	    	$this->town = $town;

	    	return $this;
	    }

	    /**
	     * @return mixed
	     */
	    public function getLat() {
	    	return $this->lat;
	    }

	    /**
	     * @param mixed $lat
	     *
	     * @return self
	     */
	    public function setLat($lat) {
	    	$this->lat = $lat;

	    	return $this;
	    }

	    /**
	     * @return mixed
	     */
	    public function getLng() {
	    	return $this->lng;
	    }

	    /**
	     * @param mixed $lng
	     *
	     * @return self
	     */
	    public function setLng($lng) {
	    	$this->lng = $lng;

	    	return $this;
	    }

	    public function setLocation() {
	    	$data = [
	    		"country" => $this->country,
	    		"postcode" => $this->postcode,
	    		"town" => $this->town,
	    		"lat" => $this->lat,
	    		"lng" => $this->lng
	    	];

	    	$rules = [
	    		"country" => [
	    			"emptyFields"
	    		],
	    		"postcode" => [
	    			"emptyFields"
	    		],
	    		"town" => [
	    			"emptyFields"
	    		],
	    		"lat" => [
	    			"emptyFields"
	    		],
	    		"lng" => [
	    			"emptyFields"
	    		]
	    	];

	    	$validation = new Validation;
	    	$validation->setData($data);
	    	$validation->setRules($rules);
	    	if($validation->isValid()) {
	    		try {
		    		// Getting database connection in class DB
	    			$conn = DB::getInstance();

	    			if ($this->streetnameExists() && $this->cityExists() && $this->countryExists() && $this->locationExists()) {
	    				return true;
	    			}
	    		} catch (Throwable $t) {
		    		// If database connection fails
	    			$_SESSION["errors"]["message"] = "<li>".$t."<li>";
	    			return false;
	    		}
	    	}
	    }

	    private function streetnameExists() {
	    	$conn = DB::getInstance();

	    	$statement = $conn->prepare("SELECT * FROM streetnames WHERE name = :streetname");
	    	$statement->bindParam(":streetname", $this->streetname);
	    	$statement->execute();

	    	if($statement->rowCount() < 1) {
	    		if ($this->setStreetnameValue()) {
	    			return true;
	    		}
	    		return false;
	    	}
	    	return true;
	    }

	    private function setStreetnameValue() {
	    	$conn = DB::getInstance();

	    	$statement = $conn->prepare("INSERT INTO streetnames (name) VALUES (:streetname)");
	    	$statement->bindParam(":streetname", $this->streetname);

	    	if($statement->execute()) {
	    		return true;
	    	}

	    	$_SESSION["errors"]["message"] = "<li>Something went wrong! Try again later.</li>";
	    	return false;
	    }

	    private function cityExists() {
	    	$conn = DB::getInstance();

	    	$statement = $conn->prepare("SELECT * FROM cities WHERE name = :city");
	    	$statement->bindParam(":city", $this->town);
	    	$statement->execute();

	    	if($statement->rowCount() < 1) {
	    		if ($this->setCityValue()) {
	    			return true;
	    		}
	    		return false;
	    	}
	    	return true;
	    }

	    private function setCityValue() {
	    	$conn = DB::getInstance();

	    	$statement = $conn->prepare("INSERT INTO cities (name, postal_code, streetname_id) VALUES (:city, :postcode, (SELECT id FROM streetnames WHERE name = :streetname))");
	    	$statement->bindParam(":city", $this->town);
	    	$statement->bindParam(":postcode", $this->postcode);
	    	$statement->bindParam(":streetname", $this->streetname);

	    	if($statement->execute()) {
	    		return true;
	    	}

	    	$_SESSION["errors"]["message"] = "<li>Something went wrong! Try again later.</li>";
	    	return false;
	    }

	    private function countryExists() {
	    	$conn = DB::getInstance();

	    	$statement = $conn->prepare("SELECT * FROM countries WHERE name = :country");
	    	$statement->bindParam(":country", $this->country);
	    	$statement->execute();

	    	if($statement->rowCount() < 1) {
	    		if ($this->setCountryValue()) {
	    			return true;
	    		}
	    		return false;
	    	}
	    	return true;
	    }

	    private function setCountryValue() {
	    	$conn = DB::getInstance();

	    	$statement = $conn->prepare("INSERT INTO countries (name, city_id) VALUES (:country, (SELECT id FROM cities WHERE postal_code = :postcode))");
	    	$statement->bindParam(":country", $this->country);
	    	$statement->bindParam(":postcode", $this->postcode);
				    		// Checking if post is succesfully added to the database
	    	if($statement->execute()) {
	    		return true;
	    	}

	    	$_SESSION["errors"]["message"] = "<li>Something went wrong! Try again later.</li>";
	    	return false;
	    }

	    private function locationExists() {
	    	$conn = DB::getInstance();

	    	$statement = $conn->prepare("SELECT * FROM locations WHERE latitude = :latitude AND longitude = :longitude");
	    	$statement->bindParam(":latitude", $this->lat);
	    	$statement->bindParam(":longitude", $this->lng);
	    	$statement->execute();

	    	if($statement->rowCount() < 1) {
	    		if ($this->setLocationValue()) {
	    			return true;
	    		}
	    		return false;
	    	}
	    	return true;
	    }

	    private function setLocationValue() {
	    	$conn = DB::getInstance();

	    	$statement = $conn->prepare("INSERT INTO locations (latitude, longitude, country_id) VALUES (:latitude, :longitude, (SELECT id FROM countries WHERE name = :country))");
	    	$statement->bindParam(":latitude", $this->lat);
	    	$statement->bindParam(":longitude", $this->lng);
	    	$statement->bindParam(":country", $this->country);

	    	if($statement->execute()) {
	    		return true;
	    	}

	    	$_SESSION["errors"]["message"] = "<li>Something went wrong! Try again later.</li>";
	    	return false;
	    }


	    public static function getLocations() {
	    	$conn = DB::getInstance();

	    	$statement = $conn->prepare("SELECT *, users.id AS userId, posts.id AS postId FROM locations, posts, users, filters WHERE posts.location_id = locations.id AND posts.user_id = users.id AND posts.filter_id = filters.id AND posts.active = 1");
			$statement->execute();
	    	$locations = $statement->fetchAll();

	    	if ($statement->rowCount() > 0) {
	    		$output = "";
	    		foreach ($locations as $location) {
	    			$profile_pic = "'uploads/profile_pic/".$location['profile_pic']."'";
	    			$image = "'uploads/feed/".$location['image']."'";
	    			$output .= '{filter: "'.$location["class"].'", postId: '.$location["postId"].', profile_pic: '.$profile_pic.', name: "'.htmlspecialchars($location["username"]).'", image: '.$image.', id: '.$location["userId"].', lat: '.$location["latitude"].', lng: '.$location["longitude"].'},';
	    		}
	    		return $output;
	    	} else {
	    		$_SESSION["errors"]["message"] = "<li>We don't have any locations to show.</li>";
	    		return false;
	    	}

	    	$_SESSION["errors"]["message"] = "<li>Something went wrong! Try again later.</li>";
	    	return false;
	    }
	}