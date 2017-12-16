<!DOCTYPE html>
<?php
	include('database.php');
?>
<html>
  <head>
	<?php
		$connection = new mysqli($servername, $username, $password, $dbname);
		if(!isset($_SESSION))
			session_start();
		if(isset($_POST['toremove'])){
					$id_remove = $_POST['toremove'];
					foreach($_SESSION['cart_array']as $innerArrayKey => $innerArray) {
						foreach($innerArray as $k => $v) {
							if($k == "item_id" && $v == $id_remove)
								unset($_SESSION['cart_array'][$innerArrayKey]);
						}
					}
		}
		if(!empty($_POST['item_id']) && !empty($_POST['quantity'])){
				if(isset($_POST['item_id']))
					$id = $_POST['item_id'];
				if(isset($_POST['quantity']))
					$quantity = $_POST['quantity'];
			$a=0;
			$i = 0;
			if(!isset($_SESSION["cart_array"]) || count($_SESSION["cart_array"]) < 1){
				$_SESSION["cart_array"] = array(1=>array("item_id"=>$id, "quantity"=>$quantity));
			}else{
				foreach($_SESSION["cart_array"] as $each_item){
					$i++;
					while(list($key, $value) = each($each_item)){	
						if($key == "item_id" && $value == $id){
							array_splice($_SESSION["cart_array"], $i-1, 1, array(array("item_id"=>$id, "quantity"=>$each_item["quantity"] + $quantity)));
							$a=1;
						}
					}
				}
				if($a==0){
					array_push($_SESSION["cart_array"], array("item_id"=>$id,"quantity"=>$quantity));
				}
			}
		}
			if(isset($_GET["cmd"]) && $_GET["cmd"] == "emptycart"){
				unset($_SESSION["cart_array"]);
			}
	?>
    <title>
      eShop - Cart
    </title>
    <link rel="stylesheet" href="css/style.css"/>
  </head>
  <body class="news">
    <?php
		include 'header.php';
		$nameArray = array();
		$quantityArray = array();
		$priceArray = array();
		$imageArray = array();
		$idArray = array();
		$total = 0;
		if(!isset($_SESSION["cart_array"]) || count($_SESSION["cart_array"])<1){
			$cartOutput = "YOUR CART IS EMPTY.";
			echo "<center><h3>" . $cartOutput . "</h3></center>";
		}else{
			$i=0;
			foreach($_SESSION["cart_array"] as $each_item){
					$i++;
					$result = $connection->query("SELECT a.item_id, a.item_name, a.item_price FROM item a WHERE a.item_id = " . $each_item["item_id"] . "");
					if ($result->num_rows > 0) {
						while($row = $result->fetch_assoc()) {
							$nameArray[] = $row['item_name'];
							$quantityArray[] = $each_item['quantity'];
							$priceArray[] = $row['item_price'];
							$idArray[] = $row['item_id'];
						}
					}
					$result2 = $connection->query("SELECT a.item_image_url FROM item_image a WHERE a.item_id = " .$each_item["item_id"] . "");
					if ($result2->num_rows > 0) {
						if($row2 = $result2->fetch_assoc()) {
							$imageArray[] = $row2["item_image_url"];
						}
					}
			}
		}
		$connection->close();
	?>
	
	
	<div id="wrap">
		<center>
		
		<?php 
			for($x=0;$x<count($nameArray);$x++){
				echo "<div class='box'><img src='";
				echo $imageArray[$x];
				echo "'; width='50%'; height='200px'/></div>";
				echo "</center><div class='box'><table class='pTable'><tr><td>Item Name </td><td>".$nameArray[$x]."</td>";
				echo "<tr><td>Quantity </td><td>".$quantityArray[$x]."</td></tr>";
				$total += $quantityArray[$x]*$priceArray[$x];
				echo "<tr><td>Price </td><td>$".$priceArray[$x]."</td></tr>";
				echo "<tr><td>Total Price</td><td>$". $quantityArray[$x]*$priceArray[$x] ."</table></div>";
				echo "<div class='box'><form method='post' action='cart.php'><input type='hidden' name='toremove' value='".$idArray[$x]."'/>";
				echo "<input type='submit' class='button' value='REMOVE ITEM'/></form></div><center>";
			}
		?>
		<div class="box">
		</div>
		<div class="box">
		
			<form method="get" action="cart.php">
				<input type="hidden" name="cmd" value="emptycart"/>
				<input  type="submit" value="CLEAR CART" class="button" style="float:right;"/>
			</form>
		</div>
		<div class="box">
			<form method="post" action="checkout.php">
				<?php echo "<input type='hidden' name='payment' value='".$total."'/>";?>
				<input  type="submit" name="toPay" value="CHECKOUT" class="button" style="float:left;"/>
			</form>
		</div>
		</center>
	</div>
	<div id="footer">
		<p><em>&copy;2014 <a href="index.html" title="eShop">eShop</a>. All rights reserved. Designed by Mohammad Rahmat</em></p>
	</div>
  </body>
</html>