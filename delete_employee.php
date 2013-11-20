<?php
include_once ("include/Employee.php");
	$emp_num = $_POST['emp_num'];
	$emplyee = new Employee();
	$emplyee->deleteEmployee($emp_num);
?>