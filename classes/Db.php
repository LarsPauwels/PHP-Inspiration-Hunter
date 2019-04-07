<?php
	/**
	 * Making a connection to the database
	 */
	abstract class Db {
		private static $conn;

		public static function getInstance() {
			if (self::$conn != null) {
				return self::$conn;
			}

			$config = parse_ini_file("config/config.ini");

			self::$conn = new PDO("mysql:host=".$config['db_servername'].";dbname=".$config['db_name'], $config["db_user"], $config["db_password"]);
			self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			return self::$conn;
		}
	}