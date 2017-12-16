<!DOCTYPE html>
<?php
	include('database.php');
?>
<html>
	<head>
		<link rel="stylesheet" href="css/style.css">
	</head>
	  <?php
			if(!isset($_SESSION))
				session_start();
			$change=0;
			if(isset($_POST['change']))
				$change=1;
			$connection = new mysqli($servername, $username, $password, $dbname);
			if(isset($_POST['new_image']) && $change===1){
				$new_image = $_POST['new_image'];
				$connection->query("UPDATE `user_image` SET `user_image_url`='".$new_image."' WHERE `user_id`=".$_SESSION['user_id']."");
				$change=0;
			}
			$personID = $_SESSION['user_id'];
			$_SESSION['edit'] = 0;
			if(isset($_POST['valueChanger1']))
				$_SESSION['edit'] = 1;
			if(isset($_POST['valueCanceller'])){
				$_SESSION['edit'] = 0;
			}
			$sql = "SELECT a.user_name, a.user_mail, a.user_pass, a.user_add, a.user_phone, a.user_birth, b.user_image_url\n"
			. "FROM user a, user_image b\n"
			. "WHERE a.user_id=b.user_id AND a.user_id = ".$personID."";
			;	
			
			$result = $connection->query($sql);
			if ($result->num_rows > 0) {
				while($row = $result->fetch_assoc()) {
					$user_name = $row['user_name'];
					$user_email = $row['user_mail'];
					$user_pass = $row['user_pass'];
					$user_add = $row['user_add'];
					$user_birth = $row['user_birth'];
					$user_phone = $row['user_phone'];
					$user_photo = $row['user_image_url'];
				}
			}
			
			if(isset($_POST['valueChanger0'])){
				$_SESSION['edit'] = 0;
				$new_name=$_POST['name'];
				$new_email=$_POST['email'];
				$new_add=$_POST['address'];
				$new_phone=$_POST['phone'];
				$old_pass=$_POST['current_pass'];
				$new_pass=$_POST['new_pass'];
				if($old_pass === $user_pass){
					if($new_pass!=""){
						$sql = "UPDATE user SET user_name='".$new_name."', user_pass='".$new_pass."', user_mail='".$new_email."', user_phone=".$new_phone.", user_add='".$new_add."' WHERE user_id=".$_SESSION['user_id']."";
					}
					else{
						$sql = "UPDATE user SET user_name='".$new_name."', user_pass='".$old_pass."', user_mail='".$new_email."', user_phone=".$new_phone.", user_add='".$new_add."' WHERE user_id=".$_SESSION['user_id']."";
					}
					$connection->query($sql);
					$msg = "SUCCESSFULLY CHANGED INFORMATION.";
				}
				else
					$msg = "CURRENT PASSWORD WRONG.";
			}
			
			$connection->close();
	?>	
	<body>	
	
		<?php
		include('header.php');
		?>
		
		<div id="wrap">
			<center><h4>
			<?php
				if(isset($_POST['valueChanger0'])){
					if($_SESSION['edit']===0)
						echo $msg;
				}
			?></h4>
			</center>
			<form method="post" action="profile.php">
			<div class="box">
				<center><h4>Profile Panel</h4>
				<?php echo "<img src='".$user_photo."' width='50%' height='50%'/>";
				?>
				<br/> <a href='avatar.php'>Change Avatar</a>
				</center>
			</div>
			<div class="box">
				
					<?php if ($_SESSION['edit'] === 0){ 
					
					?>
						<h4>Personal Details</h4><br><br>
						<table class="pTable">
							<tr>
								<?php echo "<td>Name</td><td>$user_name</td>"; ?>
							</tr>
							<tr>
								<?php echo "<td>E-mail</td><td>$user_email</td>"; ?>
							</tr>
							<tr>
								<?php echo "<td>Address</td><td>$user_add</td>"; ?>
							</tr>
							<tr>
								<?php echo "<td>Birthday</td><td>$user_birth</td>"; ?>
							</tr>
							<tr>
								<?php echo "<td>Telephone</td><td>$user_phone</td>"; ?>
							</tr>
						</table>
					<?php } 
						else if($_SESSION['edit'] === 1){
					?>
					<div style="width:90%;margin:0 auto;">
						<br/><br/><br/><br/>
						Name:<br/>
						<input type='text' name='name' value="<?php echo $user_name;?>"/><br/>
						E-Mail:<br/>
						<input type='text' name='email' value="<?php echo $user_email;?>" /><br/>
						Address:<br/>
						<input type='text' name='address' value="<?php echo $user_add;?>"/>
						<?php } ?>
					</div>
						
					
						
					
				
			</div>
			<div class="box">
						<?php if($_SESSION['edit'] === 0){ ?>
							
						<?php } ?>
						<?php if($_SESSION['edit'] === 1){ ?>
				<div style="width:90%;margin:0 auto;">
						<br/><br/><br/><br/>
						Telephon:<br/>
						<input type='text' name='phone' value="<?php echo $user_phone;?>"/><br/>
						Current Pass:<br/>
						<input type='password' name='current_pass'/><br/>
						New Pass:<br/>
						<input type='password' name='new_pass'/>
				</div>
						<?php } ?>
			</div>
			<div style="clear:both">
			</div>
				<?php if($_SESSION['edit'] === 0){ ?>
					<input type="hidden" name="valueChanger1" value="1"/>
					<input type="submit" class="button" value="EDIT" style="float:right;"/>
				<?php } else if($_SESSION['edit'] ===1){?>
					<input type="hidden" name="valueChanger0" value="0"/>
					<input type="submit" class="button" value="SAVE" style="float:right;"/>
						
				
			</form>
						<form method="post" action="profile.php">
							<input type="hidden" name="valueCanceller" value="0"/>
							<input type="submit" class="button" value="CANCEL" style="float:right;"/>
						</form>
						<?php } ?>
		</div>
		
		
		<div id="footer">
			<p><em>&copy;2014 <a href="index.html" title="eShop">eShop</a>. All rights reserved. Designed by Mohammad Rahmat</em></p>
		</div>
	
	</body>
</html>