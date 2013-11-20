<?php
include_once ("include/dbconnect.php");
	$emp_num = $_POST['emp_num'];
	$db = new dbcon();
	$db->deleteEmployee($emp_num);
?>