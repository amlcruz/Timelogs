<?php
class dbcon{
	
	function sanitizeString($string){
			return mysql_real_escape_string(strip_tags(htmlspecialchars($string)));
		}
	
	function __construct(){
		$db_config = parse_ini_file('config.ini');
		if($db = mysql_connect($db_config['host'], $db_config['user'], $db_config['pass']) or die($this->write_log("Error Connecting to Database: ".mysql_error()))) {
			mysql_select_db($db_config['db'], $db) or die($this->write_log("Error Connecting to Database: ".mysql_error()));
		}
	}
	
	function getLastEmpNum(){
		
		$sql = "SELECT emp_no FROM users ORDER BY emp_no DESC LIMIT 1";
		
		if(!mysql_query($sql)){
			$_COOKIE['error'] = mysql_error();
			header('Location: http://localhost/Timelogs/sqlerrorpage.php');
		}
		else{
			$result = mysql_query($sql);
			$row = mysql_fetch_row($result);
		}
		
		return $row[0];
		
	}
	
	function getLogin($emp_num,$pwd){
		
		$sql = "SELECT id,emp_no,fname,mname,lname,auxname,birthday,address,emp_pass,email,u_type,effectivity_date FROM users WHERE emp_no='".$emp_num."' AND emp_pass='".$pwd."' AND u_type=5";
		
		if(!mysql_query($sql)){
			$_COOKIE['error'] = mysql_error();
			header('Location: http://localhost/Timelogs/sqlerrorpage.php');
		}
		else{
			$result = mysql_query($sql);
			$row = mysql_num_rows($result);
		}
		return $row;
		
	}
	
	function retreive($emp_num,$email){
		
		$sql = "SELECT id,emp_no,fname,mname,lname,auxname,birthday,address,emp_pass,email,u_type,effectivity_date FROM users WHERE emp_no='".$emp_num."' AND email='".$email."'";
		
		if(!mysql_query($sql)){
			$_COOKIE['error'] = mysql_error();
			header('Location: http://localhost/Timelogs/sqlerrorpage.php');
		}
		else{
			$result = mysql_query($sql);
			$row = mysql_num_rows($result);
		}
		return $row;
		
	}
	
}

?>