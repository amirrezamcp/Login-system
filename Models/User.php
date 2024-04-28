<?php
namespace Models;

class User extends Database {
    use SanitizerTrait;

    public function getIdByEmail($email) {
        $email = $this->sanitizeInput($email);
        $sql = "SELECT id FROM users WHERE email = ?";
        $params = [
            $email
        ];
        $stmt = $this->executeStatement($sql, $params);
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function verifyEmail($id) {
        $id = $this->sanitizeInput($id);
        $sql = "UPDATE users SET is_email_verified = '1' WHERE id = ?";
        $params = [
            $id
        ];
        $stmt = $this->executeStatement($sql, $params);
        if($stmt->affected_rows == 1) {
            return true;
        }else{
            return false;
        }
    }
}