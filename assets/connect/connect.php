<?php 

class Connect{
    private $host = 'localhost'; 
    private $db   = 'banco_teste';
    private $user = 'root'; 
    private $pass = ''; 
    private $charset = 'utf8mb4';
    public $conn;

    public function __construct() {
        $this->connect();
    }

    private function connect() {
        $dsn = "mysql:host=$this->host;dbname=$this->db;charset=$this->charset";
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];

        try {
            $this->conn = new PDO($dsn, $this->user, $this->pass, $options);
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int)$e->getCode());
        }
    }
}

// $db = new Connect();
// $conn = $db->conn; 
