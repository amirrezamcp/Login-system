<?php
require_once 'autoload.php';
// use Models\Database;
use Models\Token;

// class User extends Database {
//     use Models\SanitizerTrait;
//     public function get($id) {
//         $sql = "SELECT * FROM users WHERE id= ?";
//         $stmt = $this->executeStatement($sql, $id);
//         $result = $stmt->get_result();
//         return $result->fetch_assoc();
//     }

//     public function test($input) {
//         return Self::sanitizeInput($input);
//     }
// }

// $userTable = new User();
// $input1 = "amr";
// $input2 = ['sads', 'saadasda', '456464'];
// $user = $userTable->test($input1);
// var_dump($user);

// $user_id = 1;
// $type = "email";
// $type = "password";
// $userToken = "f4752cad7cc1c748426f18a5cf1162e60605e5644894674259550837f734306d";
// $obj = new Token();
// $token = $obj->saveToken($user_id, $type);
// $token = $obj->getToken ($user_id, $type);
// $token = $obj->compareToken($user_id, $type, $userToken);
// var_dump($token);

use Models\Mail;
$emailTo = "580fabbb37@emailbbox.pro";
$subject = "test subject";
$message = "click this link to verify your email address";
$result = Mail::send($emailTo, $subject, $message);
var_dump($result);