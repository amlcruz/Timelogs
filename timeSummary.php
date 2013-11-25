<?php
session_start();
error_reporting(0);

include_once ("include/dbconnect.php");
$db =  new dbcon();

$empno = $_COOKIE["empno"];
$period_fr = $_GET["from"];
$period_to = $_GET["to"];

$logs = $db->getLogData($empno, $period_fr, $period_to);

$timeCheck = strtotime("08:00");				// 8 AM
$timeCheck = date('H:i', $timeCheck);

$lateCheck = strtotime("10:00");				// 10 AM
$lateCheck = date('H:i', $lateCheck);

$utimeCheck1 = strtotime("17:00");				// 5 PM
$utimeCheck1 = date('H:i', $utimeCheck1);

$utimeCheck2 = strtotime("19:00");				// 7 PM
$utimeCheck2 = date('H:i', $utimeCheck2);
?>



<html>
<head>

</head>
<body>
<p align="center">RAW DATA<br/>FROM <?php echo $period_fr;?> TO <?php echo $period_to;?></p>
<table align="center">
  <thead>
    <tr>
      <th width="100" class="center">DATE</th>
      <th width="50" class="center">DAY</th>
      <th width="100" class="center">TIME IN</th>
      <th width="100" class="center">TIME OUT</th>
      <th width="50" class="center">LATE</th>
    </tr>
    
  </thead>
  <tbody>
  	  	<?php
  	  	for ($x = $period_fr, $id = 0; $x <= $period_to; $x++, $num++) {
  	  		$timeSummary[] = array(
  	  			'id' => $num,
  	  			'dateSumm' => $x,
  	  			'timeIn' => "",
  	  			'timeOut' => ""
  	  		);
  	  	}
  	  	
  	  	while($row = mysql_fetch_array($logs))
		{
			
			$date = $row["date"];
			$time = $row["time"];
			$time = date('H:i', strtotime($time));
			$status = ($row["status"])? "In":"Out";
			foreach ($timeSummary as $key) {
				if (in_array($date, $key)) {
					$num  = $key['id'];
					if ($status=="In") {
						$timeSummary[$num]['timeIn'] = $time;
					}
					elseif ($status=="Out") {
						$date_out = $date;
						$timeSummary[$num]['timeOut'] = $time;
					}
				}
			}
    	}
  	  	
    	

  	  	foreach ($timeSummary as $key => $value){
			$dateDisplay = $value['dateSumm'];
  	  		$dayDisplay =  strtoupper(date("l",strtotime($value['dateSumm'])));
			$timeInDisplay = $value['timeIn'];
			$timeOutDisplay = $value['timeOut'];
			
			// COMPUTE LATE
			$lateDisplay = "";
			$lateHour = "";
			$lateMin = "";
			
			if ($timeInDisplay > $lateCheck) {
				$lateDisplay = $lateCheck;
				
				$first  = new DateTime($timeInDisplay);
				$second = new DateTime($lateCheck);
				
				$diff = $first->diff( $second );
				
				$lateHour = $diff->format( '%H' ); // -> 00:25:25
				$lateMin = $diff->format( '%I' ); // -> 00:25:25
			}
			
			
			$lateTime = $lateHour + ($lateMin/60);
			
			
			// COMPUTE OVERTIME
  	  		$overDisplay = "";
			$overHour = "";
			$overMin = "";
			
			$first  = new DateTime( $timeInDisplay );
			$second = new DateTime( $timeOutDisplay );

			$diff = $first->diff( $second );
			
			if($diff>8) {
				$overHour = $diff->format( '%H' ); // -> 00:25:25
				$overMin = $diff->format( '%I' ); // -> 00:25:25
			}
				
			$overTime = $overHour + ($overMin/60);
			
			
			/*
			// COMPUTE UNDERTIME
  	  		$underDisplay = "";
			$underHour = "";
			$underMin = "";
			
			if ($timeInDisplay > $late) {
				$lateDisplay = $late;
				
				$first  = new DateTime( $timeInDisplay );
				$second = new DateTime($late);
				
				$diff = $first->diff( $second );
				
				$lateHour = $diff->format( '%H' ); // -> 00:25:25
				$lateMin = $diff->format( '%I' ); // -> 00:25:25
			}
			*/
			
  	  		echo "<tr><td class=\"center\">".$dateDisplay."</td><td class=\"center\">
  	  			".$dayDisplay."</td><td class=\"center\">".$timeInDisplay."</td>
  	  			<td class=\"center\">".$timeOutDisplay."</td>
  	  			<td class=\"center\">".number_format($lateTime,2)."</td></tr>";
  	  	}
  	  	/*
  	  	$date_in = "";
  	  	$date_out = "";
  	  	$status = "";
  	  		
 	 	while($row = mysql_fetch_array($logs))
		{
			$date = $row["date"];
			$time = $row["time"];
			$time = date('h:i:s A', strtotime($time));
			$status = ($row["status"])? "In":"Out";
			if ($status=="In") {
				$date_in = $date;
			}
			elseif ($status=="Out") {
				$date_out = $date;
			}
			echo "<tr><td class=\"center\">".$date."</td><td class=\"center\">".$time."</td><td class=\"center\">".$status."</td></tr>";
    	}
  		*/
  		?>
  </tbody>
</table>
<?php 
include_once ("include/scripts.php");
?>
</body>
</html>
