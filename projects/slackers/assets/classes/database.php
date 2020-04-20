<?php
class Database {
	private $connection;

	// $db = new Database('localhost', 'username', 'password', 'bonusrolls');

	public function __construct($host, $user, $pass, $database) {
		// Database type (mysql), database name and server/host
		$dsn = 'mysql:dbname=' . $database . ';port=3308;host=' . $host;

		try {
			$this->connection = new PDO($dsn, $user, $pass);
		}

		catch(PDOException $e) {
			$this->halt($e->getMessage());
		}
	}

	public function halt($message) {
		ob_end_flush();

		echo "<h1>Database Error</h1>";

		if (is_array($message)) {
			$message = end($message);
		}

		echo "<p>{$message}</p>";
		exit;
	}

	public function query($query) {
		$result = $this->connection->query($query);
		return $result ? $result : $this->halt($this->connection->errorInfo());
	}

	public function prepare($query) {
		$result = $this->connection->prepare($query);
		return $result ? $result : $this->halt($this->connection->errorInfo());
	}

	public function insert_id() {
		return $this->connection->lastInsertId();
	}
}
