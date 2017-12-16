<html>
  <head>
  
	<?php
		include('database.php');
		if(isset($_GET['cat_id']))
			$cat_id = $_GET['cat_id'];
		$connection = new mysqli($servername, $username, $password, $dbname);
		$res = $connection->query("SELECT a.category_name FROM category a WHERE a.category_id= ".$cat_id."");
		$row_cat = $res->fetch_assoc();
		$connection->close();
	?>
    <title>
      eShop - <?php echo $row_cat['category_name'] ?>
    </title>
    <link rel="stylesheet" href="css/style.css">
  </head>
  <body>
    <?php
		include 'header.php';
	
	
		
		
		$sql = "SELECT a.item_id, a.item_name, a.item_price, a.item_stock\n"
		. "FROM item a\n"
		. "WHERE a.category_id= ".$cat_id."";
		
		$conn = new mysqli($servername, $username, $password, $dbname);
		$result = $conn->query($sql);
		if ($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
			echo "<div id='wrap'><center><div class='box'><h3>";
			echo $row['item_name'];
			echo "</h3></h3> <p float='left'><a href='item.php?id=";
			echo $row['item_id'];
			echo "'><img src='";
			$image_url = array();
			$connection_image = new mysqli($servername, $username, $password, $dbname);
			$res_image = $connection_image->query("SELECT a.item_image_url FROM item_image a WHERE a.item_id= ".$row['item_id']."");
			
			while($row_image = $res_image->fetch_assoc())
			{

				$image_url[] = $row_image['item_image_url'];

			}
			
			$connection_image->close();
			echo $image_url[0];
			echo "'; width='50%'; height='200px'/></a></p><h3><h4>PRICE: $";
			echo $row['item_price'];
			echo "   STOCK: ";
			echo $row['item_stock'];
			echo "</h4></h3></center></div>";
			}
		}
		$conn->close();
	?>
	
	
	
    
	
	<div id="footer">
		<p><em>&copy;2014 <a href="index.html" title="eShop">eShop</a>. All rights reserved. Designed by Mohammad Rahmat</em></p>
	</div>
	
  </body>
</html>