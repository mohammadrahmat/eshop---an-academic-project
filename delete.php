<?php
	include('database.php');
	$connection = new mysqli($servername, $username, $password, $dbname);
	if(!isset($_SESSION))
			session_start();
	$h=0;
	if(isset($_SESSION['name']) && $_SESSION['name'] != "<a href='login.php'>Login</a>"){
		$h=1;
	}
?>
<html>
	<head>
		<link rel="stylesheet" href="css/style.css"/>
		<?php
			$remove=0;
			if(isset($_POST['remove'])){
				$remove = $_POST['remove'];
				$item_id = $_POST['item_id'];
				$connection->query("DELETE FROM `item` WHERE `item_id`='$item_id'");
				$connection->query("DELETE FROM `item_image` WHERE `item_id`='$item_id'");
			}
		?>
	</head>
	<body>
		<center>
			<img src="http://s25.postimg.org/gfic79k67/eshop.png" width="800px" height="200px"/>
		</center>
		<?php
			if($_SESSION['user_rank']!=1){
				echo "<br/><br/><br/><center><h4>YOU DO NOT HAVE PERMISSION TO ACCESS THIS PAGE<br/><br/><br/><br/><a href='index.php'>GO BACK TO eShop MAINPAGE</a></h4></center>";
			}
			else{
			?>
			<div id="menu">
      <ul class="navigation">
        <li>
          <a href="index.php" >
            HOMEPAGE
          </a>
        </li>
        <li>
          <a href="add.php">
            ADD
          </a>
        </li>
        <li>
          <a href="admin.php">
            ADMIN PANEL
          </a>
        </li>
        <li>
          <a href="update.php">
            UPDATE
          </a>
        </li>
		<li>
			<?php
				if($h===0)
					$link = "login.php";
				else
					$link = "login.php";
				
				echo "<a href='" .$link. "?logout=yes'>";
			
			if($h===0)
				echo "LOGIN";
			else
				echo "LOGOUT";
		   ?>
          </a>
        </li>
      </ul>
    </div>
	<?php
		if($remove===0){
	?>
		<form action="delete.php" method="post">
				<fieldset style="width:30%;">
					<legend><h4>SELECT PRODUCT TO REMOVE</h4></legend>
					ITEM NAME<br/>
					<select name="item_id">
						<option value=''></option>
						<?php
							$result = $connection->query("SELECT * FROM `item`");
							if ($result->num_rows > 0) {
								while($row = $result->fetch_assoc()) {
									echo "<option value='".$row['item_id']."'>".$row['item_name']."</option>";
								}
							}
						?>
					</select><br/><br/><br/>
					<input type="hidden" name="remove" value="1"/>
					<input type="submit" value="REMOVE PRODUCT" class="button" style="float:right;"/><br/>
				</fieldset>
		</form>
		<?php
			}else{
				echo "<center><h4>REMOVED ITEM WITH ID : ".$item_id." SUCCESSFULLY.<br/> REDIRECTING.........</h4></center>";
				header( "refresh:3;url=delete.php" );
				die();
			}
		}
			$connection->close();
		?>
		<div id="footer">
			<p><em>&copy;2014 <a href="index.html" title="eShop">eShop</a>. All rights reserved. Designed by Mohammad Rahmat</em></p>
		</div>
	<body>
</html>