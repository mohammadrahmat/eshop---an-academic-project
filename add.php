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
			$add=0;
			if(isset($_POST['add'])){
				$add = $_POST['add'];
				$item_name = $_POST['item_name'];
				$item_desc = $_POST['item_desc'];
				$item_price = $_POST['item_price'];
				$item_stock = $_POST['item_stock'];
				$item_extra = $_POST['item_extra'];
				$item_cat = $_POST['item_cat'];
				$item_image = $_POST['item_image'];
				$image_id = 0;
				$connection->query("INSERT INTO `id1124926_personal`.`item` (`item_id`, `item_name`, `item_desc`, `item_price`, `item_stock`, `item_extra`, `category_id`) VALUES (NULL, '$item_name', '$item_desc', '$item_price', '$item_stock', '$item_extra', '$item_cat')");
				$item_id = $connection->insert_id;	
				$result = $connection->query("SELECT `item_image_id` FROM `item_image` ORDER BY `item_image_id` DESC LIMIT 1");
				$row = $result->fetch_assoc();
				$image_id = $row['item_image_id'] + 1;
				$connection->query("INSERT INTO `item_image` (`item_image_id`,`item_image_url`,`item_id`) VALUES ('".$image_id."','".$item_image."','".$item_id."')");
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
          <a href="admin.php">
            ADMIN PANEL
          </a>
        </li>
        <li>
          <a href="delete.php">
            REMOVE
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
				if($add===0){
		?>
		
			<form action="add.php" method="post">
				<fieldset style="width:30%;">
					<legend><h4>ADD NEW PRODUCT</h4></legend>
					ITEM NAME<br/>
					<input type="text" name="item_name" required/><br/><br/>
					ITEM DESCRIPTION<br/>
					<input type="text" name="item_desc" required/><br/><br/>
					PRICE<br/>
					<input type="text" name="item_price" required/><br/><br/>
					STOCK<br/>
					<input type="text" name="item_stock" required/><br/><br/>
					EXTRA DETAILS<br/>
					<textarea name="item_extra" rows="4" cols="50" reqired/>NO EXTRA DETAILS</textarea><br/><br/>
					CATEGORY<br/>
					<select name="item_cat">
						<option value=''></option>
						<?php
							$result = $connection->query("SELECT * FROM `category`");
							$cat_id=0;
							if ($result->num_rows > 0) {
								while($row = $result->fetch_assoc()) {
									$cat_id++;
									echo "<option value='".$cat_id."'>".$row['category_name']."</option>";
								}
							}
						?>
					</select><br/><br/>
					ITEM IMAGE<br/>
					<input type="text" name="item_image" required/><br/><br/><br/>
					<input type="hidden" name="add" value="1"/>
					<input type="submit" value="ADD PRODUCT" class="button" style="float:right;"/><br/>
					
					
					
				</fieldset>
			</form>
		
		<?php
			}else{
				echo "<center><h4>ADDED ITEM NAMED ".$item_name." SUCCESSFULLY.<br/> REDIRECTING.........</h4></center>";
				header( "refresh:3;url=add.php" );
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