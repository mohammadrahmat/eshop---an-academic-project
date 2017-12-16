<!DOCTYPE html>
<?php
	include('database.php');
?>
<html>
  <head>
	<?php
		if(isset($_GET['id']))
			$id = $_GET['id'];
		$connection = new mysqli($servername, $username, $password, $dbname);
		$res = $connection->query("SELECT a.item_name FROM item a WHERE a.item_id= ".$id."");
		$row_item = $res->fetch_assoc();
		
	?>
	
	
    <title>
      eShop - <?php echo $row_item['item_name'] ?>
    </title>
    <link rel="stylesheet" href="css/style.css">
	<script type="text/javascript">
		var src;
		function changeImage(ID){
				src = document.getElementById(ID).src;
                document.getElementById("P3").src = src;
            }
	</script>
	
  </head>
  <body class="news">
  
    <?php
		include 'header.php';
	
		$sql = "SELECT a.item_name, a.item_price, a.item_desc, a.item_extra, a.item_stock\n"
		. "FROM item a\n"
		. "WHERE a.item_id = ".$id."";
		;	
		
		$result = $connection->query($sql);
		if ($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
				$item_name = $row['item_name'];
				$item_price = "$" . $row['item_price'];
				$item_desc = $row['item_desc'];
				$item_extra = $row['item_extra'];
				$item_stock = $row['item_stock'];
				
			}
		}
		
	?>
	
	<?php 
		$image_url = array();
		$res_image = $connection->query("SELECT a.item_image_url FROM item_image a WHERE a.item_id= ".$id."");
		while($row_image = $res_image->fetch_assoc())
		{

			$image_url[] = $row_image['item_image_url'];

		}
		
		if (sizeof($image_url)==1) {
			$image_url[] = "http://s25.postimg.org/uzzf23f4v/images.jpg";
			$image_url[] = "http://s25.postimg.org/uzzf23f4v/images.jpg";
		}
		if (sizeof($image_url)==2) {
			$image_url[] = "http://s25.postimg.org/uzzf23f4v/images.jpg";
		}
		
		$connection->close();
		
	?>
	<center>
	<div id="wrap">
		<div class="boxP1">
			<div class="boxP3">
				<img src="<?php echo $image_url[0] ?>" width="100%" height="100%" id="P3"></img>
			</div>
			<div class="boxP4">
				<img src="<?php echo $image_url[1] ?>" width="100%" height="100%" onmouseover="document.getElementById('P3').src = this.src"></img>
			</div>
			<div class="boxP4">
				<img src="<?php echo $image_url[0] ?>" width="100%" height="100%" onmouseover="document.getElementById('P3').src = this.src"></img>
			</div>
			<div class="boxP4">
				<img src="<?php echo $image_url[2] ?>" width="100%" height="100%" onmouseover="document.getElementById('P3').src = this.src"></img>
			</div>
		</div>
		<div class="boxP2">
			<table class="pTable">
				<tr>
					<td>
						PRODUCT NAME 
					</td>
					<td>
						<p><?php echo $item_name ?></p>
					</td>
				</tr>
				<tr>
					<td>
						DESCRIPTION 
					</td>
					<td>
						<p><p><?php echo $item_desc ?></p></p>
					</td>
				</tr>
				<tr>
					<td>
						PRICE 
					</td>
					<td>
						<p><p><?php echo $item_price ?></p></p>
					</td>
				</tr>
				<tr>
					<td>
						STOCK 
					</td>
					<td>
						<p><p><?php echo $item_stock ?></p></p>
					</td>
				</tr>
				<tr>
					<td>
						DETAILS
					</td>
					<td>
						<p><p><?php echo $item_extra ?></p></p>
					</td>
				</tr>
			</table>
			<form name="buy" id="buy" method="post" action="cart.php">
				<p>
					Quantity : 
					<input type="hidden" name="item_id" id="item_id" value="<?php echo $id; ?>"/>
					<input type="number" name ="quantity" id ="quantity" value = "1" min="1" max="<?php echo $item_stock; ?>" style="width:50px;"/> / <?php echo $item_stock; ?> <br><br>
					<input type="submit" value="BUY"/>
				</p>
			</form>
		</div>
	</div>
	</center>
	<div id="footer">
		<p><em>&copy;2014 <a href="index.html" title="eShop">eShop</a>. All rights reserved. Designed by Mohammad Rahmat</em></p>
	</div>
	
  </body>
</html>