<?php
session_start();
error_reporting(0);
include_once ("include/scripts.php");
include_once ("include/dbconnect.php");
$db =  new dbcon();

$empno = $_COOKIE["empno"];
$period_fr = $_GET["from"];
$period_to = $_GET["to"];

$logs = $db->getLogData($empno, $period_fr, $period_to);
?>



<html>
<head>

</head>
<body>
<p align="center">RAW DATA<br/>FROM <?php echo $period_fr;?> TO <?php echo $period_to;?></p>
<table align="center">
  <thead>
    <tr>
      <th width="200" class="center">DATE</th>
      <th width="100" class="center">TIME</th>
      <th width="50" class="center">STATUS</th>
    </tr>
    
  </thead>
  <tbody>
  	  	<?php 
 	 	while($row = mysql_fetch_array($logs))
		{
			$date = $row["date"];
			$time = $row["time"];
			$time = date('h:i:s A', strtotime($time));
			$status = ($row["status"])? "In":"Out";
			echo "<tr><td class=\"center\">".$date."</td><td class=\"center\">".$time."</td><td class=\"center\">".$status."</td></tr>";
    	}
  
  		?>
  </tbody>
</table>
</body>
</html>
