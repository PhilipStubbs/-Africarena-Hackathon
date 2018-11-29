<!DOCTYPE html>
<?php include('../server.php'); ?>
<?php include_once("../base.php"); ?>
<html>
<head>
	<title>Feed</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type ="text/css" href="css/main.css">
</head>
<body>
    <?php include_once('header_template.php') ?>
    <div class="mode-wrapper">
        <div class="mode">
            Train
        </div>
        <div class="mode">
            Bus
        </div>
        <div class="mode">
            Taxi
        </div>
        <div class="mode">
            Walk
        </div>
    </div>
    <div class="feed-wrapper">
	<?php include('populate_feed.php')?>
    </div>
    <div class="alert">
            Alert
    </div>
</body>
<?php include_once("../footer_template.php"); ?>
<script 
	src="navbar.js">
</script>

</html>