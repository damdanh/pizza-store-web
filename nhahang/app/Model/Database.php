<?php
class Database {
    private $DB_HOST;
    private $DB_USER;
    private $DB_PASS;
    private $DB_NAME;
    private $conn;

    public function __construct($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME)
    {
        $this->DB_HOST = $DB_HOST;
        $this->DB_USER = $DB_USER;
        $this->DB_PASS = $DB_PASS;
        $this->DB_NAME = $DB_NAME;
    }

    public function connect()
    {
        try {
            $this->conn = new PDO("mysql:host=$this->DB_HOST;dbname=$this->DB_NAME", $this->DB_USER, $this->DB_PASS);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            // echo "Connected successfully";
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }

    public function executeStatement($sql, $params = [])
    {
        try {
            $stmt = $this->conn->prepare($sql);
            // Thực thi với các tham số TÁCH BIỆT
            $stmt->execute($params); 
            return $stmt;
        } catch (PDOException $e) {
            die("Query failed: " . $e->getMessage()); 
        }
    }

    public function get_all($sql, $params = [])
    {
        $stmt = $this->executeStatement($sql, $params);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function get_row($sql, $params = [])
    {
        $stmt = $this->executeStatement($sql, $params);
        return $stmt->fetch(PDO::FETCH_ASSOC); 
    }

    public function action($sql, $params = []) {
        $stmt = $this->executeStatement($sql, $params);
        return $this->conn->lastInsertId();
    }
}
?>