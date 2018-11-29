<!DOCTYPE html>
<?php include_once("../base.php"); ?>
<?php include('../server.php'); ?>


<?php

	// if (!$_SESSION)
	// 	header('Location: ../../index.php');
	include('connect_database.php');
?>

<html>
<head>
	<title>Account Settings</title>
	<link rel="stylesheet" type ="text/css" href="/Users/reg_style.css">
	<link rel="stylesheet" type ="text/css" href="/template_style.css">
</head>
<body>
	<?php include_once('../sizebar_template.php') ?>
	<div class="account_settings">
		<h2>Account Settings</h2>
	</div>

	<div id="regform" style="width: 60%;">
		<a href="/Users/account_settings/ac_settings_gen.php" style="text-decoration: none;" >
			<div class="ac_setting_btn">
				<p>General</p>
			</div>
		</a>
		<a href="/Users/account_settings/ac_settings_psw.php" style="text-decoration: none;" >
			<div class="ac_setting_btn">
				<p>Password</p>
			</div>
		</a>
	</div>
	
	<?php include_once('../footer_template.php'); ?>
</body>

</html>




	<!-- 
		<div id="regform" style="width: 60%;">
		<div style="width: 20%;"  >
			<a href="/Users/account_settings/ac_settings_gen.php" >
				<div class="ac_setting_btn">
					<p>General</p>
				</div>
			</a>
			<a href="/Users/account_settings/ac_settings_psw.php" >
				<div class="ac_setting_btn">
					<p>Username</p>
				</div>
			</a>
			<a href="/Users/account_settings/ac_settings_psw.php" >
				<div class="ac_setting_btn">
					<p>Personal</p>
				</div>
			</a>
			<a href="/Users/account_settings/ac_settings_psw.php" >
				<div class="ac_setting_btn">
					<p>Password</p>
				</div>
			</a>
		</div>
	
		 -->