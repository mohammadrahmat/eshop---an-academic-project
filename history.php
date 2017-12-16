<!DOCTYPE HTML>
<?php
include('database.php');
?>
<html>
	<head>
		<title>
		eShop - Purchase History
		</title>
		<link rel="stylesheet" href="css/style.css">
		<?php
			$connection = new mysqli($servername, $username, $password, $dbname);
			$purchase_items=array();
			$purchase_count=array();
			$purchase_price=array();
			$purchase_id=array();
			$sql = "SELECT item_name,item_price,item_quantity FROM `item` INNER JOIN `order` ON `item`.item_id=`order`.item_id WHERE `transaction_id` IN (SELECT `transaction_id` FROM `transaction` WHERE `user_id`=".$_SESSION['user_id'].")";
			$result = $connection->query($sql);
			if ($result->num_rows > 0) {
				while($row = $result->fetch_assoc()) {
					$purchase_items[]=$row['item_name'];
					$purchase_count[]=$row['item_quantity'];
					$purchase_price[]=$row['item_price'];
				}
			}
			$sql = "SELECT `item_id` FROM `order` WHERE `transaction_id` IN (SELECT `transaction_id` FROM `transaction` WHERE `user_id`=".$_SESSION['user_id'].")";
			$result = $connection->query($sql);
			if ($result->num_rows > 0) {
				while($row = $result->fetch_assoc()) {
					$purchase_id[]=$row['item_id'];
				}
			}
		?>
	</head>
	<body>
		<?php include('header.php'); ?>
		
		<div>
			<center>
							<table class="pTable" style="width:60%;">
								<tr><th>Order No</th><th>Product Name</th><th>Quantity</th><th>Amount</th></tr>
								<?php
									$haha=0;
									for($k=0;$k<count($purchase_items);$k++){
										$haha++;
										$total = $purchase_count[$k]*$purchase_price[$k];
										echo "<tr><td style='width:10%;'><center>$haha</center></td><td><a href='item.php?id=$purchase_id[$k]' style='color:black;'>$purchase_items[$k]</a></td><td style='width:10%;'><center>$purchase_count[$k]</center></td><td>$$total</td></tr>";
									}
								?>
							</table>
			</center>
		
		</div>
		<div id="footer">
			<p><em>&copy;2014 <a href="index.html" title="eShop">eShop</a>. All rights reserved. Designed by Mohammad Rahmat</em></p>
		</div>
	</body>