<!DOCTYPE html>
<?php
	include('database.php');
?>
<html>
	<head>
		<title>eShop - Recover Password</title>
		<link rel="stylesheet" href="css/style.css"/>
		<?php
			$infoProvided=0;
			if(isset($_POST['email'])){
				$infoProvided=1;
				$emailEntered=$_POST['email'];
			}
			if($infoProvided===1){
				$connection = new mysqli($servername, $username, $password, $dbname);
				$result = $connection->query("SELECT a.user_pass, a.user_name FROM user a WHERE a.user_mail='".$emailEntered."'");
				$getData = $result->fetch_assoc();
				$connection->close();
				if(count($getData)<1){
					$toEcho = "No Associated Account Was Found For Entered EMAIL.";
				}
				else{
					$msg = "Hello ".$getData['user_name'].",\r\n You Requested Password Recovery. \r\n Your Password Is : ".$getData['user_pass'];
					mail($emailEntered,"no-reply @ eShop Password Recovery",$getData['user_pass']);
					$toEcho = "Password Recovery Request Taken, You Will Receive A Notification Shortly By EMAIL.";
				}
			}
		?>
	</head>
	<body>
		<?php
			include('header.php');
			if($infoProvided===0){
		?>
		<br/><br/><br/>
		<form method="post" action="reset.php">
			<fieldset>
				<legend><h4>Please Enter E-mail Adress Associated With Your Account</h4></legend>
				<br/><br/>
				<center><input type='text' name='email' placeholder='email@domain.com'/></center>
				<input type='submit' class='button' value='Recover' style='float:right;'/>
			</fieldset>
		</form>
		<?php
			}
			else if($infoProvided===1){
				echo "<center><h4>".$toEcho."<br/>Redirecting.....</h4></center>";
				$infoProvided=1;
				header( "refresh:3;url=login.php" );
				die();
			}
		?>
		<div id="footer">
			<p><em>&copy;2014 <a href="index.html" title="eShop">eShop</a>. All rights reserved. Designed by Mohammad Rahmat</em></p>
		</div>
	</body>
</html>