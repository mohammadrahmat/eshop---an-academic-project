<!DOCTYPE html>
<?php
	include('database.php');
?>
<html>
  <head>
	<link rel="stylesheet" href="css/style.css"/>
  <?php
	if(!isset($_SESSION))
			session_start();
	if(!isset($_SESSION['loggedIn']) || $_SESSION['loggedIn'] === 0){
		$_SESSION['loggedIn'] = 0;
		$_SESSION['name'] = "<a href='login.php'>Login</a>";
	}
	if(isset($_GET['logout'])){
		if($_GET['logout'] == 'yes'){
			$_SESSION['name'] = "<a href='login.php'>Login</a>";
			$_SESSION['loggedIn'] = 0;
			$_SESSION['user_id'] = null;
			unset($_SESSION['cart_array']);
			unset($_SESSION['user_rank']);
		}
	}
			if($_SESSION['loggedIn']!=1 && $_SESSION['loggedIn']!=2){
				$_SESSION['loggedIn'] = 0;
			}
				if(isset($_POST['email']))
					$email = $_POST['email'];
					
				if(isset($_POST['password']))
					$pass = $_POST['password'];
	
  ?>
	<title>
      eShop - Login
    </title>
    <link rel="stylesheet" href="css/style.css">
  </head>
	<?php include('header.php'); 
		$connection = new mysqli($servername, $username, $password, $dbname);
		$sql = "SELECT a.user_id, a.user_mail, a.user_pass, a.user_name, a.user_rank FROM user a WHERE a.user_mail='".$email."' AND a.user_pass='".$pass."'";
		$result = $connection->query($sql);
		$row = $result->num_rows;
		$getData = $result->fetch_assoc();
		if($row === 1){
			$_SESSION['name'] = $getData['user_name'];
			$_SESSION['loggedIn'] = 1;
			$_SESSION['user_id'] = $getData['user_id'];
			$_SESSION['user_rank'] = $getData['user_rank'];
		}
	if($_SESSION['loggedIn']===0){
		echo "<div id='wrap'><form method='post' action='login.php'><fieldset style='width:20%'><legend><h4>Login</h4></legend><p>Email</p><br><input type='text' name='email' placeholder='example@domain.com'/>";
		echo "<br><p>Password</p><br><input type='password' name='password'/><br><h6><a href='reset.php'>FORGOT PASSWORD</a> <a href='register.php' style='float:right;'>REGISTER</></h6><br><input type='submit' value='Login' class='button'/></fieldset></form></div>";
	}
	else if($_SESSION['loggedIn']===1){
		echo "<div><center><h4>Logged In Successfully. Welcome to eShop ".$_SESSION['name']."</h4></center>";
		$_SESSION['loggedIn']=2;
		echo "<center><h4>Redirecting.......</h4></center></div>";
		$_SESSION['name'] = $getData['user_name']." [<a href='login.php?logout=yes'>Logout</a>]";
		if($_SESSION['user_rank']==1){
			header("refresh:3;url=admin.php");
			die();
		}
		else{
			if($_SESSION['log']===1){
				header( "refresh:3;url=checkout.php" );
				die();
			}
			else{
				header( "refresh:3;url=index.php" );
				die();
			}
		}
	}
	else if($_SESSION['loggedIn']===2){
		echo "<div><center><h4>You are already logged in as ".$_SESSION['name']."</h4><br><h5><a href='login.php?logout=yes'>Logout</a></h5></center></div>";
	}
	?>
	<div id="footer">
		<p><em>&copy;2014 <a href="index.html" title="eShop">eShop</a>. All rights reserved. Designed by Mohammad Rahmat</em></p>
	</div>
  </body>
</html>