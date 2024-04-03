<?php
require_once 'autoload.php';
use Models\Database;

class User extends Database {
    public function get($id) {
        $sql = "SELECT * FROM users WHERE id= ?";
        $stmt = $this->executeStatement($sql, $id);
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }
}

$userTable = new User();
$user = $userTable->get([1]);
var_dump($user);