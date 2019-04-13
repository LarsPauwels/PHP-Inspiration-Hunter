<?php
    if (isset($_POST['submit'] ) ) {
        //Superglobal gets info of selected file
        $file = $_FILES['file'];

        //Seperates info in variables
        $fileName = $_FILES['file']['name'];
        $fileTmpName = $_FILES['file']['tmp_name'];
        $fileSize = $_FILES['file']['size'];
        $fileError = $_FILES['file']['error'];

        //Explode function to get the extension, this to allow certain extensions and others not
        $fileExt = explode('.',  $fileName);
        $fileActualExt = strtolower(end($fileExt));

        //Different types of extensions that are allowed
        $allowed = array('jpg', 'jpeg', 'png');

        //if the extension is allowed then...
        if (in_array($fileActualExt, $allowed)) {
            //if theres no error
            if ($fileError === 0) {
                //if filezize il less than 100 mb
                if ($fileSize < 1000000) {
                    //Give the uploaded file an unique number so it doesn't get deleted if someone uploads file with same name and ext
                    $fileNameNew = uniqid('', true).".".$fileActualExt;
                    $fileDestination = 'uploads/'.$fileNameNew;
                    move_uploaded_file($fileTmpName, $fileDestination);
                    header("Location: index.php?uploadsucces");
                } else {
                    echo "Your file is too big!";
                }
            } else {
                echo "There was an error uploading your file!";
            }
        } else {
            echo "You cannot upload files with this type!";
        }
    }

?>