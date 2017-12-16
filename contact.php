<!DOCTYPE HTML>
<?php
include('database.php');
?>
<html>
	<head>
		<title>
		eShop - About Us
		</title>
		<link rel="stylesheet" href="css/style.css"/>
		<?php
			$send=0;
			if(isset($_POST['send'])){
				$send=1;
				$name=$_POST['name'];
				$email=$_POST['email'];
				$subject=$_POST['subject'];
				$message=$_POST['message'];
			}
			if($send===1){
				mail('mrahmat1991@hotmail.com','$subject','FROM '.$name.' ,\r\n'.$message);
			}
		?>
	</head>
	<body>
		<?php
			include 'header.php';
			if($send===1)
				echo "<center><h4>Message Sent. We will reply as soon as possible.</h4></center>";
				$send=0;
		?>
		
		<form action="contact.php" method="post">
			<fieldset style='width:30%;'>
				<legend><h4>Contact Us</h4></legend>
				<p>Name</p>
					<br>
				<input type="text" name="name" required/>
					<br>
				<p>Email</p>
					<br>
				<input type="text" placeholder="example@domain.com" name="email" required/>
					<br>
				<p>Subject</p>
					<br>
				<input type="text" name="subject" required/>
					<br>
				<p>Message</p>
					<br>
				<textarea rows="4" cols="50" name="message"></textarea>
					<br>
					<br>
				<input type="hidden" name="send" value="1"/>
				<input type="submit" value="SEND" class="button"/>
			</fieldset>
				
		</form>
		<div id="footer">
			<p><em>&copy;2014 <a href="index.html" title="eShop">eShop</a>. All rights reserved. Designed by Mohammad Rahmat</em></p>
		</div>
	
	</body>
</html>