<?php include('../server.php'); ?>
<?php
	// session_start();
	require('connect_database.php');
	$errors = array();
	$email = $_GET['email'];
	$code_1 = $_GET['code_1'];
	if (empty($email) || empty ($email))
	{
		$error = "Error";
		$_SESSION['error'] .= $error;
		header('Location: ../index.php');
	}

	$query = $conn->prepare("SELECT * FROM $dbname.users WHERE email = :eil AND confirmcode = :con ");
	$query->execute(["eil"=>$email , "con"=>$code_1]);
	$result = $query->fetchAll();
	if (sizeof($result) != 1)
	{
		$error = " Problem Authenticating";
		$_SESSION['error'] .= $error;
		header('Location: ../index.php');
	}
		

	if (isset($_POST['reset']))
	{
		
		if (sizeof($result) == 1)
		{		
			if (isset($_POST['new_password']))
				$new_password = $_POST['new_password'];
			if (isset($_POST['con_password']))
				$con_password = $_POST['con_password'];

			if (empty($new_password) && isset($_POST['new_password']))
				array_push($errors, "Please Enter Your New Password");
			if (empty($con_password) && isset($_POST['con_password']))
				array_push($errors, "Please Confirm Your New Password");
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

			if (!empty($new_password) && isset($_POST['new_password']) && !empty($con_password) && isset($_POST['con_password']))
			{
				if ($new_password != $con_password)
					array_push($errors, "Your Passwords Do Not Match");
			}
			
			if (count($errors) == 0 && isset($_POST['new_password']) && isset($_POST['con_password']) && !empty($con_password) && !empty($new_password))
			{
				$new_password = hash("whirlpool", $new_password);
				$update_user = $conn->prepare("UPDATE $dbname.users SET password= :new WHERE email= :eil AND confirmcode= :code");
				$update_user->execute(["new"=>$new_password ,"eil"=>$email, "code"=>$code_1]);
				$_SESSION['message'] = "Password Updated";
				header('Location: ../index.php');
			}
		}
		else
		{
			$error = " Problem Authenticating";
			$_SESSION['error'] .= $error;
			header('Location: ../index.php');
		}
		
		
		
		
			// $update_user = $conn->prepare("UPDATE $dbname.users SET password= :new WHERE username= :usr AND password= :psw");
			// $update_user->execute(["new"=>$new_password ,"usr"=>$username, "psw"=>$password]);
			
			// header('Location: ../../index.php');
		



		// $update_con = "UPDATE $dbname.users SET confirmed=1 WHERE username='$username' AND confirmcode='$confirmcode'";
		// if ($conn->exec($update_con))
		// {

			// $login_message = "Your account is active! You can now login!";
			// $_SESSION['message'] = $login_message;
			
		// }
		// else
		// {
		// 	$_SESSION['error'] = "Error Authenticating";
		// }
		// header('Location: ../index.php');

		// else
		// {
		// 	$error = "Problem Authenticating";
		// 	$_SESSION['error'] = $error;
		// 	header('Location: ../index.php');
		// }
	}
	
?>

<!-- http://localhost:8080/Users/reset_user.php?email=$email&code_1=$code_1&code_2=$code_2  -->
<!DOCTYPE html>
<html>
<head>
	<?php include_once("../base.php"); ?>
	<title>Reset Password</title>
	<link rel="stylesheet" type ="text/css" href="/Users/reg_style.css">
	<link rel="stylesheet" type ="text/css" href="template_style.css">
</head>
<body>
	<?php include_once('../sizebar_template.php') ?>
	<div class="header">
		<h2>Reset Password</h2>
	</div>

	<form method="post"  id="regform">
		<?php include('reg_errors.php'); ?>
		<div class="input-group">
			<label>New Password</label>
			<input type="password" name="new_password" pattern="[^()/><\][\\\x22,;|]+" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{4,}[^()/><\][\\\x22,;|]+" title="Password must contain at least one number and one uppercase and lowercase letter, and at least 4 or more characters">
		</div>
		<div class="input-group">
			<label>Confirm Password</label>
			<input type="password" name="con_password" pattern="[^()/><\][\\\x22,;|]+" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{4,}[^()/><\][\\\x22,;|]+" title="Password must contain at least one number and one uppercase and lowercase letter, and at least 4 or more characters">
		</div>
		<div class="input-group">
			<button type="submit" name="reset" class="btn">Reset</button>
		</div>

		<br />
		<p>
			Not yet a member? <a href="/Users/register.php">Sign up</a>
		</p>
	</form>
	<?php include_once('../footer_template.php'); ?>
</body>

</html>