<?php 
session_start();
error_reporting(0);

include_once "include/dbconnect.php";
include_once "include/Encryption.php";

$db =  new dbcon();
$encrypt = new Encryption();

if(isset($_POST["login"])) {
	$emp = $db->sanitizeString($_POST["empid"]);
	$pwd = $encrypt->encode($db->sanitizeString($_POST["pword"]));
	
	$sql = $db->logEmployee($emp);
	
	//put sql errors here if no emp_no
	
	while ($row = mysql_fetch_array($sql)){
		$empno = $row["emp_no"];
		$emppw = $row["emp_pass"];
		$empname = $row["fname"];
		$log = 1;
		if($emppw == $pwd) {
			setcookie("empno", $empno, time()+3600);
			setcookie("log", $log, time()+3600);
			setcookie("fname", $empname, time()+3600);
		}
		header("Location: main.php");
	}
	
}


?>
<html>
<body>

<form action="logform.php" method="post">
  <fieldset>
    <legend>Login-Page</legend>
	    <div class="row">
	      <div class="large-12 columns">
	        <label>Employee ID</label>
	        <input type="text" placeholder="Employee-ID" name="empid">
	        <label>Password</label>
	        <input type="password" placeholder="Password" name="pword">
	        <button type="submit" name="login" class="small button radius">Log-in</button> 
	        <button type="reset" name="reset" class="small button radius">Reset</button>
	        <a href="forgotpw.php" name="forgotpw" class="small button radius secondary">FORGOT PW</a>
	        <a href="login.php" name="admin" class="small button radius secondary">ADMIN</a>
	      </div>
	    </div>
    </fieldset>
</form>

</body>
</html>