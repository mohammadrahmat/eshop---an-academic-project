<!DOCTYPE html>
<?php
	include('database.php');
?>
<html>
	<head>
		<title>eShop - Recover Password</title>
		<link rel="stylesheet" href="css/style.css"/>
		<?php
			if(!isset($_SESSION))
				session_start();
			$infoProvided=0;
			$status="";
			if(isset($_POST['ok'])){
				$infoProvided=1;
				$nameEntered=$_POST['name'];
				$emailEntered=$_POST['email'];
				$addEntered=$_POST['add'];
				$phoneEntered=(int)$_POST['phone'];
				$bdayEntered=$_POST['bday'];
				$pass1Entered=$_POST['pass'];
				$pass2Entered=$_POST['passConf'];
				if($pass1Entered != $pass2Entered){
					$infoProvided = 2;
					$status="PASSWORDS DO NOT MATCH";
				}
				else if($pass1Entered != "" && $pass1Entered == $pass2Entered){
					$status="REGISTERED SUCCESSFULLY, YOU CAN NOW LOGIN USING YOUR DETAILS.";
				}
			}
			if($infoProvided===1){
				$connection = new mysqli($servername, $username, $password, $dbname);
				$connection->query("INSERT INTO `user` (`user_name`, `user_pass`, `user_mail`, `user_phone`, `user_add`, `user_birth`, `user_rank`) VALUES ('$nameEntered', '$pass1Entered', '$emailEntered', $phoneEntered, '$addEntered', '$bdayEntered', '0' )");
				$new_id = $connection->insert_id;	
				$connection->query("INSERT INTO `user_image` (`user_image_url`, `user_id`) VALUES ('http://s25.postimg.org/fy6hd4lzz/no_image.png', $new_id)");
				$connection->close();
			}
			
		?>
	</head>
	<body>
		<?php
			include('header.php');
			if($infoProvided===0){
		?>
		<form method="post" action="register.php">
			<fieldset style='width:20%;'>
				<legend><h4>Please Enter Your Details</h4></legend>
				FULL NAME <br/>
				<input type='text' name='name' required/> <br/>
				E-Mail <br/>
				<input type='text' name='email' placeholder='example@domain.com' required/><br/>
				ADDRESS <br/>
				<input type='text' name='add' required/> <br/>
				PHONE <br/>
				<input type='text' name='phone' required/> <br/>
				DATE OF BIRTH <br/>
				<input type='date' name='bday' max='1996-01-01' required/><br/>
				PASSWORD <br/>
				<input type='password' name='pass' required/><br/>
				CONFIRM PASSWORD <br/>
				<input type='password' name='passConf' required/><br/><br/>
				<input type='hidden' name='ok'/>
				<center><input type='submit' value='REGISTER' class='button'/></center>
			</fieldset>
		</form>
		<?php
			}
			else{
				echo "<center><h4>".$status."</h4></center>";
				if($infoProvided===1){
					header( "refresh:3;url=index.php" );
					$infoProvided=0;
					die();
				}
				else if($infoProvided===2){
					header( "refresh:3;url=register.php" );
					$infoProvided=0;
					die();
				}
			}
		?>
		
		<div id="footer">
			<p><em>&copy;2014 <a href="index.html" title="eShop">eShop</a>. All rights reserved. Designed by Mohammad Rahmat</em></p>
		</div>
	</body>
</html>