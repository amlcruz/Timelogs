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

$timeInDisplay = "";
$timeOutDisplay = "";
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
  	  	
  	  	$totalExcess = 0;
  	  	$totalLate = 0;
  	  	$totalUndertime = 0;
  	  	
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
			$excessTime = "";
			
			if($timeInDisplay && $timeOutDisplay) {
				$first  = new DateTime( $timeInDisplay );
				$second = new DateTime( $timeOutDisplay );
				
				$diff = $first->diff( $second );
				
				if($diff->format( '%H' ) > 8) {
					$excessHour = $diff->format( '%H' ); // -> 25:00:00
					$exceessMin = $diff->format( '%I' ); // -> 00:25:00
					$excessTime = ( ($excessHour) - 9 )+ ($exceessMin/60);
				}
				else
					$excessTime = 0;
			}
			
			$totalExcess += $excessTime;
			
			// COMPUTE LATE
			$lateDisplay = "";
			$lateHour = "";
			$lateMin = "";
			$lateTime = "";
			
			if($timeInDisplay && $timeOutDisplay) {
				if ($timeInDisplay > $inCheck2) {
					$lateDisplay = $inCheck2;
					
					$first  = new DateTime($timeInDisplay);
					$second = new DateTime($inCheck2);
					
					$diff = $first->diff( $second );
					
					$lateHour = $diff->format( '%H' ); // -> 25:00:00
					$lateMin = $diff->format( '%I' ); // -> 00:25:00
					
					$lateTime = $lateHour + ($lateMin/60);
				}
				else
					$lateTime = 0;
			}
			
			
			$totalLate += $lateTime;
			
			// COMPUTE UNDERTIME
  	  		$underTime = "";
			$underHour = "";
			$underMin = "";
			if($timeInDisplay && $timeOutDisplay) {
				if ($timeInDisplay < $inCheck2) {					//ex. if (8:30 < 10:00)
					
					$third = date('H:i', strtotime($timeOutDisplay));				//ex. 15:30  		
					$fourth = date('H:i', strtotime($timeInDisplay) + (3600*9));	//ex. 17:30
					
					if($fourth < $third)											//ex. if(17:30 < 15:30)
						$underTime = 0;
					else {		
						$first  = new DateTime( $third );							//ex. 08:30
						$second = new DateTime( $fourth );							//ex. 15:30 
						
						$diff = $second->diff( $first );
					
						$underHour = $diff->format( '%H' ); // -> 25:00:00
						$underMin = $diff->format( '%I' ); // -> 00:25:00
						
						$underTime = (($underHour))+ ($underMin/60);
					}
				}
				else {												//ex. if (LATE)
					$first  = new DateTime( $timeOutDisplay );						//ex. 19:00
					$second = new DateTime( $outCheck2 );							//ex. 17:30

					if($first < $second) {
						$diff = $first->diff( $second );
						
						$underHour = $diff->format( '%H' ); // -> 25:00:00
						$underMin = $diff->format( '%I' ); // -> 00:25:00
						
						$underTime = (($underHour))+ ($underMin/60);
					}
					else
						$underTime = 0;
				}
			}
			
			$totalUndertime += $underTime; 
			
  	  		echo "<tr><td class=\"center\">".$dateDisplay."</td><td class=\"center\">
  	  			".$dayDisplay."</td><td class=\"center\">".$timeInDisplay."</td>
  	  			<td class=\"center\">".$timeOutDisplay."</td>
  	  			<td class=\"center\">".number_format($excessTime,2)."</td>
  	  			<td class=\"center\">".number_format($lateTime,2)."</td>
  	  			<td class=\"center\">".number_format($underTime,2)."</td></tr>";
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
  <tfoot>
  <?php 
    	echo "<tr><th colspan = 4 class=\"center\">TOTAL</th>
  	  		<th class=\"center\">".number_format($totalExcess,2)."</th>
  	  		<th class=\"center\">".number_format($totalLate,2)."</th>
  	  		<th class=\"center\">".number_format($totalUndertime,2)."</th></tr>";
  ?>

  </tfoot>
</table>

</body>
</html>
