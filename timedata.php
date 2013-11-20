<?php
session_start();
error_reporting(0);
include_once ("include/scripts.php");
include_once ("include/dbconnect.php");
$db =  new dbcon();

$period_fr = $_GET["from"];
$period_to = $_GET["to"];

echo $period_fr;
echo $period_to;
?>



<html>
<head>

</head>
<body>

<table align="center">
  <thead>
    <tr>
      <th width="200" class="center">PERIOD</th>
      <th width="50" class="center">YEAR</th>
    </tr>
    
  </thead>
  <tbody>
  	<tr>
  		<td><?php echo $period_fr;?>
  		</td>
  		<td>gaga
  		</td>
  	</tr>
  </tbody>
</table>
</body>
</html>
