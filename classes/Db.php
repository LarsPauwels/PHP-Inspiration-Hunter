<?php
	/**
	 * Making a connection to the database
	 */
	abstract class DB {
		private static $conn;

		private static function getConfig(){
            // get the config file
            return parse_ini_file(__DIR__ . "/../config/config.ini");
        }

		public static function getInstance() {
			if (self::$conn != null) {
				return self::$conn;
			}

			$config = self::getConfig();
			$host = $config['db_servername'];
            $database = $config['db_name'];
            $user = $config['db_user'];
            $password = $config['db_password'];

			self::$conn = new PDO('mysql:host='.$host.';dbname='.$database.';charset=utf8mb4', $user, $password);
			self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			return self::$conn;
		}
	}