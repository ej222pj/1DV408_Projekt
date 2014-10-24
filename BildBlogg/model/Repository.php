<?php

namespace model;

class Repository {	
	private $dbConnection;
	private $dbTable;
	private static $DB_USERNAME = "root";
	private static $DB_PASSWORD = '';
	private static $DB_CONNECTION = 'mysql:host=127.0.0.1;dbname=newmember';
	
	public function connection() {
		if ($this->dbConnection == NULL)
			$this->dbConnection = new \PDO(self::$DB_CONNECTION, self::$DB_USERNAME, self::$DB_PASSWORD);
		
		$this->dbConnection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
		
		return $this->dbConnection;
	}
}