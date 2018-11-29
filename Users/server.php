<?php

	require_once('connect_database.php');
	session_start();

	$username = "";
	$firstname = "";
	$surname = "";
	$email = "";
	$errors = array();

	if (isset($_POST['reg_user']))
	{
		$secret = '';
		if (isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response']) && !is_null($_POST['g-recaptcha-response']))
		{
			$response = $_POST["g-recaptcha-response"];
			$url = 'https://www.google.com/recaptcha/api/siteverify';
			$data = array(
				'secret' => '',
				'response' => $_POST["g-recaptcha-response"]
			);
			$options = array(
				'http' => array (
					'method' => 'POST',
					'content' => http_build_query($data)
				));
			$context  = stream_context_create($options);
			$verify = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret={$secret}&response={$response}");
			$captcha_success=json_decode($verify);
			if ($captcha_success->success==false) {
				array_push($errors, "reCAPTCHA Error, Please try again");
			}
		}
		else
		{
			array_push($errors, "Are you a Robot? Confirm to proceed.");
		}

		$username = $_POST['username'];
		$firstname = $_POST['firstname'];
		$surname = $_POST['surname'];
		$email = $_POST['email'];
		$password_1 = $_POST['password_1'];
		$password_2 = $_POST['password_2'];
		
		$usercheck = $conn->prepare("SELECT * FROM $dbname.users WHERE username = :usr");
		$usercheck->execute(["usr"=>$username]);
		$result_1 = $usercheck->fetchAll();

		$emailcheck = $conn->prepare("SELECT * FROM $dbname.users WHERE email = :eml");
		$emailcheck->execute(["eml"=>$email]);
		$result_2 = $emailcheck->fetchAll();

		if (count($result_1) > 0)
			array_push($errors, "'$username' already in use");
		if (count($result_2) > 0)
			array_push($errors, "'$email' is already in use");
		if (empty($username))
			array_push($errors, "Username is required");
		if (empty($firstname))
			array_push($errors, "Firstname is required");
		if (empty($surname))
			array_push($errors, "Surname is required");
		if (empty($email))
			array_push($errors, "Email is required");
		if (empty($password_1) || empty($password_2))
			array_push($errors, "Password is required");
		if ($password_1 != $password_2)
			array_push($errors, "Passwords do not match");
	
		if (!preg_match("#[0-9]+#", $password_1)) {
			array_push($errors, "Password must include at least one number!");
		}
		if (!preg_match("#[A-Z]+#", $password_1)) {
			array_push($errors,"Password must include at least one uppercase letter!");
		} 
		if (!preg_match("#[a-z]+#", $password_1)) {
			array_push($errors,"Password must include at least one lowercase letter!");
		} 

		if (count($errors) == 0)
		{
			$password = hash("whirlpool", $password_1);
			$bool = 1;

			$confirmcode = hash("ripemd160", $username);
			$insert = "INSERT INTO $dbname.users (username, firstname, surname, email, password, confirmcode, confirmed) 
						VALUES('$username', '$firstname', '$surname', '$email', '$password', '$confirmcode', $bool)";
			$conn->exec($insert);

			// $headers = "From: noreply@philipstubbs.co.za"  . "\r\n"l


			$headers = "From: noreply@philipstubbs.co.za\r\n";
			$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
			// $headers .= "BCC: hidden@example.com\r\n";


			$message = " 
			<h1>Activate Your Account.</h1>
			Click the link below to Verify your account <br />
			<br />
				For <strong>Localhost Activation </strong> use the following : <br />
					http://localhost:8080/Users/email_confirm.php?username=$username&code=$confirmcode <br />
			<br />
				For  <strong>Server Activation </strong> use the following : <br />
					http://philipstubbs.co.za/Users/email_confirm.php?username=$username&code=$confirmcode <br />

			<h2>Enjoy</h2>
			";
			mail($email, "Activation email", $message , $headers);
			$login_message = "Check Your Email for the Activation link";
			$_SESSION['message'] = $login_message;
			header('Location: ../index.php');
		}
	}

	if (isset($_POST['GPSUpdate']))
	{

		$username = $_POST["user"];
		$lat = $_POST["lat"];
		$long = $_POST["long"];
		
		$sql = "UPDATE users SET locLat='$lat', locLong='$long' WHERE username='$username'";

		$servername = "";
		$dbuser = "";
		$dbpassword = "";
		$dbname = "hackerthon_db";

		try {
			$conn = new PDO("mysql:host=$servername;dbname=$dbname", $dbuser, $dbpassword);
			// set the PDO error mode to exception
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

			// Prepare statement
			$stmt = $conn->prepare($sql);
			file_put_contents("Updatefog", "$username $lat $long");

			// execute the query
			$stmt->execute();
			file_put_contents("UpdateLog", "$username $lat $long");
		}
		catch(PDOException $e)
		{
			file_put_contents("UpdateLogError", $e->getMessage);
		}

		try {
			$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
			// set the PDO error mode to exception
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		
			$sql = "UPDATE MyGuests SET lastname='Doe' WHERE id=2";
		
			// Prepare statement
			$stmt = $conn->prepare($sql);
		
			// execute the query
			$stmt->execute();
		
			// echo a message to say the UPDATE succeeded
			echo $stmt->rowCount() . " records UPDATED successfully";
			}
		catch(PDOException $e)
			{
			echo $sql . "<br>" . $e->getMessage();
			}
	}

	if (isset($_POST['login']))
	{
		$username = $_POST['username'];
		$password = $_POST['password'];

		if (empty($username))
		{
			array_push($errors, "Username is required");
		}
		if (empty($password))
		{
			array_push($errors, "Password is required");
		}
	
		if (count($errors) == 0)
		{


			$password = hash("whirlpool", $password);
			$bool = 1;
	
			$query = $conn->prepare("SELECT * FROM $dbname.users WHERE username = :usr AND password = :psw");
			$query->execute(["usr"=>$username, "psw"=>$password]);
			$result = $query->fetchAll();
			
			$is_confirm = $conn->prepare("SELECT * FROM $dbname.users WHERE username= :usr AND password = :psw AND confirmed = :boo");
			$is_confirm->execute(["usr"=>$username, "psw"=>$password, "boo"=>$bool]);
			$is_confirmed_res = $is_confirm->fetchAll();

			if (count($result) == 1 && count($is_confirmed_res) == 1)
			{
				$findfirstname =  $conn->prepare("SELECT firstname FROM $dbname.users WHERE username = :usr AND password = :psw");
				$findfirstname->execute(["usr"=>$username, "psw"=>$password]);
				$Thefirstname = $findfirstname->fetchAll();

				$findsurname = $conn->prepare("SELECT surname FROM $dbname.users WHERE username = :usr AND password = :psw");
				$findsurname->execute(["usr"=>$username, "psw"=>$password]);
				$Theesurname= $findsurname->fetchAll();

				$findemail = $conn->prepare("SELECT email FROM $dbname.users WHERE username = :usr AND password = :psw");
				$findemail->execute(["usr"=>$username, "psw"=>$password]);
				$Theemail= $findemail->fetchAll();
				

				foreach ($Thefirstname as $tmp)
				{
					$firstname = $tmp["firstname"];
				}
				foreach ($Theemail as $tmp)
				{
					$email = $tmp["email"];
				}
				foreach ($Theesurname as $tmp)
				{
					$surname = $tmp["surname"];
				}

				$_SESSION['username'] = $username;
				$_SESSION['firstname'] = ucwords($firstname);
				$_SESSION['surname'] = ucwords($surname);
				$_SESSION['email'] = $email;
				$login_message = "You are now logged in";
				$_SESSION['message'] = $login_message;
				header('Location: ../index.php');
			}
			else if (count($result) == 0)
			{
				array_push($errors, "The Username/Password is incorrect");
			}
			else if (count($result) == 1 && count($is_confirmed_res) == 0)
			{
				array_push($errors, "Account is not active! Check your email.");
			}
			else 
			{
				array_push($errors, "ERROR");
			}
		}
	}

	if (isset($_GET['logout']))
	{
		session_destroy();
		unset($_SESSION['username']);
		unset($_SESSION['firstname']);
		unset($_SESSION['email']);
		header('location: index.php');
	}
	
?>