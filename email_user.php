<?php
include_once ("include/dbconnect.php");
include_once ("include/Employee.php");
require 'include/PHPMailer/class.phpmailer.php';
session_start();

	$db = new dbcon();
	$emplyee = new Employee();
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
		$password = $and;
		
		if($_SESSION['forgot']=="false")
			header('Location: http://localhost/Timelogs/forgotpw.php');
		
		$mail = new PHPMailer();  // create a new object
		$mail->IsSMTP(); // enable SMTP
		$mail->SMTPDebug = 0;  // debugging: 1 = errors and messages, 2 = messages only
		$mail->SMTPAuth = true;  // authentication enabled
		$mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for GMail
		$mail->Host = 'smtp.gmail.com';
		$mail->Port = 465; 
		$mail->Username = "egg.timelogs@gmail.com";  
		$mail->Password = "eggtimelog";           
		$mail->SetFrom("egg.timelogs@gmail.com", "Timelogs");
		$mail->Subject = "Timelog Password Reset";
		$mail->Body = "Go to http://localhost/Timelogs/update_password.php to update your password. Thanks!";
		$mail->AddAddress($_SESSION['email']);
		$_SESSION['forgot'] = "false";
		$_SESSION['updated'] = "false";
		if(!$mail->Send()) {
			$error = 'Mail error: '.$mail->ErrorInfo; 
			return false;
		} else {
			$error = 'Message sent!';
			return true;
		}
		
		$emplyee->updateEmployee($emp_num, $encrypt->encode($password));
	

?>