<?php
	require_once "autoload.php";
	require_once 'src/AuthToken.php';
	require_once 'src/CsrfToken.php';

	use src\Csrftoken\CsrfToken;
	use src\Semej\Semej;
	use Models\AuthUser;

// REGISTER FORM

if(isset($_POST['register_btn']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
	$csrf_token = $_POST['csrf_token'];
	$data = $_POST['frm'];
	$authUser = new AuthUser();
	$authUser->register($csrf_token, $data);
}

// LOGIN FORM
if(isset($_POST['login_btn']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
	$csrf_token = $_POST['csrf_token'];
	$data = $_POST['frm'];
	$authUser = new AuthUser();
	$authUser->login($csrf_token, $data);
}

// generate csrf token
$generated_csrf_token = CsrfToken::generate();

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
				<form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
				<h2>LOGIN</h2>
				<input name="csrf_token" type="hidden" value="<?php echo $generated_csrf_token; ?>">
				<input name="frm[email]" type="text" placeholder="Email">
				<input name="frm[password]" type="password" placeholder="Password">
				<input type="submit" value="Login" name="login_btn">
				<a href="forgotPassword.php">Forgot password?</a>
				</form>
			</div>
			<div class="register-show">
				<h2>REGISTER</h2>
				<form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" class="register" method="post">
				<input name="csrf_token" type="hidden" value="<?php echo $generated_csrf_token; ?>">
				<input name="frm[email]" type="text" placeholder="Email">
				<input name="frm[password]" type="password" placeholder="Password">
				<input name="frm[confirm_password]" type="password" placeholder="Confirm Password">
				<input name="register_btn" type="submit" value="Register">
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