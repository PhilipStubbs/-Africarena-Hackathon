<!DOCTYPE html>
<?php include('../server.php'); ?>
<?php include_once("../base.php"); ?>
<html>
<head>
	<title>Set Route</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type ="text/css" href="css/main.css">
    
</head>
<body>
    <?php include_once('header_template.php') ?>
    <form>
        <div class="dest-wrapper">
            <div class="form-style">
                <div class="dest">
                    Work
                </div>
                <div class="dest">
                    Home
                </div>
                <label>Own Destination</label>
                <input type="search">
                <div class="check-wrapper">
                    <label><input type="checkbox" name="fast" value="0">Fastest </label>
                    <label> <input type="checkbox" name="cheap" value="1">Cheapest </label>
                </div>
                <input type="button" id="myBtn" name="gen_route" value="Get Route" onClick>
            </div>
        </div>
    </form>

    <div id="myModal" class="modal">
        <!-- Modal content -->
        
        <div class="modal-content">
            <span class="close">&times;</span>
            <div class=route_desc>
                <p>Walk to xyz</p>
                <p>Catch Taxi heading to xyz</p>
                <p>Walk to xyz</p>
            <div>
            <div class="estimation">
                <label>Trip Price:</label>
                <p>R 0</p>
            </div>
            <div class="estimation">
                <label>ETA:</label>
                <p>00:00</p>
            </div>
            <div class="form-style">
                <a href="Users/feed.php">
                    <div>
                        Start trip
                    </div>
                </a>
            </div>
        </div>
    </div>
    
    <!-- <div class="feed-wrapper">
    </div>
    <div class="alert">
            Alert
    </div> -->

<?php include_once("../footer_template.php"); ?>

</body>
<script 
	src="navbar.js">
</script>
<script 
	src="modal.js">
</script>

</html>