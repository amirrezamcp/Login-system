<?php

require_once "autoload.php";

use Models\Token;
use src\Csrftoken\CsrfToken;
use src\Semej\Semej;
use Models\User;

$token = $_GET['token'];
$email = $_GET['email'];

//check token and email exist
if(!isset($token) || !isset($email)) {
    header("Location: index.php");die;
}

// check token and email has value
if($token == '' || $email == '') {
    header("Location: index.php");die;
}

// check tokem
$_user = new User();
$user_id = $_user->getIdByEmail($email)['id'];

$_token = new Token();
$lastValidToken = $_token->getToken($user_id, 'password')['token'];
if(is_null($lastValidToken)) {
    header("Location: index.php");die;
}
if($token != $lastValidToken) {
    header("Location: index.php");die;
}

// if token and email are valid
if(isset($_POST['btn']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $password = $_POST['frm'];
    if($password['password'] !== $password['confirm_password']) {
        Semej::set('error', 'Password mismatch', 'Password mismatch.');
        header('Location: resetPassWord.php');die;
    }
    $_user->updatePassword($email, $token, $passwords);
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
    <div class="login-reg-panel justify-content-center align-items-center row">
        <fieldset>
            <legend>Update Password for : <?= htmlspecialchars($email); ?> </legend>
            <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']) . "?token=$token&&email=$email"; ?>" method="post">
                <input type="hidden" name="csrf_token" value="<?php echo CsrfToken::generate(); ?>">
                <div class="form-group">
                    <input type="password" name="frm[password]" id="" class="form_control" placeholder="Password">
                </div>
                <div class="form-group">
                    <input type="password" name="frm[confirm_password]" id="" class="form_control" placeholder="Confirm Password">
                </div>
                <div class="form-group">
                    <input type="submit" name="btn" value="Update Password" class="btn btn-success form-control">
                </div>
            </form>
        </fieldset>
	</div>

    <script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="assets/script.js"></script>
    <?php  Semej::alert(); ?>
</body>
</html>