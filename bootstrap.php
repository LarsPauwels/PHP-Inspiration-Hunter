<?php
    // start a new session for each user
    session_start();
    
    // Include bootstrap.php instead of all the seperate classes. LESS IS MORE!
    spl_autoload_register(function($class){
        require_once(__DIR__ . DIRECTORY_SEPARATOR . "classes" . DIRECTORY_SEPARATOR . $class . ".php");
    });
