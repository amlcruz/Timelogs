<?php
include_once ("include/dbconnect.php");
include_once ("include/Encryption.php");

	
//Start session
	session_start();	
	$db = new dbcon();
	$encrypt = new Encryption();
	if($_SESSION['updated'] == "false" && isset($_POST['password1'])){
		
		$emp_num = $_SESSION['emp_num'];
		$pwd1 = $db->sanitizeString($_POST['password1']);
		$pwd2 = $db->sanitizeString($_POST['password2']);
		$_SESSION['forgot'] = "false";
		$_SESSION['updated'] = "true";
		if(strcmp($pwd1, $pwd2)!=0)
			echo "<script type='text/javascript'>alert('New password did not match.');</script>";
		else{
			
			echo "<script type='text/javascript'>alert('Password Updated!');</script>";
			$db->updateEmployee($emp_num, $encrypt->encode($pwd1));
			header('Location: http://localhost/Timelog/logform.php');
			
		}
	} //else header('Location: http://localhost/Timelogs/login.php'); //or employee login page
?>
<html>

	<head>
		<title>TimeLogs</title>
		<style type='text/css'>
		body {
			    background:#66CCCC;
			}
			
		#login {
				box-align: center;
			    width:250px;
			    height: 125px;
			    background:#6699FF;
			    border:1px solid #000;
			    margin-top: 100px;
			    margin-left: auto;
    			margin-right: auto;
    			padding: 50px 5px 5px 5px;
			}
			 
		</style>
		<script type="text/javascript" src="js/jquery.js"></script>
	</head>
	
	<body>
		    <div align="center" id="login">
		    	<form method="POST" id="create">
		    		<table>
		    			<tr>
		    				<td>New Password: </td>
		    				<td><input type="password" id="password1" name="password1"></td>
		    			</tr>
		    			<tr>
		    				<td>Confirm Password: </td>
		    				<td><input type="password" id="password2" name="password2"></td>
		    			</tr>
			    	</table>
			    	<input name="submit" type="submit" value="Submit">
		    	</form>
		    
		    </div>
	</body>
</html>
