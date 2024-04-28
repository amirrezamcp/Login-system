<?php
namespace Models;

use src\AuthToken\AuthToken;
use src\Csrftoken\CsrfToken;
use src\Semej\Semej;

class AuthUser extends Database {
    use SanitizerTrait;
    // register user
    public function register($csrf_token, $formData) {
        // sanitize data
        $csrf_token = $this->sanitizeInput($csrf_token);
        $formData   = $this->sanitizeInput($formData);

        // check email exists
        $check_email = $this->checkEmail($formData['email']);
        if($check_email) {
            Semej::set('error', 'Email', 'Email already exists.');
            header("Location: index.php");die;
        }

        // check and confirm password
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
            $lastInsertId = $stmt->insert_id;
            $_token = new Token();
            $token = $_token->saveToken($lastInsertId, 'email');
            $finalResult = $this->sendActivationLinks($formData['email'], $lastInsertId);
            if($finalResult) {
                Semej::set('ok', 'user register successfully', 'please check your inbox.');
                header("Location: index.php");die;
            }else{
                Semej::set('error', 'user register failed', 'User Register failed.');
                header("Location: index.php");die;
            }
        }else{
            Semej::set('error', 'user register failed', 'User Register failed.');
            header("Location: index.php");die;
        }
    }

    // check user email exists
    public function checkEmail($email) {
        $sql = "SELECT email FROM users WHERE email = ?";
        $params = [$email];
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
        $subject = "Activation link";
        $message = "http://localhost/PHP-Expert/PHP-Project/Login-system/verifyEmail.php?token=".$token['token']."&email=".$email;
        $mail = new Mail();
        $result = $mail->send($email, $subject, $message);
        return $result;
    }

    // login user
    public function login($csrf_token, $formData) {

        // sanitize inputs
        $csrf_token = $this->sanitizeInput($csrf_token);
        $formData = $this->sanitizeInput($formData);

        // check csrf token
        $check_csrf_token = CsrfToken::validate($csrf_token);
        if(!$check_csrf_token) {
            Semej::set('error', 'invalid csrf token', 'please try again.');
            header("Location: index.php");die;
        }
        $sql = "SELECT * FROM users WHERE email = ?";
        $params = [
            $formData['email']
        ];
        $stmt = $this->executeStatement($sql, $params);
        $result = $stmt->get_result();
        $result = $result->fetch_assoc();
        if(is_null($result)) {
            Semej::set('error', 'invalid credentials', 'Invalid email or password.');
            header("Location: index.php");die;
        }
        if(!password_verify($formData['password'], $result['password'])) {
            Semej::set('error', 'invalid credentials', 'Invalid email or password.');
            header("Location: index.php");die;
        }
        if($result['is_email_verified'] != '1') {
            // Semej::set('error', 'email not verified', 'Email not verified');
            // header("Location: index.php");die;
            $_token = new Token();
            $token = $_token->getToken($result['id'], 'email');
            if(is_null($token)) {
                $_token->saveToken($result['id'], 'email');
            }
            $result = $this->sendActivationLinks($result['email'], $result['id']);
            if($result) {
                Semej::set('ok', 'email sent', 'check your inbox to verify your account.');
                header("Location: index.php");die;
            }   
        }
        // login verified
        $_SESSION['username'] = $result['name'];
        AuthToken::generate();
        header("Location: dashboard/dashboard.php");die;
    }
}