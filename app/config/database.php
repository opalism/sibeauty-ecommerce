<?php
class Database {
    private $host = "localhost";
    private $user = "root";
    private $pass = "";
    private $db_name = "sibeauty";
    public $dbh; // Database Handler
    public $stmt;

    public function __construct() {
        // Data Source Name
        $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME;
        $options = [
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ];

        try {
            $this->dbh = new PDO($dsn, $this->user, $this->pass, $options);
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    // Helper function untuk query (Prepare, Bind, Execute) akan ditambahkan di Model wrapper
}