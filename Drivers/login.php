<!DOCTYPE html>
<?php include('../server.php'); ?>
<?php include_once("../base.php"); ?>
<html>
<head>
	<title>Login</title>
	<?php include_once("../base.php"); ?>
	<link rel="stylesheet" type ="text/css" href="/Drivers/reg_style.css">
	<link rel="stylesheet" type ="text/css" href="/template_style.css">
</head>
<body>
	<?php include_once('../header_template.php'); ?>
	<div class="header">
		<h2>Login</h2>
	</div>

	<form method="post" action="/Drivers/login.php" id="regform">
		<?php include('reg_errors.php'); ?>
		<div class="input-group">
			<label>Username</label>
			<input type="text" name="username"  pattern="[^()/><\][\\\x22,;|]+">
		</div>
		<div class="input-group">
			<label>Password</label>
			<input type="password" name="password"  pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{4,}[^()/><\][\\\x22,;|]+" title="Password must contain at least one number and one uppercase and lowercase letter, and at least 4 or more characters">
		</div>
		<div class="input-group">
			<button type="submit" name="login" class="btn">Login</button>
		</div>
		<p>

			Cant login? <a href="/Drivers/cant_login.php">Reset Your Password</a>
		</p>
		<br />
		<p>
			Not yet a member? <a href="/Drivers/register.php">Sign up</a>
		</p>
	</form>
	<?php include_once('../footer_template.php'); ?>
</body>

</html>
