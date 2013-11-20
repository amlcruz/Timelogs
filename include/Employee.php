<?php

class Employee{
	
	function sanitizeString($string){
			return mysql_real_escape_string(strip_tags(htmlspecialchars($string)));
		}
	
	function __construct(){
		$db_config = parse_ini_file('config.ini');
		if($db = mysql_connect($db_config['host'], $db_config['user'], $db_config['pass']) or die($this->write_log("Error Connecting to Database: ".mysql_error()))) {
			mysql_select_db($db_config['db'], $db) or die($this->write_log("Error Connecting to Database: ".mysql_error()));
		}
	}
	function getAllEmployees(){
		
		$sql ="SELECT id,emp_no,fname,mname,lname,auxname,birthday,address,emp_pass,email,u_type,effectivity_date FROM users ORDER BY emp_no";
		if(!mysql_query($sql)){
			$_COOKIE['error'] = mysql_error();
			header('Location: http://localhost/Timelogsdev/sqlerrorpage.php');
		}
		else{
			$result = mysql_query($sql);
		}
		//$row =fetch_assoc($result);
		
		 if ($result){
	        while($data= mysql_fetch_assoc($result)){
	            $row[] = $data;
	        }
	    }
	
		return $row;
		
	}
	
	function getEmployee($emp_num){
		
		$sql = "SELECT id,emp_no,fname,mname,lname,auxname,birthday,address,emp_pass,email,u_type,effectivity_date FROM users WHERE emp_no='".$emp_num."'";
		
		if(!mysql_query($sql)){
			$_COOKIE['error'] = mysql_error();
			header('Location: http://localhost/Timelogsdev/sqlerrorpage.php');
		}
		else{
			$result = mysql_query($sql);
			$row = mysql_fetch_row($result);
		}
		return $row;
		
	}
	
	function updateEmployee($emp_num,$pwd){
		
		$sql = "UPDATE users SET emp_pass='".$pwd."' WHERE emp_no='".$emp_num."'";
		if(!mysql_query($sql)){
			$_COOKIE['error'] = mysql_error();
			header('Location: http://localhost/Timelogsdev/sqlerrorpage.php');
		}
		else{
			$result = mysql_query($sql);
		}
	}
	
	function deleteEmployee($emp_num){
		
		$sql = "DELETE FROM users WHERE emp_no='".$emp_num."'";
		if(!mysql_query($sql)){
			$_COOKIE['error'] = mysql_error();
			header('Location: http://localhost/Timelogsdev/sqlerrorpage.php');
		}
		else{
			$result = mysql_query($sql);
		}
		
	}
	
	
}

?>