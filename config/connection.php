<?php

class connection {

    private $host = 'localhost';
    private $db = 'JapanTicketingDB';
    private $user = 'root';
    private $password = '';
    private static $instance = null;
    private PDO $con;

    private function __construct() {
        $this->startConnection();
    }

    private function startConnection() {
        $dsn = "mysql:host=$this->host;dbname=$this->db;charset=UTF8";
        try {
            $this->con = new PDO($dsn, $this->user, $this->password);
            $this->con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (Exception $ex) {
            echo "Connection failed: " . $ex->getMessage();
            echo $ex->getTraceAsString();
            exit;
        }
    }

    public static function getInstance() {
        if (self::$instance == null) {
            self::$instance = new Connection();
        }
        return self::$instance;
    }

    public function getCon() {
        return $this->con;
    }

}
