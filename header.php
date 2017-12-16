<?php
		
		if(!isset($_SESSION)){
			session_start();
		}
		error_reporting(E_ERROR | E_WARNING | E_PARSE);
		
		$cartCheck = count($_SESSION["cart_array"]);
		$h=0;
		$string="";
		if(isset($_SESSION['name']) && $_SESSION['name'] != "<a href='login.php'>Login</a>"){
			$h=1;
			$string="<a href='history.php'>History</a>";
		}
		
		if($h===0){
			$_SESSION['name'] = "<a href='login.php'>Login</a>";
			$string = "";
		}
		
		$doit = false;
		try {
			$mysqli = new mysqli($servername, $username, $password);
			} catch (\Exception $e) {
		}
		if ($mysqli->select_db($dbname) === false) {
			$connection = new mysqli($servername, $username, $password);
			$connection->query("CREATE DATABASE IF NOT EXISTS $dbname");
			$connection->close();
			$doit=true;
		}
		$connection2 = new mysqli($servername, $username, $password, $dbname);
		if ($doit){
			$commands = file_get_contents("eshopdb.sql");
			$lines = explode("\n",$commands);
			$commands = '';
			foreach($lines as $line){
				$line = trim($line);
				if( $line && !startsWith($line,'--') ){
					$commands .= $line . "\n";
				}
			}
			$commands = explode(";", $commands);
			
			for($x=0;$x<count($commands);$x++){
				$connection2->query($commands[$x]);
			}
		}
			
			
		function startsWith($haystack, $needle){
				$length = strlen($needle);
				return (substr($haystack, 0, $length) === $needle);
		}
		$result=$connection2->query("SELECT * FROM item");
			$rowcount=mysqli_num_rows($result);
			if($rowcount===0){
				$sql = file_get_contents('item.sql');
				$connection2->query($sql);
			}
				$connection2->close();
	
?>
<div><p style="float:left;"><?php if($_SESSION['user_rank']==1) echo "<a href='admin.php'>Admin Panel</a>"; else echo "";?></p><p style="float:right;"><?php echo $_SESSION['name']; ?></p><br></div>
<div style="clear:both;">
<div><p style="float:right;"><?php echo $string; ?></p><br></div>
<div style="clear:both;">
<center>
      <img src="http://s25.postimg.org/gfic79k67/eshop.png" width="800px" height="200px"/>
</center>
</div>
    <div id="menu">
      <ul class="navigation">
        <li>
          <a href="index.php" >
            HOMEPAGE
          </a>
        </li>
        <li>
          <a href="cart.php">
            CART (<?php echo $cartCheck; ?>)
          </a>
        </li>
        <li>
          <a href="about.php">
            ABOUT US
          </a>
        </li>
        <li>
          <a href="contact.php">
            CONTACT
          </a>
        </li>
		<li>
			<?php
				if($h===0)
					$link = "login.php";
				else
					$link = "profile.php";
				
				echo "<a href='" .$link. "'>";
			
			if($h===0)
				echo "LOGIN";
			else
				echo "PROFILE";
		   ?>
          </a>
        </li>
      </ul>
    </div>