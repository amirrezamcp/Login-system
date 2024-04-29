<?php
namespace Models;

use src\Semej\Semej;

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

    public function resetPassWord($csrf_token, $email) {
        $csrf_token = $this->sanitizeInput($csrf_token);
        $email = $this->sanitizeInput($email);
        $user_id = $this->getIdByEmail($email);
        if(is_null($user_id)) {
        Semej::set('error', 'user not found', 'Email not found');
        return false;
        }
        $user_id = $user_id['id'];

        // send link
        $result = $this->sendResetPasswordLink($email, $user_id);
        if($result) {
            Semej::set('ok', 'sent', 'Check your inbox');
            return false;
        }else{
            Semej::set('error', 'user not found', 'error');
            return false;
        }
    }

    // send reset password link
    public function sendResetPasswordLink($email, $user_id) {
        $_token = new Token();
        $token = $_token->getToken($user_id, 'password');
        if(is_null($token)) {
            $_token->saveToken($user_id, 'password');
            $token = $_token->getToken($user_id, 'password');
        }
        $subject = "Reset PassWord link";
        $message = "http://localhost/PHP-Expert/PHP-Project/Login-system/resetPassWord.php?token=".$token['token']."&email=".$email;
        $mail = new Mail();
        $result = $mail->send($email, $subject, $message);
        return $result;
    }
}