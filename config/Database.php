<?php
/**
 * Database Singleton Class
 * OOP PDO connection to MySQL database 'mydb'
 */

class Database {
    private static $instance = null;
    private $connection;
    
    private $host = 'localhost';
    private $dbname = 'vigenesia';
    private $username = 'root';
    private $password = 'P@ssword';
    
    private function __construct() {
        try {
            $this->connection = new PDO(
                "mysql:host={$this->host};dbname={$this->dbname};charset=utf8mb4",
                $this->username,
                $this->password,
                [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
            );
        } catch(PDOException $e) {
            die(json_encode(['error' => 'Connection failed: ' . $e->getMessage()], JSON_PRETTY_PRINT));
        }
    }
    
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    public function getConnection() {
        return $this->connection;
    }
}
?>
