<!DOCTYPE html>
<?php include('../../server.php'); ?>
<?php
	if (!$_SESSION)
		header('Location: ../../index.php');

	include('../connect_database.php');
	$username = $_SESSION['username'];
	$firstname = $_SESSION['firstname'];
	$surname = $_SESSION['surname'];
	$email = $_SESSION['email'];

	if (isset($_POST['password']))
		$password = $_POST['password'];
	if (isset($_POST['new_password']))
		$new_password = $_POST['new_password'];
	if (isset($_POST['con_password']))
		$con_password = $_POST['con_password'];

	if (empty($password) && isset($_POST['password']))
		array_push($errors, "Please Enter Your Current Password");
	if (empty($new_password) && isset($_POST['new_password']))
		array_push($errors, "Please Enter Your New Password");
	if (empty($con_password) && isset($_POST['con_password']))
		array_push($errors, "Please Confirm Your New Password");

	if (!empty($new_password) && isset($_POST['new_password']) && !empty($con_password) && isset($_POST['con_password']))
	{
		if ($new_password != $con_password)
			array_push($errors, "Your Passwords Do Not Match");
	}
	if (isset($new_password))
	{
		if (!preg_match("#[0-9]+#", $new_password)) {
			array_push($errors, "Password must include at least one number!");
		}
		if (!preg_match("#[A-Z]+#", $new_password)) {
			array_push($errors,"Password must include at least one uppercase letter!");
		} 
		if (!preg_match("#[a-z]+#", $new_password)) {
			array_push($errors,"Password must include at least one lowercase letter!");
		} 
	}

	if (count($errors) == 0 && isset($_POST['password']) && isset($_POST['new_password']) && isset($_POST['con_password']))
	{
		$password = hash("whirlpool", $password);
		$new_password = hash("whirlpool", $new_password);

		$query = $conn->prepare("SELECT * FROM $dbname.users WHERE username = :usr AND password = :psw");
		$query->execute(["usr"=>$username, "psw"=>$password]);
		$result = $query->fetchAll();

		if (count($result) == 1)
		{
			$update_user = $conn->prepare("UPDATE $dbname.users SET password= :new WHERE username= :usr AND password= :psw");
			$update_user->execute(["new"=>$new_password ,"usr"=>$username, "psw"=>$password]);
			$_SESSION['message'] = "Password Updated";
			header('Location: ../../index.php');
		}
		else
		{
			array_push($errors, "Incorrect Password");
		}
	}
	// $password = hash("whirlpool", $password);
	// $new_password = hash("whirlpool", $_POST['new_password']);
	// $con_password = hash("whirlpool", $_POST['con_password']);

	// if (isset($_POST['username']) && $_POST['username'] != $username)
	// {
	// 	$new_username = $_POST['username'];
	// 	$update_user = $conn->prepare("UPDATE $dbname.users SET username= :new WHERE username= :usr AND email= :email");
	// 	$update_user->execute(["new"=>$new_username ,"usr"=>$username, "email"=>$email]);
	// 	$_SESSION['username'] = $new_username;
	// 	header('location: ac_settings_gen.php');
	// };
	// if (isset($_POST['firstname']) && $_POST['firstname'] != $firstname)
	// {
	// 	$new_firstname = $_POST['firstname'];
	// 	$update_user = $conn->prepare("UPDATE $dbname.users SET firstname= :new WHERE username= :usr AND email= :email");
	// 	$update_user->execute(["new"=>$new_firstname ,"usr"=>$username, "email"=>$email]);
	// 	$_SESSION['firstname'] = $new_firstname;
	// 	header('location: ac_settings_gen.php');
	// };
	// if (isset($_POST['surname']) && $_POST['surname'] != $surname)
	// {
	// 	$new_surname = $_POST['surname'];
	// 	$update_user = $conn->prepare("UPDATE $dbname.users SET surname= :new WHERE username= :usr AND email= :email");
	// 	$update_user->execute(["new"=>$new_surname ,"usr"=>$username, "email"=>$email]);
	// 	$_SESSION['surname'] = $new_surname;
	// 	header('location: ac_settings_gen.php');
	// };
	// if (isset($_POST['email']) && $_POST['email'] != $email)
	// {
	// 	$new_email = $_POST['email'];
	// 	$update_user = $conn->prepare("UPDATE $dbname.users SET email= :new WHERE username= :usr AND email= :email");
	// 	$update_user->execute(["new"=>$new_email ,"usr"=>$username, "email"=>$email]);
	// 	$_SESSION['email'] = $new_email;
	// 	header('location: ac_settings_gen.php');
	// };

?>


<html>
<head>
	<title>Password Settings</title>
	<?php include_once("../../base.php"); ?>
	<link rel="stylesheet" type ="text/css" href="/Users/reg_style.css">
	<link rel="stylesheet" type ="text/css" href="/template_style.css">
</head>
<body>
	<?php include_once('../../header_template.php'); ?>
	<div class="account_settings">
		<h2>Password Settings</h2>
	</div>

	<form method="post" action="/Users/account_settings/ac_settings_psw.php" id="regform" style="width: 60%;">
		<?php include('../reg_errors.php'); ?>
		<div class="input-group">
				<label>Current Password</label>
				<input type="password" name="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{4,}[^()/><\][\\\x22,;|]+" title="Password must contain at least one number and one uppercase and lowercase letter, and at least 4 or more characters">
			</div>
			<div class="input-group">
				<label>New Password</label>
				<input type="password" name="new_password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{4,}[^()/><\][\\\x22,;|]+" title="Password must contain at least one number and one uppercase and lowercase letter, and at least 4 or more characters">
			</div>

			<div class="input-group">
				<label>Confirm Password</label>
				<input type="password" name="con_password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{4,}[^()/><\][\\\x22,;|]+" title="Password must contain at least one number and one uppercase and lowercase letter, and at least 4 or more characters">
			</div>

			<div class="input-group">
				<button type="submit" name="update_pws" class="btn">Update</button>
			</div>
	</form>
	
	<?php include_once('../../footer_template.php'); ?>
</body>

</html>