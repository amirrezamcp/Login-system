<?php
namespace Database;

class Database {
    private $host = 'localhost';
    private $username = 'root';
    private $password = '';
    private $database = 'login_system';
    private $connection;

    public function __construct() {
        $this->connection = new \mysqli($this->host, $this->username, $this->password, $this->database);
        if ($this->connection->connect_error) {
            die('Connection Failed: '.$this->connection->connect_error);
        }
    }
    public function __destruct() {
        $this->connection->close();
    }

    protected function executeStatement($sql, $params = []) {
        $stmt = $this->connection->prepare($sql);
        if (!$stmt) {
            die("Error in preparing Statement: ".$this->connection->error);
        }
        if(!empty($params)) {
            $types = str_repeat('s', count($params));
            $stmt->bind_param($types, ...$params);
        }
        $stmt->execute();
        return $stmt;
    }
}
class user extends Database {
    public function gzxczet($id) {
        $sql = "SELECT * FROM users WHERE id =?";
        $stmt = $this->executeStatement($sql, $id);
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }
}

$usertable = new user();
$user = $usertable->gzxczet([1]);
var_dump($user);