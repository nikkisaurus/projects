<?php
class Database {
    private $connection;

    public function __construct($dsn, $username, $password) {
        try {
            $this->connection = new PDO($dsn, $username, $password);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
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
}