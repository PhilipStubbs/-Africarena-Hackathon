<!DOCTYPE html>
<?php include('../server.php'); ?>
<?php include_once("../base.php"); ?>
<html>
<head>
	<title>Login</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type ="text/css" href="css/main.css">
</head>
<body>
	<?php include_once('header_template.php') ?>
	<form method="post" action="/Users/login.php" id="regform">
		<?php include('reg_errors.php'); ?>
		<div class='form-style'>
			<label>Username</label>
			<input type="text" name="username"  pattern="[^()/><\][\\\x22,;|]+">
			<label>Password</label>
			<input type="password" name="password"  pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{4,}[^()/><\][\\\x22,;|]+" title="Password must contain at least one number and one uppercase and lowercase letter, and at least 4 or more characters">
			<input type="submit" name="login" value="Login">
			<p>
				Cant login? <a href="/Users/cant_login.php">Reset Your Password</a>
			</p>
			<p>
				Not yet a member? <a href="/Users/register.php">Sign up</a>
			</p>
		</div>
	</form>
	<?php include_once('../footer_template.php'); ?>
</body>
<script 
	src="navbar.js">
</script>
</html>