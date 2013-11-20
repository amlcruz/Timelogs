<?php
include_once ("include/dbconnect.php");
	$db = new dbcon();
	$row = $db->getAllEmployees();
	//print_r($row);
?>
<table align="center" border="1px">
<tr>
	<td><strong>Employee ID</strong></td>
	<td colspan="2"><strong>Employee Name</strong></td>
</tr>
<?php 
    foreach($row as $val): 
    echo "<tr>";
	  echo "<td>".$val['emp_no']."</td>";
	  echo "<td>".$val['fname']. " ".substr($val['mname'],0,1).". ".$val['lname']." ".$val['auxname']."</td>";
	  echo "<td><input type='button' id='".$val['emp_no']."' value='Edit' name='edit' /><input type='button' name='delete' id='".$val['emp_no']."' value='Delete'  /></td>";
	  
    echo "<tr>";
    endforeach; 
    ?>
</table>
