<?php
namespace Models;
use src\Semej\Semej;

class AuthUser extends Database {
    use SanitizerTrait;
    // register user
    public function register($Csrf_Token, $formData) {
        $Csrf_Token = $this->sanitizeInput($Csrf_Token);
        $formData   = $this->sanitizeInput($formData);
        // check email exists
        $check_email = $this->checkEmail($formData['email']);
        if($check_email) {
            Semej::set('error', 'Email', 'Email already exists.');
            header("Location: index.php");die;
        }
        if($formData['password'] != $formData['confirm_password']) {
            Semej::set('error', 'confirm password', 'passwords are not match');
            header("Location: index.php");die;
        }
        // hash password
        $hashed_password = password_hash($formData['password'], PASSWORD_DEFAULT);
        // extract username from email address
        $emailArray = explode('@', $formData['email']);
        $name = $emailArray[0];
        // insert user to database(users)
        $sql = "INSERT INTO users (name, email, password) VALUES (?, ?, ?)";
        $params = [
            $name,
            $formData['email'],
            $hashed_password
        ];
        $stmt = $this->executeStatement($sql, $params);
        if($stmt->affected_rows === 1) {
            $lastInsert_id = $stmt->insert_id;
            $_token = new Token();
            $token = $_token->saveToken($lastInsert_id, 'email');
            $this->sendActivationLinks($formData['email'], $lastInsert_id);
        }else{
            Semej::set('error', 'user register failed', 'User Register failed.');
            header("Location: index.php");die;
        }
    }
    // check user email exists
    public function checkEmail($email) {
        $sql = "SELECT email FROM users WHERE email = ?";
        $params = [
            $email
        ];
        $stmt = $this->executeStatement($sql, $params);
        $result = $stmt->get_result();
        $result = $result->fetch_assoc();
        if(is_null($result)) {
            return false;
        }else{
            return true;
        }
    }
    // send activation link to new registered user
    public function sendActivationLinks($email, $user_id) {
        $_token = new Token();
        $token = $_token->getToken($user_id, 'email');
        $subject = "Activation Link";
        $message = "http://localhost/PHP-Expert/PHP-Project/Login-system/verifyEmail.php?token=" . $token['token'];
        $mail = new Mail;
        $result = $mail->send($email, $subject, $message);
        var_dump($result);die;
    }
}