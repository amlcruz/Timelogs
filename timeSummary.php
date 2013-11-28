<?php
session_start();
error_reporting(0);

include_once ("include/dbconnect.php");
$db =  new dbcon();

$empno = $_COOKIE["empno"];
$period_fr = $_GET["from"];
$period_to = $_GET["to"];

$logs = $db->getLogData($empno, $period_fr, $period_to);

$inCheck1 = strtotime("08:00");				// 8 AM
$inCheck1 = date('H:i', $inCheck1);

$inCheck2 = strtotime("10:00");				// 10 AM
$inCheck2 = date('H:i', $inCheck2);

$outCheck1 = strtotime("17:00");				// 5 PM
$outCheck1 = date('H:i', $outCheck1);

$outCheck2 = strtotime("19:00");				// 7 PM
$outCheck2 = date('H:i', $outCheck2);
?>



<html>
<head>



</head>
<body>

<p align="center">RAW DATA<br/>FROM <?php echo $period_fr;?> TO <?php echo $period_to;?></p>
<a class="close-reveal-modal">&#215;</a>
<table align="center">
  <thead>
    <tr>
      <th width="100" class="center">DATE</th>
      <th width="50" class="center">DAY</th>
      <th width="100" class="center">TIME IN</th>
      <th width="100" class="center">TIME OUT</th>
      <th width="50" class="center">EXCESS</th>
      <th width="50" class="center">LATE</th>
      <th width="50" class="center">UNDERTIME</th>
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
			
			// COMPUTE EXCESS
  	  		$excessDisplay = "";
			$excessHour = "";
			$exceessMin = "";
			$excessTime = 0.00;
			
			$first  = new DateTime( $timeInDisplay );
			$second = new DateTime( $timeOutDisplay );
			
			$diff = $first->diff( $second );
			
			if($diff->format( '%H' ) > 8) {
				$excessHour = $diff->format( '%H' ); // -> 25:00:00
				$exceessMin = $diff->format( '%I' ); // -> 00:25:00
				$excessTime = ( ($excessHour) - 8 )+ ($exceessMin/60);
			}
			
			
			
			// COMPUTE LATE
			$lateDisplay = "";
			$lateHour = "";
			$lateMin = "";
			
			if ($timeInDisplay > $inCheck2) {
				$lateDisplay = $inCheck2;
				
				$first  = new DateTime($timeInDisplay);
				$second = new DateTime($inCheck2);
				
				$diff = $first->diff( $second );
				
				$lateHour = $diff->format( '%H' ); // -> 25:00:00
				$lateMin = $diff->format( '%I' ); // -> 00:25:00
			}
			
			
			$lateTime = $lateHour + ($lateMin/60);
			
			// COMPUTE UNDERTIME
  	  		$underDisplay = "";
			$underHour = "";
			$underMin = "";
			
			if ($timeInDisplay < $inCheck2) {
				$first  = new DateTime( $timeInDisplay );
				$second = new DateTime( $timeOutDisplay );
				
				
				
				$diff = $first->diff( $second );
				if($diff->format( '%H' ) > 8) {
					$eightHour = $first->format('%H') + 8;
					
					$underHour = $diff->format( '%H' ); // -> 25:00:00
					$exceessMin = $diff->format( '%I' ); // -> 00:25:00
					$excessTime = ( ($excessHour) - 8 )+ ($exceessMin/60);
				}
			}
			
			
  	  		echo "<tr><td class=\"center\">".$dateDisplay."</td><td class=\"center\">
  	  			".$dayDisplay."</td><td class=\"center\">".$timeInDisplay."</td>
  	  			<td class=\"center\">".$timeOutDisplay."</td>
  	  			<td class=\"center\">".number_format($excessTime,2)."</td>
  	  			<td class=\"center\">".number_format($lateTime,2)."</td>
  	  			<td class=\"center\">".number_format($excessTime,2)."</td></tr>";
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

</body>
</html>
