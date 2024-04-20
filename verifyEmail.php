<?php

use Models\Token;
use Models\User;

require_once "autoload.php";

$flag = false;
if(!isset($_GET['token']) || !isset($_GET['email'])) {
    header("Location: index.php");die;
}
$token = $_GET['token'];
$email = $_GET['email'];
if($token == '' || $email == '') {
    header("Location: index.php");die;
}
$user = new User();
$userId = $user->getIdByEmail($email)['id'];
$_token = new Token();
if($_token->compareToken($userId, 'email', $token)) {
    $user->verifyEmail($userId);
    $flag = true;
}else {
    $flag = false;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <!-- This file has been downloaded from Bootsnipp.com. Enjoy! -->
    <title>verify Email Address.</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="http://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
<div class="login-reg-panel bg-dark justify-content-center align-items-center row">
    <?php
    if($flag):
    ?>
        <div class="verified">
            <h1>Email Verified</h1>
            <h2>please <a href="index.php">login here</a></h2>
        </div>
    <?php
    else :
    ?>
        <div class="unverified">
            <h1 class="text-danger">Invalid Link.</h1>
        </div>
    <?php
    endif;
    ?>
	</div>
    <script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="assets/script.js"></script>
</body>
</html>