<?php
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
		
			}
		echo "<br/><br/><br/><center><h4>WELCOME TO THE ADMIN PANEL. YOU ARE LOGGED IN AS ". $_SESSION['name']."<br/><br/><br/><br/>YOU CAN MANAGE PRODUCTS BY USING THE NAVIGATION BAR TO <a href='add.php'>ADD</a>, <a href='remove.php'>REMOVE</a> OR <a href='update.php'>UPDATE</a> A PRODUCT.</h4></center>";
		?>
		<div id="footer">
			<p><em>&copy;2014 <a href="index.html" title="eShop">eShop</a>. All rights reserved. Designed by Mohammad Rahmat</em></p>
		</div>
	</body>
</html>