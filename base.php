<?php
	$actual_link = "$_SERVER[HTTP_HOST]";
	$type = $_SERVER['SERVER_PROTOCOL'];
	
	// if (substr($type,0, 5) == "HTTP/")
	// 	$full_link = "http://".$actual_link;
	// else if (substr($type,0, 5) == "HTTPS")
	// 	$full_link = "https://".$actual_link;
	if ($actual_link == "philipstubbs.co.za")
		$full_link = "https://".$actual_link;
	else
		$full_link = "http://".$actual_link;

	$base = "<base href=" . "\"".$full_link . "\">" ;
	echo ($base);
	
?>