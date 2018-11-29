<?php
	require('Users/server.php');
	require_once('connect_database.php');
?>

<?php

	file_put_contents("UpdateDog", serialize($_POST));
?>