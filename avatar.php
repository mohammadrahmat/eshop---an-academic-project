<!DOCTYPE HTML>
<?php
include('database.php');
?>
<html>
	<head>
		<title>
		eShop - Change Avatar
		</title>
		<link rel="stylesheet" href="css/style.css">
	</head>
	<body>
		<?php
			include 'header.php';
		?>
		<form method="post" action="profile.php">
			<fieldset>
				<legend><h4>Please enter link to your avatar</h4></legend>
				<input type="hidden" value="1" name="change"/>
				<center><input type="text" name="new_image" required/><br/><br/></center>
				<center><input type="submit" class="button" value="Change"/></center>
			</fieldset>
		</form>
		<div id="footer">
			<p><em>&copy;2014 <a href="index.html" title="eShop">eShop</a>. All rights reserved. Designed by Mohammad Rahmat</em></p>
		</div>
	
	</body>
</html>