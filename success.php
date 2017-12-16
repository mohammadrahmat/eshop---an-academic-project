<!DOCTYPE html>
<?php
	include('database.php');
?>
<html>
	<head>
		<link rel="stylesheet" href="css/style.css"/>
		<?php
			$method = $_POST['method'];
			$transPrice = $_POST['total'];
			$transDetail = '';
			$user_id = $_SESSION['user_id'];
			$item_id = array();
			$item_name = array();
			$item_quantity = array();
			if($method=='cash'){
				$transDetail .= 'cash';
			}
			else if($method=='bank'){
				$transDetail .= $_POST['receipt'];
			}
			else if($method=='credit'){
				$transDetail .= $_POST['cardHolder'];
				$transDetail .= ' ';
				$transDetail .= $_POST['cardNumber'];
				$transDetail .= ' ';
				$transDetail .= $_POST['expDate'];
				$transDetail .= ' ';
				$transDetail .= $_POST['cvcCode'];
				$transDetail .= ' ';
			}
			foreach($_SESSION["cart_array"] as $each_item){
				$item_id[] = (int)$each_item["item_id"];
				$item_quantity[] = (int)$each_item["quantity"];
			}
			
			$connection = new mysqli($servername, $username, $password, $dbname);
			$connection->query("INSERT INTO transaction (user_id, transaction_price, transaction_details) VALUES ($user_id,$transPrice,'$transDetail')");
			$transaction_id = $connection->insert_id;			
			for($x=0;$x<count($item_id);$x++){
				$connection->query("INSERT INTO `order` (`item_id`, `item_quantity`, `transaction_id`) VALUES ($item_id[$x],$item_quantity[$x],$transaction_id)");
				$connection->query("UPDATE item SET item_stock=item_stock-$item_quantity[$x] WHERE item_id=$item_id[$x]");
				$getItem = $connection->query("SELECT item_name FROM item WHERE item_id=$item_id[$x]");
				$getName = $getItem->fetch_assoc();
				$item_name[] = $getName['item_name'];
			}
			$result=$connection->query("SELECT user_add,user_name FROM user WHERE user_id=$user_id");
			$details=$result->fetch_assoc();
			$connection->close();
		?>
		
	</head>
	<body>
		<?php include('header.php'); ?>
		<center>
			<h3> Your order has been successfully taken by us. We will contact you as soon as the item is shipped.</h3>
			<h3> Order details:</h3>
			
			<table class="pTable">
			<?php 
			
				echo "<tr><td>Ship To</td><td>".$details['user_name']."</td></tr><tr><td>Address</td><td>".$details['user_add']."</td></tr>";
				echo "<tr><td>Transaction ID</td><td>$transaction_id</td></tr><tr><td>Paid Amount</td><td>$$transPrice</td></tr>";
				echo "<tr><td>Items Bought</td><td>";
				for($x=0;$x<count($item_id);$x++){
					echo $item_name[$x]. " x " .$item_quantity[$x]. "<br/>";
					
				}
				echo "</td></tr>";
			?>
			</table>
			<h4 style="color:black;"> Thank you for shopping with us.</h4>
			<a href="index.php"> Click here to go back to the main page</a>
		</center>
		<?php
			unset($_SESSION["cart_array"]);
		?>
		<div id="footer">
			<p><em>&copy;2014 <a href="index.html" title="eShop">eShop</a>. All rights reserved. Designed by Mohammad Rahmat</em></p>
		</div>
	</body>
	
</html>
