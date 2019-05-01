<?php

    class UploadProfilePic extends UploadPost {
        private $file;

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
	     * @return boolean
	     * true if check of file is successful
	     * false if check of file is unsuccessful 
	     */

	    public function checkFile() {
            echo "test2";
	    	$_SESSION["errors"]["title"] = "Uploading Failed:";
	    	$_SESSION["errors"]["message"] = "";
			$details = $this->getFileDetails();
			var_dump($details);

	    	if (!$this->checkExtension($details["fileName"])) {
	    		$_SESSION["errors"]["message"] .= "<li>You cannot upload this type of file!</li>";
	    	}

	    	if (!$this->checkErrors($details["fileError"])) {
	    		$_SESSION["errors"]["message"] .= "<li>There was an error uploading your file!</li>";
	    	}

	    	if (!$this->checkSize($details["fileSize"])) {
	    		$_SESSION["errors"]["message"] .= "<li>Your file is too big!</li>";
	    	}

	    	if(empty($_SESSION["errors"]["message"])) {
				echo "test3";
	    		$this->uploadFile($details);
	    		return true;
	    	}
	    	return false;
	    }

	    private function getFileDetails() {
	    	//Seperates info in variables
			$fileName = $this->file['name'];
	    	$fileTmpName = $this->file['tmp_name'];
	    	$fileSize = $this->file['size'];
	    	$fileError = $this->file['error'];

	    	return [
	    		"fileName" => $fileName, 
	    		"fileTmpName" => $fileTmpName,
	    		"fileSize" => $fileSize,
	    		"fileError" => $fileError
	    	];
	    }

	    private function checkExtension($fileName) {
	    	//Explode function to get the extension, this to allow certain extensions and others not
	    	$fileActualExt = $this->getExtension($fileName);
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

	    private function getExtension($fileName) {
	    	$fileExt = explode('.',  $fileName);
	    	return strtolower(end($fileExt));
	    }

	    private function uploadFile($details) {
	    	//Give the uploaded file an unique number so it doesn't get deleted if someone uploads file with same name and ext
	    	$fileNameNew = $this->changeFileName($details["fileName"]);
	    	$fileDestination = 'uploads/profile_pic/'.$fileNameNew;
	    	$_SESSION["path"] = $fileDestination;
	    	move_uploaded_file($details["fileTmpName"], $fileDestination);
	    }
    }