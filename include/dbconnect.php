<?php
include("connection.php");

class dbcon{
	
	function __construct(){
		if($db = mysql_connect(HOST_par, u_sub_par, u_sub_par_ent) or die($this->write_log("Error Connecting to Database: ".mysql_error()))) {
			mysql_select_db(NM_par, $db) or die($this->write_log("Error Connecting to Database: ".mysql_error()));
		}
	}
	
	function getAllEmployees(){
		
		$sql ="SELECT * FROM users ORDER BY emp_no";
		$result = mysql_query($sql) or die();
		//$row =fetch_assoc($result);
		
		 if ($result){
	        while($data= mysql_fetch_assoc($result)){
	            $row[] = $data;
	        }
	    }
	
		return $row;
		
	}
	
	function getLastEmpNum(){
		
		$sql = "SELECT emp_no FROM users ORDER BY emp_no DESC LIMIT 1";
		$result = mysql_query($sql) or die();
		$row = mysql_fetch_row($result);
		
		return $row[0];
		
	}
	
	function getEmployee($emp_num){
		
		$sql = "SELECT * FROM users WHERE emp_no='".$emp_num."'";
		$result = mysql_query($sql) or die();
		$row = mysql_fetch_row($result);
		
		return $row;
		
	}
	
	function getLogin($emp_num,$pwd){
		
		$sql = "SELECT * FROM users WHERE emp_no='".$emp_num."' AND emp_pass='".$pwd."' AND u_type=5";
		$result = mysql_query($sql) or die();
		$row = mysql_num_rows($result);
		
		return $row;
		
	}
	
	function deleteEmployee($emp_num){
		
		$sql = "DELETE FROM users WHERE emp_no='".$emp_num."'";
		$result = mysql_query($sql) or die();
		
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
}

?>