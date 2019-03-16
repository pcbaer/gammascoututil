<?php

namespace GammaScout;

class Database {

	const HOST = 'localhost';

	const DB = 'gammascout';

	const USER = 'gamma';

	const PASSWORD = 'scout';

	/**
	 * @var \PDO
	 */
	private $connection;

	public function __construct() {
		$dsn              = 'mysql:host=' . self::HOST . ';dbname=' . self::DB;
		$this->connection = new \PDO($dsn, self::USER, self::PASSWORD);
	}

	/**
	 * @return \PDO
	 */
	public function getConnection() {
		return $this->connection;
	}

	/**
	 * @param array(array) $rowa
	 */
	public function insert($rows) {
		$this->connection->beginTransaction();
		$sql     = "INSERT IGNORE INTO log VALUES (:from, :to, :counter)";
		$stmt    = $this->connection->prepare($sql);
		$from    = '';
		$to      = '';
		$counter = 0;
		$stmt->bindParam(':from', $from);
		$stmt->bindParam(':to', $to);
		$stmt->bindParam(':counter', $counter);
		foreach ($rows as $row) {
			$from    = $row[0];
			$to      = $row[1];
			$counter = $row[2];
			$stmt->execute();
		}
		$this->connection->commit();
	}

}

?>