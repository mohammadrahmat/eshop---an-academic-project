<!DOCTYPE HTML>
<?php
include('database.php');
?>
<html>
  <head>
    <title>
      eShop
    </title>
    <link rel="stylesheet" href="css/style.css">
	<link href="themes/4/js-image-slider.css" rel="stylesheet" type="text/css" />
    <script src="themes/4/js-image-slider.js" type="text/javascript"></script>
    <script type="text/javascript">
		<script type="text/javascript">
        //slider functions
        function switchAutoAdvance() {
            imageSlider.switchAuto();
            switchPlayPauseClass();
        }
        function switchPlayPauseClass() {
            var auto = document.getElementById('auto');
            var isAutoPlay = imageSlider.getAuto();
            auto.className = isAutoPlay ? "group2-Pause" : "group2-Play";
            auto.title = isAutoPlay ? "Pause" : "Play";
        }
        switchPlayPauseClass();
    </script>
	
  </head>
  <body>
    
	<?php
		include 'header.php';
		$connection = new mysqli($servername, $username, $password, $dbname);
		$result = $connection->query("SELECT a.slider_image_url FROM slider a");
		
	?>
	
	<!----- START SLIDER ----->
	
		<div id="sliderFrame">
			<div id="slider">
			<?php
				if ($result->num_rows > 0) {
					while($row = $result->fetch_assoc()) {
						echo "<img src='".$row['slider_image_url']."' />";
					}
				}
			?>
				
			</div>
			<!--Custom navigation buttons on both sides-->
			<div class="group1-Wrapper">
				<a onclick="imageSlider.previous()" class="group1-Prev"></a>
				<a onclick="imageSlider.next()" class="group1-Next"></a>
			</div>
			<!--nav bar-->
			<div style="text-align:center;padding:20px;z-index:20;">
				<a onclick="imageSlider.previous()" class="group2-Prev"></a>
				<a id='auto' onclick="switchAutoAdvance()"></a>
				<a onclick="imageSlider.next()" class="group2-Next"></a>
			</div>
		</div>
	
	<!---- END SLIDER ----->
	
	<?php
	$sql = "SELECT a.category_image_url, b.category_name, b.category_id\n"
    . "FROM category_image a, category b\n"
    . "WHERE a.category_id = b.category_id";
	$result = $connection->query($sql);
	$i = 0;
	$link = "";
	if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
		echo "<div id='wrap'><center><div class='box'><h3>";
		echo $row['category_name'];
		echo "</h3> <p float='left'><a href='category.php?cat_id=";
		echo $row['category_id'];
		echo "'><img src='";
		echo $row['category_image_url'];
		echo "'; width='50%'; height='200px'/></a></p></center></div>";
		}
	}
	$connection->close();
	?>
	
    
	
	<div id="footer">
		<p><em>&copy;2014 <a href="index.html" title="eShop">eShop</a>. All rights reserved. Designed by Mohammad Rahmat</em></p>
	</div>
	
  </body>
</html>