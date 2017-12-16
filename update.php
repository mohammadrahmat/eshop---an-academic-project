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
			$item_id=0;
			$update=0;
			if(isset($_POST['update'])){
				$update = $_POST['update'];
				$item_id = $_POST['item_id'];
			}
			if(isset($_POST['step_TWO'])){
				$update = $_POST['step_TWO'];
				$item_name=$_POST['item_name'];
				$item_desc=$_POST['item_desc'];
				$item_price=$_POST['item_price'];
				$item_stock=$_POST['item_stock'];
				$item_extra=$_POST['item_extra'];
				$item_cat=$_POST['item_cat'];
				$item_id=$_POST['item_id'];
				$item_image=$_POST['item_image'];
				$connection->query("UPDATE `id1124926_personal`.`item` SET `item_name`='".$item_name."',`item_desc`='".$item_desc."',`item_price`=".(double)$item_price.",`item_stock`=".(int)$item_stock.",`item_extra`='".$item_extra."',`category_id`=".(int)$item_cat." WHERE `item_id`=".(int)$item_id."");
				$connection->query("UPDATE item_image a SET a.item_image_url='".$item_image."' WHERE a.item_id=".$item_id."");
									
			}
			if($update==1){
				$result = $connection->query("SELECT `item_name`, `item_desc`, `item_price`, `item_stock`, `item_extra`, `category_id` FROM `item` WHERE `item_id`='".$item_id."'");
				if ($result->num_rows > 0) {
								while($row = $result->fetch_assoc()) {
									$item_name=$row['item_name'];
									$item_desc=$row['item_desc'];
									$item_price=$row['item_price'];
									$item_stock=$row['item_stock'];
									$item_extra=$row['item_extra'];
									$item_cat=$row['category_id'];
								}
				}
			}
		?>
	</head>
	<body>
		<center>
			<img src="http://s25.postimg.org/gfic79k67/eshop.png" width="800px" height="200px"/>
		</center>
		<?php
			if($_SESSION['user_rank']!=1){
				echo "<br/><br/><br/><center><h4>YOU DO NOT HAVE PERMISSION TO ACCESS THIS PAGE<br/><br/><br/><br/><a href='index.php'>CLICK HERE TO GO BACK TO eShop MAINPAGE</a></h4></center>";
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
				  <a href="delete.php">
					REMOVE
				  </a>
				</li>
				<li>
				  <a href="admin.php">
					ADMIN PANEL
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
		}
		if($update===0){
	?>
	<form action="update.php" method="post">
				<fieldset style="width:30%;">
					<legend><h4>SELECT PRODUCT TO UPDATE</h4></legend>
					ITEM NAME<br/>
					<select name="item_id">
						<option value='0'></option>
						<?php
							$result = $connection->query("SELECT * FROM `item`");
							if ($result->num_rows > 0) {
								while($row = $result->fetch_assoc()) {
									echo "<option value='".$row['item_id']."'>".$row['item_name']."</option>";
								}
							}
						?>
					</select><br/><br/><br/>
					
					
					<input type="hidden" name="update" value="1"/>
					<input type="submit" value="UPDATE PRODUCT" class="button" style="float:right;"/><br/>
				</fieldset>
		</form>
		<?php
			}
			else if($update==1){
				if($item_id==0){
					echo "<center><h4 style='color:black;'><ul>'PLEASE SELECT AN ITEM TO UPDATE'</ul></h4></center>";
					header( "refresh:3;url=update.php" );
					die();
					$update=0;
				}
				else{
		?>
		<form action="update.php" method="post">
				<fieldset style="width:30%;">
					<legend><h4>SELECT PRODUCT VALUES TO UPDATE</h4></legend>
					ITEM NAME<br/>
					<input type="text" name="item_name" value="<?php echo $item_name; ?>" required/><br/><br/>
					ITEM DESCRIPTION<br/>
					<input type="text" name="item_desc" value="<?php echo $item_desc; ?>" required/><br/><br/>
					PRICE<br/>
					<input type="text" name="item_price" value="<?php echo $item_price; ?>" required/><br/><br/>
					STOCK<br/>
					<input type="text" name="item_stock" value="<?php echo $item_stock; ?>" required/><br/><br/>
					EXTRA DETAILS<br/>
					<textarea name="item_extra" rows="4" cols="50" reqired/><?php echo $item_extra; ?></textarea><br/><br/>
					CATEGORY<br/>
					<select name="item_cat">
						<option value=''></option>
						<?php
							$result = $connection->query("SELECT * FROM `category`");
							$cat_id=0;
							if ($result->num_rows > 0) {
								while($row = $result->fetch_assoc()) {
									$cat_id++;
									if($cat_id==$item_cat){
										echo "<option value='".$cat_id."' selected='selected'>".$row['category_name']."</option>";
									}else{
										echo "<option value='".$cat_id."'>".$row['category_name']."</option>";
									}
								}
							}
							
							$image_url = array();
							$result = $connection->query("SELECT a.item_image_url FROM item_image a WHERE a.item_id = " .$item_id . "");
							if ($result->num_rows > 0) {
								if($row = $result->fetch_assoc()) {
									$image_url[] = $row["item_image_url"];
								}
							}
							
						?>
					</select><br/>
					IMAGE<br/><br/>
					<input type="text" name="item_image" value="<?php echo $image_url[0]; ?>" reqired/><br/><br/><br/>
					<input type="hidden" name="step_TWO" value="2"/>
					<input type="hidden" name="item_id" value="<?php echo $item_id; ?>"/>
					<input type="submit" value="UPDATE" class="button" style="float:right;"/><br/>
				</fieldset>
		</form>
		
		<?php
				}
			}
			else if($update==2){
		?>
			<center><h4 style='color:black;'>UPDATE SUCCESSFULL</h4></center>
			
		<?php
			
			header( "refresh:3;url=update.php" );
			die();
			}
			$connection->close();
		?>
		<div id="footer">
			<p><em>&copy;2014 <a href="index.html" title="eShop">eShop</a>. All rights reserved. Designed by Mohammad Rahmat</em></p>
		</div>
	<body>
</html>