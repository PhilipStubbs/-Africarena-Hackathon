<?php include_once('../server.php'); ?>
<?php

	require('connect_database.php');
	$errors = array();
	if (isset($_POST['email']))
	{
		array_push($errors, "Please Enter a vaild Email");
	}
	
	if (isset($_POST['email']) && !empty($_POST['email']))
	{
		
		$email = $_POST['email'];
		$findemail = $conn->prepare("SELECT confirmcode FROM $dbname.users WHERE email = :email");
		$findemail->execute(["email"=>$email]);
		$Theemail= $findemail->fetchAll();
		if (count($Theemail) != 1)
		{
			$_SESSION['error'] = "Error Sending Email";
			header('Location: ../index.php');
		}
		else
		{
			foreach ($Theemail as $tmp)
			{
				$code_1 = $tmp["confirmcode"];
			}
			$findname = $conn->prepare("SELECT firstname FROM $dbname.users WHERE email = :email AND confirmcode= :code");
			$findname->execute(["email"=>$email, "code"=>$code_1]);
			$Theename= $findname->fetchAll();
			if (count($Theename) != 1)
			{
				$_SESSION['error'] = "Error Sending Email";
				header('Location: ../index.php');
			}
			else {
				foreach ($Theemail as $tmp)
				{
					$code_2 = $tmp["firstname"];
				}
				$code_2 = hash("ripemd160", $code_2);


				$headers = "From: noreply@philipstubbs.co.za\r\n";
				$headers .= "Reply-To: noreply@philipstubbs.co.za\r\n";
				$headers .= "Return-Path: noreply@philipstubbs.co.za\r\n";
				$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
				// $headers .= "BCC: hidden@example.com\r\n";
				$message = " 
				<h1>Reset Your Account.</h1>
				Click the link below to Verify your account <br />
				<br />
					For <strong>Localhost Reset </strong> use the following : <br />
						http://localhost:8080/Users/reset_user.php?email=$email&code_1=$code_1 <br />
				<br />
					For  <strong>Server Reset </strong> use the following : <br />
						http://philipstubbs.co.za/Users/reset_user.php?email=$email&code_1=$code_1 <br />

				<h2>Good Luck</h2>
				";
				mail($email, "Reset Password", $message , $headers);
				$login_message = "Check Your Email for the Reset link";
				$_SESSION['message'] = $login_message;
				// session_destroy();
				header('Location: ../index.php');
			}
		}
	}
?>

<!DOCTYPE html>
	<?php include_once("../base.php"); ?>

<html>
<head>
	<title>Login</title>
	<link rel="stylesheet" type ="text/css" href="/Users/reg_style.css">
	<link rel="stylesheet" type ="text/css" href="template_style.css">
</head>
<body>
	<?php include_once('../sizebar_template.php') ?>
	<div class="header">
		<h2>Reset Password</h2>
	</div>

	<form method="post" action="/Users/cant_login.php" id="regform">
	<?php include('reg_errors.php'); ?>
		<div class="input-group">
			<label>Email</label>
			<input type="email" name="email" pattern="[^()/><\][\\\x22,;|]+">
		</div>
		<div class="input-group">
			<button type="submit" name="reset" class="btn">Send Email</button>
		</div>

		<br />
		<p>
			Not yet a member? <a href="/Users/register.php">Sign up</a>
		</p>
	</form>
	<?php include_once('../footer_template.php'); ?>
</body>

</html>