<!DOCTYPE html>

<html>

<head>
<meta charset="utf-8">
	<?php include_once("base.php"); ?>
	<link rel="stylesheet" type ="text/css" href="./Users/reg_style.css">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type ="text/css" href="template_style.css">
</head>
<body>
<script>
	function toggle() {
		var el = document.getElementById("clickit");
		if (el.style.display == "block")
			el.style.display = "none";
		else
			el.style.display = "block";
	}
</script>
<button onclick="toggle()" style="z-index: 3; padding: 2%; position: absolute; bottom: 20px; left: 5px; position: fixed;">Menu</button>
<ul id="clickit">
	<li><a class="active" href="index.php"><p>Home</p></a></li>
	<?php if (!isset($_SESSION['username'])): ?>
		<li><a href="/Users/login.php?"><p>Login</p></a></li>
		<li><a href="/Users/register.php? " ><p>Register</p></a></li>
	<?php endif ?>

	<?php if (isset($_SESSION['username'])): ?>
		<li><a href="?" ><p>Rate</p></a></li>
		<li><a href="?" ><p>Trip</p></a></li>
		<li><a href="Users/account_settings.php"><p>Account</p></a></li>
		<li><a href="/index.php?logout='1'" ><p>Logout</p></a></li>
	<?php endif ?>
</ul>



</body>
</html>





