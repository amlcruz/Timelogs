<?php 
$log = 0;
if(isset($_COOKIE["log"]))
$log = $_COOKIE["log"];
?>

<html>
<head>
<?php 
	include_once ("include/scripts.php");
?> 

</head>
<body>
<nav class="top-bar">
  <ul class="title-area">
    <li class="name"><!-- Leave this empty --></li>
    
  </ul>
</nav>

<div class="row">
 
    <!-- Contact Details -->
    <div class="large-7 columns">
 	<?php 
 		$link = 0;
 		if (isset($_GET["linkPass"]))
 			$link = $_GET["linkPass"];
 			
 		if($link == 0) {
			echo "<div id=\"wrap\">
					<h3>EGG TIME-LOG</h3>
				 		<div id=\"digiclock\"></div>
					<br /><br />
				</div>";
 		}
     	elseif ($link == 1) {
   
		    echo "<div id=\"wrap\">
					<h3>MY ATTENDANCE</h3>";
				 		include_once 'period.php';
			echo"<br /><br />
				</div>";
     	}
     	
     ?>
	</div>
	<div class="large-5 columns">
		<div id="wrap">
	      
		<?php
		if($log==0){
			echo "<h3>LOG-IN</h3>";
			include_once 'logform.php';
		}
		else{
			echo "<h3>WELCOME</h3>";
			include_once 'welcome.php';
		}
		if($log==1) {
			echo "<h3>TIME-LOG</h3>";
			include_once 'punch.php';
		?>	
			
		</div>
		<?php 
		}
		?>
    </div>
    <!-- End Sidebar -->
</div>
	
</body>
</html>