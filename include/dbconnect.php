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
			header('Location: http://localhost/Timelog/sqlerrorpage.php');
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
			header('Location: http://localhost/Timelogsdev/sqlerrorpage.php');
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
			header('Location: http://localhost/Timelogsdev/sqlerrorpage.php');
		}
		else{
			$result = mysql_query($sql);
			$row = mysql_num_rows($result);
		}
		return $row;
		
	}
	
	function logEmployee($emp_num){
		$sql = "SELECT * FROM users WHERE emp_no LIKE '".$emp_num."'";
		
		$result = mysql_query($sql) or die();
			
		return $result;
	}
	
	function insertPunch ($empno, $date, $time, $inoutlog) {
		$sql = "INSERT INTO logs (emp_no, date, time, status) VALUES ('".$empno."','".$date."','".$time."','".$inoutlog."')";
		
		$result = mysql_query($sql) or die ("Cannot insert data in logs");
			
		return $result;
	}
	
	function getPeriodCount($empno){
		$sql = "SELECT COUNT(*) as num FROM period WHERE period_from >= (SELECT effectivity_date FROM users WHERE emp_no = '".$empno."')";

		$result = mysql_query($sql) or die("Cannot get Period Data");
		
		$row = mysql_fetch_array($result);
		
		return $row["num"];
	}
	
	function getPeriod($empno, $start, $limit){
		$sql = "SELECT * FROM period WHERE period_from >= (SELECT effectivity_date FROM users WHERE emp_no = '".$empno."') LIMIT ".$start.", ".$limit."";

		$result = mysql_query($sql) or die("Cannot get Period Data");
				
		return $result;
	}
	
	function getLogData($empno, $from, $to){
		$sql = "SELECT * FROM logs WHERE emp_no = '".$empno."' AND date >= '".$from."' AND date <= '".$to."' " ;

		$result = mysql_query($sql) or die("Cannot get Logged Data");
		
		return $result;
	}
}

?>