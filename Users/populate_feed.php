<?php
	require('connect_database.php');
	$allcomment =  $conn->prepare("SELECT * FROM $dbname.comments");
	$allcomment->execute();
	$ret = $allcomment->fetchAll();
	// print_r($ret);

	foreach ($ret as $value) {
		if ($value['transport'] == 0)
			$trans = "train.php";
		else if ($value['transport'] == 1)
			$trans = "bus.php";
		else if ($value['transport'] == 2)
			$trans = "taxi.php";
		
		if ($value['type'] == 1)
			$type = "Users/stopped.php";
		else if ($value['type'] == 2)
			$type = "Users/traffic.php";
		else if ($value['type'] == 0)
			$type = "Users/danger.jpeg";
		$comment = $value['comment'];
		echo ("<div>
				
				<img style='width:20%' src=$type alt=$type>
				<img style='width:20%' src=$trans alt=$trans>
				<p>$comment</p>
				<>
			</div>");
		// print($value['comment']);
	}
?>

<!-- Array ( 
	[0] => Array ( [comment_id] => 1 [transport] => 0 [type] => 1 [comment] => Train has Stopped! [comment_date] => 2018-11-16 09:48:10 ) 
	[1] => Array ( [comment_id] => 2 [transport] => 1 [type] => 2 [comment] => Bus is moving slow, heavy Traffic! [comment_date] => 2018-11-16 09:48:59 ) 
	[2] => Array ( [comment_id] => 3 [transport] => 2 [type] => 0 [comment] => Taxi Violence! [comment_date] => 2018-11-16 09:50:17 ) ) -->