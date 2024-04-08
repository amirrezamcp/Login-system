<?php
namespace Models;
use DateTime;

class Token extends Database{
    public function saveToken($user_id, $type) {
        $token = bin2hex(random_bytes(32));
        $expiration = (new DateTime())->modify('+1 day')->format('Y-m-d H:i:s');
        $sql = "INSERT INTO tokens (user_id, token, type, expiration) VALUES (?, ?, ?, ?)";
        $params = [
            $user_id,
            $token,
            $type,
            $expiration
        ];
        $stmt = $this->executeStatement($sql, $params);
        if($stmt->affected_rows == 1) {
            return true;
        }else{
            return false;
        }
    }

    public function getToken($user_id, $type) {
        $sql = "SELECT token FROM tokens WHERE user_id = ? AND type = ? AND expiration > NOW() AND used = '0' ORDER BY created_at DESC LIMIT 1";
        $params = [
            $user_id,
            $type
        ];
        $stmt = $this->executeStatement($sql, $params);
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function compareToken($user_id, $type, $userToken) {
        $lastValidToken = $this->getToken($user_id, $type);
        if($lastValidToken === null) {
            return false;
        }
        if($lastValidToken['token'] === $userToken) {
            return true;
        }else{
            return false;
        }
    }
}