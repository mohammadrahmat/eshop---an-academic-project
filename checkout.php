<!DOCTYPE html>
<?php
	include ('database.php');
?>
<html>
	<head>
		<link rel="stylesheet" href="css/style.css"/>
		<?php 
			if(!isset($_SESSION))
				session_start();
			if(!isset($_SESSION['pay']))
				$_SESSION['pay'] = $_POST['payment'];
			if(isset($_SESSION['pay']))
				$toPay = $_SESSION['pay'];
			
			if($_SESSION['loggedIn']===0){
				header("refresh:0;url=login.php");
				$_SESSION['log']=1;
				die();
			}
		?>
		<script src="js/checkout.js"></script>
	</head>
	<body>
		<?php include('header.php'); ?>
			<form method="post" action="success.php">
				<fieldset>
					<legend><h4>Select Payment Option</h4></legend>
					<h4 style="float:right;"><?php echo "Total : $".$toPay; ?></h4>
					<div style="clear:both;"></div>
					<dt><input type="radio" onclick="javascript:yesnoCheck();" name="yesno" id="cashCheck"/>
					Cash</dt>
					<br/>
					<dd><div id="ifCash" style="display:none">
					Payment On Door
					</div></dd>
					<br/>
					<dt><input type="radio" onclick="javascript:yesnoCheck();" name="yesno" id="creditCheck"/>
					Credit Card</dt>
					<br/>
					<dd><div id="ifCredit" style="display:none">
								<p>Name As On Card</p>
									<br>
								<input type="text" name="cardHolder" required/>
									<br>
								<p>Card Number</p>
									<br>
								<input type="text" name="cardNumber" required/>
									<br>
								<p>Expiry Date</p>
									<br>
								<input type="month" name="expDate" required/>
									<br>
								<p>CVC Code</p>
									<br>
								<input type="text" name="cvcCode" required/>			
					</div></dd>
					<br/>
					<dt><input type="radio" onclick="javascript:yesnoCheck();" name="yesno" id="bankCheck"/>
					Bank</dt>
					<br/>
					<dd><div id="ifBank" style="display:none">
					Receipt No.
					<input type="text" name="receipt"/>
					<p>*IN ORDER TO PAY BY BANK, PAY THE REQUIRED AMOUNT TO THE FOLLOWING ACCOUNT AND ENTER RECEIPT NUMBER:</p>
					<p>BANK NAME</p>
					<p>ACCOUNT HOLDER</p>
					<p>IBAN : 0000-0000-0000-0000-0000-0000-00</p>
					</div></dd>
					<br/><br/><br/>
					By clicking buy you agree that you agree to the site terms.
					<input type="hidden" name="total" value="<?php echo $toPay; ?>"/>
					<input type="hidden" name="method" id="method" value="test"/>
					<input type="submit" value="BUY" class="button" style="float:right;"/>
				</fieldset>
			</form>
		<div id="footer">
			<p><em>&copy;2014 <a href="index.html" title="eShop">eShop</a>. All rights reserved. Designed by Mohammad Rahmat</em></p>
		</div>
	</body>
</html>