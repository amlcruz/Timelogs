<?php 
	session_start();
	error_reporting(0);
	
	include_once ("include/dbconnect.php");
	$db =  new dbcon();
	
	$total_pages = $db->getPeriodCount($_COOKIE["empno"]);

	echo $sql;
	$adjacents = 3;
	
	$targetpage = "main.php?linkPass=1";
	$limit = 3; 								
	$page = $_GET['page'];
	if($page) 
		$start = ($page - 1) * $limit; 			
	else
		$start = 0;								
	
	/* Get data. */
	
	$result = $db->getPeriod($_COOKIE["empno"], $start, $limit);
	
	/* Setup page vars for display. */
	if ($page == 0) $page = 1;					
	$prev = $page - 1;							
	$next = $page + 1;							
	$lastpage = ceil($total_pages/$limit);		
	$lpm1 = $lastpage - 1;						
	
	$pagination = "";
	if($lastpage > 1)
	{	
		$pagination .= "<div class=\"pagination-centered\"> <ul class=\"pagination\">";
		//previous button
		if ($page > 1) 
			$pagination.= "<li class=\"current\"><li class=\"arrow\"><a href=\"$targetpage&page=$prev\">&laquo;</a></li>";
		else
			$pagination.= "<li class=\"current\"><li class=\"arrow unavailable\"><span class=\"disabled\">&laquo;</span></li>";	
		//pages	
		if ($lastpage < 7 + ($adjacents * 2))	//not enough pages to bother breaking it up
		{	
			for ($counter = 1; $counter <= $lastpage; $counter++)
			{
				if ($counter == $page)
					$pagination.= "<li class=\"current\"><a href=\"\">$counter</a></li>";
				else
					$pagination.= "<li><a href=\"$targetpage&page=$counter\">$counter</a></li>";					
			}
		}
		elseif($lastpage > 5 + ($adjacents * 2))	//enough pages to hide some
		{
			//close to beginning; only hide later pages
			if($page < 1 + ($adjacents * 2))		
			{
				for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
				{
					if ($counter == $page)
						$pagination.= "<li class=\"unavailable\"><span class=\"current\">$counter</span><li>";
					else
						$pagination.= "<li><a href=\"$targetpage&page=$counter\">$counter</a></li>";					
				}
				
				$pagination.= "<li class=\"unavailable\"><a href=\"\">&hellip;</a></li>";
				$pagination.= "<li><a href=\"$targetpage&page=$lpm1\">$lpm1d</a></li>";
				$pagination.= "<li><a href=\"$targetpage&page=$lastpage\">$lastpage</a></li>";		
			}
			//in middle; hide some front and some back
			elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
			{
				$pagination.= "<li><a href=\"$targetpage&page=1\">1</a></li>";
				$pagination.= "<li><a href=\"$targetpage&page=2\">2</a></li>";
				$pagination.= "<li class=\"unavailable\"><a href=\"\">&hellip;</a></li>";
				for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
				{
					if ($counter == $page)
						$pagination.= "<li class=\"unavailable\"><span class=\"current\">$counter</span></li>";
					else
						$pagination.= "<li><a href=\"$targetpage&page=$counter\">$counter</a></li>";					
				}
				$pagination.= "<li class=\"unavailable\"><a href=\"\">&hellip;</a></li>";
				$pagination.= "<li><a href=\"$targetpage&page=$lpm1\">$lpm1</a></li>";
				$pagination.= "<li><a href=\"$targetpage&page=$lastpage\">$lastpage</a></li>";		
			}
			//close to end; only hide early pages
			else
			{
				$pagination.= "<li><a href=\"$targetpage&page=1\">1</a></li>";
				$pagination.= "<li><a href=\"$targetpage&page=2\">2</a></li>";
				$pagination.= "<li class=\"unavailable\"><a href=\"\">&hellip;</a></li>";
				for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
				{
					if ($counter == $page)
						$pagination.= "<li class=\"unavailable\"><span class=\"current\">$counter</span></li>";
					else
						$pagination.= "<li><a href=\"$targetpage&page=$counter\">$counter</a></li>";					
				}
			}
		}
		//next button
		if ($page < $counter - 1) 
			$pagination.= "<li class=\"arrow\"><a href=\"$targetpage&page=$next\">&raquo;</a></li>";
		else
			$pagination.= "<li class=\"arrow\"><span class=\"disabled\">&raquo;</span></li>";
		$pagination.= "</ul></div>\n";		
	}
?>




<html>
<head>
<?php echo $pagination;?>
	<script type="text/javascript" src="js/jquery-1.10.2.js"></script>
	<script type="text/javascript" src="js/jquery.js"></script>
	<script type="text/javascript" src="js/foundation.min.js"></script>
	
<script type="text/javascript">

var from_data = "<?php echo $_GET["from"]; ?>"
var to_data = "<?php echo $_GET["to"]; ?>"

$('#myModal').foundation('reveal', 'open', {
	url: 'timeSummary.php',
    data: {'from': from_data, 'to': to_data},
    async: false,
    success: function(data) {
		window.location.href='main.php?linkPass=1';
    },
    error: function() {
        alert('failed loading modal');
    }
});

</script>
</head>

<div id="myModal" class="reveal-modal">
 
  
</div>
<body>

<table align="center">
  <thead>
    <tr>
      <th width="200" class="center">PERIOD
      
    

	</th>
      <th width="50" class="center">YEAR</th>
    </tr>
    
  </thead>
  <tbody>
  <?php
		while($row = mysql_fetch_array($result))
		{
			$period_from = $row["period_from"];
			$period_to = $row["period_to"];
			$period_year = $row["period_year"];
			echo "<tr><td class=\"center\"><a href=\"timeSummary.php?from=".$period_from ."&to=".$period_to."\" data-reveal-id=\"myModal\" data-reveal-ajax=\"true\">".$period_from ." - ". $period_to."</a></td><td class=\"center\">".$period_year."</td></tr>";
    	}
	?>
  </tbody>
</table>
<?php 
include_once ("include/scripts.php");
?>
</body>
</html>
