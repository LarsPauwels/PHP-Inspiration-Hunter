<?php
	// Start a new session
	session_start();

	// Autoload all classes inside classes folder
	spl_autoload_register(function($class) {
		require_once(__DIR__ . DIRECTORY_SEPARATOR . "classes" . DIRECTORY_SEPARATOR . $class . ".php");
	});