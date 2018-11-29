<!DOCTYPE html>
<html>
<head>
	<?php include_once("base.php"); ?>
	<meta name="viewport" content="width=device-width, initial-scale=0.5">
	<link rel="stylesheet" type ="text/css" href="template_style.css">
</head>
<body>
	<div class="Theheader" style="width: 100%;">
	<a href="/index.php" style="text-decoration: none; color:White;">
		<h1 class="CamagruStyle">Carma</h1>
	</a>
		<?php if (isset($_SESSION['username'])): ?>
			<p class="Weloutbut" style="text-align: Center;">Welcome <strong><?php echo $_SESSION['firstname']; ?></strong></p>
					
		<?php endif ?>	
	</div>
</body>
</html>