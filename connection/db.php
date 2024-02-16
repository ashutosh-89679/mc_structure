<?php

if (isset($_SERVER['HTTP_ORIGIN'])) {
    header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
    header('Access-Control-Allow-Credentials: true');
    header('Access-Control-Max-Age: 86400');    // cache for 1 day
}

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
        header("Access-Control-Allow-Methods: GET, POST, DELETE, OPTIONS, PATCH");
    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
        header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
    exit();
}

class DB {
	// Static Class DB Connection Variables (for write and read)
	private static $writeDBConnection;
	private static $readDBConnection;

	// Static Class Method to connect to DB to perform Writes actions
	// handle the PDOException in the controller class to output a json api error
	public static function connectWriteDB() {
		if(self::$writeDBConnection === null) {
				self::$writeDBConnection = new PDO('mysql:host=localhost;dbname=self_made;charset=utf8', 'root', '');
				self::$writeDBConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				self::$writeDBConnection->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
		}

		return self::$writeDBConnection;
	}

	// Static Class Method to connect to DB to perform read only actions (read replicas)
	// handle the PDOException in the controller class to output a json api error
	public static function connectReadDB() {
		if(self::$readDBConnection === null) {
				self::$readDBConnection = new PDO('mysql:host=localhost;dbname=self_made;charset=utf8', 'root', '');
				self::$readDBConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				self::$readDBConnection->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
		}

		return self::$readDBConnection;
	}

}
?>
