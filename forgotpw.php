<?php
include_once ("include/dbconnect.php");

	$db = new dbcon();
//Start session
session_start();
	
	if(isset($_POST['username'])){
		$emp_num = $db->sanitizeString($_POST['username']);
		$email = $db->sanitizeString($_POST['email']);
		
		$emp = $db->retreive($emp_num, $email);
		if($emp>0){
			$_SESSION['emp_num']=$emp_num;
			$_SESSION['email']= $email;
			$_SESSION['forgot']="true";
			$_SESSION['updated'] = "false";
			echo "<script type='text/javascript'>alert('Your new password will be sent to your email address.');</script>";
			include("email_user.php");
			
			//header('Location: http://localhost/Timelogs/login.php');
		}
		else 
			echo "<script type='text/javascript'>alert('Username and email did not match.');</script>";
	}
		
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
		    				<td>Employee ID: </td>
		    				<td><input type="text" id="username" name="username"></br></td>
		    			</tr>
		    			<tr>
		    				<td>Email: </td>
		    				<td><input type="text" id="email" name="email"></td>
		    			</tr>
			    	</table>
			    	<input name="submit" type="submit" value="Submit">
		    	</form>
		    
		    </div>
	</body>
</html>
