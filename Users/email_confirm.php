
<?php
	session_start();
	require('connect_database.php');

	$username = $_GET['username'];
	$confirmcode = $_GET['code'];

	$query = $conn->prepare("SELECT * FROM $dbname.users WHERE username = :usr AND confirmcode = :con ");
	$query->execute(["usr"=>$username , "con"=>$confirmcode]);
	$result = $query->fetchAll();

		
	if (count($result) == 1)
	{
	
			$login_message = "Your account is active! You can now login!";
			$_SESSION['message'] = $login_message;

		header('Location: ../index.php');
	}
	else
	{
		$error = "Problem Authenticating";
		$_SESSION['error'] = $error;
		header('Location: ../index.php');
	}
?>
