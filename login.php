<?php
include_once ("include/dbconnect.php");
include_once ("include/Encryption.php");
include_once ("include/Employee.php");
	
//Start session
	session_start();	
	$db = new dbcon();
	$emplyee = new Employee();
	$encrypt = new Encryption();
	if(isset($_SESSION['user'])){
		session_destroy();
	}
	
	if(!isset($_SESSION['session_id'])){
		$and = (time() * rand());
		$result = substr($and,0,5);
		$letter="";
		for($x=0;$x<3;$x++){
		 	$int = rand(0,51);
				$a_z = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
				$rand_letter = $a_z[$int];
				$letter .= $rand_letter;
		}
		$and = $letter.$result;
		$_SESSION['session_id'] = $and;
	}
	
	if(isset($_POST['username'])){
		
		$emp_num = $db->sanitizeString($_POST['username']);
		$pwd = $encrypt->encode($db->sanitizeString($_POST['password']));
		
		$emp = $db->getLogin($emp_num, $pwd);
		if($emp>0){
			$employee = $emplyee->getEmployee($emp_num);
			$_SESSION['user'] = $employee[2];
			$_SESSION['password'] = $pwd;
			header('Location: http://localhost/Timelogsdev/manage_user.php');
		}
		else 
			echo "<script type='text/javascript'>alert('Username and password did not match.');</script>";
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
		    				<td>Password: </td>
		    				<td><input type="password" id="password" name="password"></td>
		    			</tr>
			    	</table>
			    	<input name="submit" type="submit" value="Submit">
		    	</form>
		    
		    </div>
	</body>
</html>
