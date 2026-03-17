<?php
class Database {
    private $host = 'localhost';
    private $username = 'admin';
    private $password = 'wachtwoord';
    private $database = 'contact_manager';
    private $connection;

    public function connect() {
        $this->connection = null;
        try {
            $this->connection = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->database, $this->username, $this->password);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        }
        return $this->connection;
    }

    public function executeQuery($query, $params = []) {
        $stmt = $this->connection->prepare($query);
        $stmt->execute($params);
        return $stmt;
    }
}
?>