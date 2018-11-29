<?php
include('database.php');
if (isset($_POST['value']) && $_POST['value'] == $dbpassword)
{

	$deleteDB = " DROP DATABASE $dbname";
	
	$sqldb = "CREATE DATABASE $dbname";

	$users = "CREATE TABLE $dbname.users (
		id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
		username VARCHAR (255) UNIQUE,
		locLat VARCHAR (255),
		locLong VARCHAR (255),
		firstname VARCHAR (255),
		surname VARCHAR (255),
		email VARCHAR (255) UNIQUE,
		password VARCHAR (1024),
		confirmed BIT DEFAULT 0,
		confirmcode VARCHAR (1024),
		travelroute VARCHAR (8191),
		mode VARCHAR (8192),
		date TIMESTAMP)";

$driver = "CREATE TABLE $dbname.drivers (
	id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	reg VARCHAR (255) UNIQUE,
	vehicle VARCHAR (255),
	loc VARCHAR (255),
	cap INT,
	username VARCHAR (255) UNIQUE,
	firstname VARCHAR (255),
	surname VARCHAR (255),
	email VARCHAR (255) UNIQUE,
	password VARCHAR (1024),
	confirmed BIT DEFAULT 0,
	confirmcode VARCHAR (1024),
	date TIMESTAMP)";

$comments = "CREATE TABLE $dbname.comments (
	comment_id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	transport INT NOT NULL,
	type INT NOT NULL,
	comment LONGTEXT,
	comment_date TIMESTAMP NOT NULL default CURRENT_TIMESTAMP)";

	$conn->exec($deleteDB);


	if ($conn->exec($sqldb))
	{
		echo "Database created successfully\n ".rand(0,100)."<BR /> ";
		$conn->exec($users);
		echo "User Table created successfully\n <BR />";
		$conn->exec($driver);
		echo "User Table created successfully\n <BR />";
	
	}
	else
	{
		echo "Error creating database: " . $conn->error;
	}
}
?>

<html>
<head>
	<title>Database Controls</title>
	<?php include_once("../base.php"); ?>
	<link rel="stylesheet" type ="text/css" href="./Users/reg_style.css">
</head>
<body>
	<div class="header">
		<h1>Database Controls</h1>
		<h2>Reset Database?</h2>
	</div>

		<form method="post" action="" id="regform">
		<div >
			<center>
				<h3> Enter Database Password? </h3>				
				<input type="password" name="value">
				<input type="submit">
			</center>
		</div>
		</form>
</body>
</html>