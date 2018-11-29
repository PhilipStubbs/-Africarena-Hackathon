<?php include('../server.php'); ?>
<!DOCTYPE html>
<?php include_once("../base.php"); ?>
<script src='https://www.google.com/recaptcha/api.js'></script>
<html>
<head>
	<title>Register</title>
	<link rel="stylesheet" type ="text/css" href="/Users/reg_style.css">
	<link rel="stylesheet" type ="text/css" href="template_style.css">
</head>
<body>
	<?php include_once('../sizebar_template.php') ?>
	<?php include_once('header_template.php') ?>
	<div class="header">
		<h2>Register</h2>
	</div>

	<form method="post" action="/Users/register.php" id="regform">
		<?php include('reg_errors.php'); ?>
		<div class="input-group">
			<label>Username</label>
			<input type="text" name="username" value="<?php echo $username; ?>"  pattern="[^()/><\][\\\x22,;|]+">
		</div>
		<div class="input-group">
			<label>First name</label>
			<input type="text" name="firstname" value="<?php echo $firstname; ?>"  pattern="[^()/><\][\\\x22,;|]+">
		</div>
		<div class="input-group">
			<label>Surname</label>
			<input type="text" name="surname" value="<?php echo $surname; ?>"  pattern="[^()/><\][\\\x22,;|]+">
		</div>
		<div class="input-group">
			<label>Email</label>
			<input type="email" name="email" value="<?php echo $email; ?>"  pattern="[^()/><\][\\\x22,;|]+">
		</div>
		<div class="input-group">
			<label>Password</label>
			<input type="password" name="password_1" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{4,}[^()/><\][\\\x22,;|]+" title="Password must contain at least one number and one uppercase and lowercase letter, and at least 4 or more characters">
		</div>
		<div class="input-group">
			<label>Confirm Password</label>
			<input type="password" name="password_2" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{4,}[^()/><\][\\\x22,;|]+" title="Password must contain at least one number and one uppercase and lowercase letter, and at least 4 or more characters">
		</div>
		<div class="g-recaptcha" data-sitekey=""></div>
		<div class="input-group">
			<button type="submit" name="reg_user" class="btn">Register</button>
		</div>
		<p>
			Already a member? <a href="/Users/login.php">Sign in</a>
		</p>
	</form>
	<?php include_once('../footer_template.php'); ?>
</body>
</html>