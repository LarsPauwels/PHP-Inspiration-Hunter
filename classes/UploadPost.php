<?php
	/**
	 * 
	 */
	class UploadPost {
		private $file;
		private $title;
		private $description;
		private $country;
		private $streetname;
		private $houseNumber;

	    /**
	     * @return mixed
	     */
	    public function getFile() {
	    	return $this->file;
	    }

	    /**
	     * @param mixed $file
	     *
	     * @return self
	     */
	    public function setFile($file) {
	    	$this->file = $file;

	    	return $this;
	    }

	    /**
	     * @return mixed
	     */
	    public function getTitle() {
	    	return $this->title;
	    }

	    /**
	     * @param mixed $file
	     *
	     * @return self
	     */
	    public function setTitle($title) {
	    	$this->title = $title;

	    	return $this;
	    }

	    /**
	     * @return mixed
	     */
	    public function getDescription() {
	    	return $this->description;
	    }

	    /**
	     * @param mixed $file
	     *
	     * @return self
	     */
	    public function setDescription($description) {
	    	$this->description = $description;

	    	return $this;
	    }

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
	    public function getHouseNumber() {
	    	return $this->houseNumber;
	    }

	    /**
	     * @param mixed $file
	     *
	     * @return self
	     */
	    public function setHouseNumber($houseNumber) {
	    	$this->houseNumber = $houseNumber;

	    	return $this;
	    }

	    /**
	     * @return boolean
	     * true if check of file is successful
	     * false if check of file is unsuccessful 
	     */
	    public function checkFile() {
	    	$_SESSION["errors"]["title"] = "Uploading Failed:";
	    	$_SESSION["errors"]["message"] = "";
	    	$details = $this->getFileDetails();

	    	if (!$this->checkExtension($details["FileName"])) {
	    		$_SESSION["errors"]["message"] .= "<li>You cannot upload this type of file!</li>";
	    	}

	    	if (!$this->checkErrors($details["fileError"])) {
	    		$_SESSION["errors"]["message"] .= "<li>There was an error uploading your file!</li>";
	    	}

	    	if (!$this->checkSize($details["fileSize"])) {
	    		$_SESSION["errors"]["message"] .= "<li>Your file is too big!</li>";		
	    	}

	    	if(empty($_SESSION["errors"]["message"])) {
	    		$this->uploadFile($details);
	    		return true;
	    	}
	    	return false;
	    }

	    private function getFileDetails() {
	    	//Seperates info in variables
	    	$FileName = $this->file['name'];
	    	$fileTmpName = $this->file['tmp_name'];
	    	$fileSize = $this->file['size'];
	    	$fileError = $this->file['error'];

	    	return [
	    		"FileName" => $FileName, 
	    		"fileTmpName" => $fileTmpName,
	    		"fileSize" => $fileSize,
	    		"fileError" => $fileError
	    	];
	    }

	    private function checkExtension($FileName) {
	    	//Explode function to get the extension, this to allow certain extensions and others not
	    	$fileActualExt = $this->getExtension($FileName);
			$allowed = array('jpg', 'jpeg', 'png'); //Different types of extensions that are allowed

			if (in_array($fileActualExt, $allowed)) { //if the extension is allowed then...
				return true;
			}
			return false;
		}

		private function checkErrors($fileError) {
	    	if ($fileError === 0) { //if theres no error
	    		return true;
	    	}
	    	return false;
	    }

	    private function checkSize($fileSize) {
	    	if ($fileSize < 1000000) { //if filezize il less than 100 mb
	    		return true;
	    	}
	    	return false;
	    }

	    private function changeFileName($fileName) {
	    	$fileActualExt = $this->getExtension($fileName);
	    	return uniqid('', true).".".$fileActualExt;
	    }

	    private function getExtension($FileName) {
	    	$fileExt = explode('.',  $FileName);
	    	return strtolower(end($fileExt));
	    }

	    private function uploadFile($details) {
	    	//Give the uploaded file an unique number so it doesn't get deleted if someone uploads file with same name and ext
	    	$FileNameNew = $this->changeFileName($details["FileName"]);
	    	$fileDestination = 'uploads/feed/'.$FileNameNew;
	    	$_SESSION["path"] = $fileDestination;
	    	move_uploaded_file($details["fileTmpName"], $fileDestination);
	    }

	    public function checkPost() {
	    	$_SESSION["errors"]["title"] = "Uploading Failed:";
	    	$_SESSION["errors"]["message"] = "";

	    	if ($this->emptyFields()) {
	    		$_SESSION["errors"]["message"] = "<li>You need to fill in all required fields!</li>";
	    	}

	    	if (empty($_SESSION["errors"]["message"])) {
	    		return true;
	    	}
	    	return false;
	    }

	    private function emptyFields() {
	    	if (empty($this->title) || empty($this->description) || empty($this->country) || empty($this->streetname)) {
	    		return true;
	    	}
	    	return false;
	    }

	    public function uploadToDatabase($path) {
	    	$image = str_replace("uploads/feed/", "", $path);
	    	try {
	    		// Getting database connection in class DB
	    		$conn = DB::getInstance();

		    	// Query for adding the post
	    		$statement = $conn->prepare("INSERT INTO posts (image, title, description, active,user_id) VALUES (:image, :title, :description, 1, :user_id)");
	    		$statement->bindParam(":image", $image);
	    		$statement->bindParam(":title", $this->title);
	    		$statement->bindParam(":description", $this->description);
	    		$statement->bindParam(":user_id", $_SESSION["user"]["id"]);

	    		// Checking if post is succesfully added to the database
	    		if($statement->execute()) {
					// Post is successfully added => return true
	    			return true;
	    		}

	    		// Failed to add user => return false
	    		$_SESSION["errors"]["message"] = "<li>Something went wrong! Try again later.</li>";
	    		return false;
	    	} catch (Throwable $t) {
	    		// If database connection fails
	    		$_SESSION["errors"]["message"] = "<li>".$t."<li>";
	    		return false;
	    	}
	    }
	}