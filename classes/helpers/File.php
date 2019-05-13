<?php
	/**
	 * 
	 */
	class File {
		private $file;
		private $type;
		private $path;

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
	    public function getType() {
	    	return $this->type;
	    }

	    /**
	     * @param mixed $type
	     *
	     * @return self
	     */
	    public function setType($type) {
	    	$this->type = $type;

	    	return $this;
	    }

	    /**
	     * @return mixed
	     */
	    public function getPath() {
	        return $this->path;
	    }

	    /**
	     * @param mixed $path
	     *
	     * @return self
	     */
	    public function setPath($path) {
	        $this->path = $path;

	        return $this;
	    }

	    public function uploadFile($dir) {
	    	$data = $this->getFileDetails();

	    	$rules = [
	    		"fileSize" => [
	    			"checkSize"
	    		],
	    		"fileError" => [
	    			"checkErrors"
	    		],
	    		"FileName" => [
	    			"checkExtension".$this->type
	    		]
	    	];

	    	$validation = new Validation;
	    	$validation->setData($data);
	    	$validation->setRules($rules);
	    	if($validation->isValid()) {
	    		//Give the uploaded file an unique number so it doesn't get deleted if someone uploads file with same name and ext
	    		$FileNameNew = $this->changeFileName($data["FileName"]);
	    		$fileDestination = 'uploads/'.$dir.'/'.$FileNameNew;
	    		$_SESSION["path"] = $fileDestination;
	    		if (move_uploaded_file($data["fileTmpName"], $fileDestination)) {
	    			return true;
	    		}
	    		return false;
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

	    public function getExtension($FileName) {
	    	$fileExt = explode('.',  $FileName);
	    	return strtolower(end($fileExt));
	    }

	    private function changeFileName($fileName) {
	    	$fileActualExt = $this->getExtension($fileName);
	    	return uniqid('', true).".".$fileActualExt;
	    }

	    public function deleteFile() {
	    	if (unlink($this->path)) {
	    		unset($_SESSION["path"]);
	    		return true;
	    	}
	    	return false;
	    }
	}