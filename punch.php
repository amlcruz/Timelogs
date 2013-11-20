<?php 
session_start();
error_reporting(0);

include_once ("include/dbconnect.php");
$db =  new dbcon();
$check = true;
$check2 = false;
if(isset($_COOKIE["empno"]))
$empno = $_COOKIE["empno"];

if(isset($_POST["punch"])) {
	$inout = $_POST["inout"];
	
	if($inout == "IN") {
		$check = "checked";
		$inoutlog=1;
	}
	else {
		$check2 = "checked";
		$inoutlog = 0;
	}
	$date = gmdate("Y-m-d");
	$time = gmdate("H:i:s", strtotime('+8 hours'));
	
	$sql = $db -> insertPunch($empno, $date, $time, $inoutlog);
	
	if($sql) {
		echo "<script>alert('Logged ".$inout."!');
				window.location.href='main.php'; </script>";
	}
}

?>

<form action="punch.php" method="post">
<!-- Clicking this placeholder fires the mapModal Reveal modal -->
	<div class="switch large round">
		 
		 <input id="z" name="inout" type="radio" value="IN">
		 <label for="z" onclick="">TIME-IN</label>

 		 <input id="z1" name="inout" type="radio" value="OUT" >
 		 <label for="z1" onclick="">TIME-OUT</label>

 		 <span></span>
	</div>

<center><button type="submit" class="large button expand alert" name="punch">PUNCH!</button></center>
</form>