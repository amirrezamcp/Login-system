<?php
	require_once "autoload.php";
	require_once 'src/AuthToken.php';
	require_once 'src/CsrfToken.php';

	use src\Csrftoken\CsrfToken;
	use src\Semej\Semej;
	use Models\AuthUser;

	// REGISTER
	if(isset($_POST['register_btn']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
	$Csrf_Token = $_POST['Csrf_Token'];
	$data = $_POST['frm'];
	$authUser = new AuthUser();
	$authUser->register($Csrf_Token, $data);
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <!-- This file has been downloaded from Bootsnipp.com. Enjoy! -->
    <title>animated sinin and signup panel. animated login and registeration page, popup,  - Bootsnipp.com</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="http://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<div class="login-reg-panel">
		<div class="login-info-box">
			<h2>Have an account?</h2>
			<p>Lorem ipsum dolor sit amet</p>
			<label id="label-register" for="log-reg-show">Login</label>
			<input type="radio" name="active-log-panel" id="log-reg-show"  checked="checked">
		</div>
							
		<div class="register-info-box">
			<h2>Don't have an account?</h2>
			<p>Lorem ipsum dolor sit amet</p>
			<label id="label-login" for="log-login-show">Register</label>
			<input type="radio" name="active-log-panel" id="log-login-show">
		</div>
	
		<div class="white-panel">
			<div class="login-show">
				<h2>LOGIN</h2>
				<input type="text" placeholder="Email">
				<input type="password" placeholder="Password">
				<input type="button" value="Login">
				<a href="">Forgot password?</a>
			</div>
			<div class="register-show">
				<h2>REGISTER</h2>
				<form action="<?= htmlspecialchars($_SERVER['PHP_SELF']);  ?>" class="register" method="post">
					<input type="hidden" name="Csrf_Token" value="<?= CsrfToken::generate(); ?>">
					<input type="text" placeholder="Email" name="frm[email]">
					<input type="password" placeholder="Password" name="frm[password]">
					<input type="password" placeholder="Confirm Password" name="frm[confirm_password]">
					<input type="submit" value="Register" name="register_btn">
				</form>
			</div>
		</div>
	</div>

    <script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="assets/js/script.js"></script>
	<?php Semej::alert(); ?>
</body>
</html>