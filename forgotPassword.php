<?php

require_once "autoload.php";

use src\Csrftoken\CsrfToken;
use src\Semej\Semej;
use Models\User;

// get form data
if(isset($_POST['btn']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $csrf_token = $_POST['csrf_token'];
    $email = $_POST['email'];
    $user = new User();
    $user->resetPassWord($csrf_token, $email);
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
            <legend>Enter your Email Address to reset your password</legend>
            <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                <input type="hidden" name="csrf_token" value="<?php echo CsrfToken::generate(); ?>">
                <div class="form-group">
                    <input type="email" name="email" class="form-control" placeholder="foo@bar.com">
                </div>
                <div class="form-group">
                    <input name="btn" type="submit" value="Get Link" class="btn btn-success form-control">
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