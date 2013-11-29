<?php
include_once ("include/dbconnect.php");
include_once ("include/Employee.php");
include_once ("include/Encryption.php");

	
//Start session
	session_start();	
	$db = new dbcon();
	$encrypt = new Encryption();
	$emplyee = new Employee();
	if(isset($_SESSION['updated']) && $_SESSION['updated'] == "false" && isset($_POST['password1'])){
		
		$emp_num = $_SESSION['emp_num'];
		$pwd1 = $db->sanitizeString($_POST['password1']);
		$pwd2 = $db->sanitizeString($_POST['password2']);
		$_SESSION['forgot'] = "false";
		$_SESSION['updated'] = "true";
		if(strcmp($pwd1, $pwd2)!=0)
			echo "<script type='text/javascript'>alert('New password did not match.');</script>";
		else{
			
			echo "<script type='text/javascript'>alert('Password Updated!');</script>";
			$emplyee->updateEmployee($emp_num, $encrypt->encode($pwd1));
			header('Location: http://localhost/Timelogsdev/logform.php');
			
		}
	} //else header('Location: http://localhost/Timelogs/login.php'); //or employee login page
?>
<html>

	<head>
		<title>TimeLogs</title>
		<script type="text/javascript" src="js/jquery.js"></script>
	</head>
	
	<body>
	    <div align="center" id="login">
	    
	    <a class="close-reveal-modal">&#215;</a>
	    	<form method="POST" id="create">
	    		<table>
	    			<thead>
		    			<tr>
		    				<th colspan="2">CHANGE PASSWORD</th>
		    			</tr>
	    			</thead>
	    			<tbody>
		    			<tr>
		    				<td>New Password: </td>
		    				<td><input type="password" id="password1" name="password1"></td>
		    			</tr>
		    			<tr>
		    				<td>Confirm Password: </td>
		    				<td><input type="password" id="password2" name="password2"></td>
		    			</tr>
	    			</tbody>
	    			<tfoot>
	    				<tr>
	    					<td colspan="2"><input name="submit" type="submit" value="Submit" class="small button radius"></td>
	    				</tr>
	    			</tfoot>
		    	</table>
	    	</form>
	    </div>
	</body>
</html>
