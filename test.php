<?php
require_once 'autoload.php';
use Models\Database;

class User extends Database {
    use Models\SanitizerTrait;
    public function get($id) {
        $sql = "SELECT * FROM users WHERE id= ?";
        $stmt = $this->executeStatement($sql, $id);
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function test($input) {
        return Self::sanitizeInput($input);
    }
}

$userTable = new User();
$input1 = "amr";
$input2 = ['sads', 'saadasda', '456464'];
$user = $userTable->test($input1);
var_dump($user);