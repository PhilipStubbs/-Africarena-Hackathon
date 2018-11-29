<!DOCTYPE html>
<?php include('../server.php'); ?>
<?php include_once("../base.php"); ?>
<html>
<head>
	<title>Alerts</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type ="text/css" href="css/main.css">
</head>
<body>
    <?php include_once('header_template.php') ?>
    <form>
        <div class='form-style'>
          <label>Description</label>
          <input type="text" name="description" placeholder="Optional" pattern="[^()/><\][\\\x22,;|]+">
        </div>
    </form>
    <table class="alert-table">
        <tr>
            <td>
                <div class="alert-btn">Danger<div>
            </td>
            <td>
                <div class="alert-btn">Stopped<div>
            </td>
        </tr>
        <tr>
            <td>
                <div class="alert-btn">Traffic<div>
            </td>
            <td>
               <div class="alert-btn">Fire<div>
            </td>
        </tr>
    </table>
</body>
<?php include_once("../footer_template.php"); ?>
<script 
	src="navbar.js">
</script>

</html>