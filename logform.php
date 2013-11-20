<?php 
session_start();
error_reporting(0);

include_once "include/dbconnect.php";
$db =  new dbcon();

if(isset($_POST["login"])) {
	$emp = $_POST["empid"];
	$pwd = md5($_POST["pword"]);
	
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
	        <button type="reset" name="reset" class="small button radius">Reset</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	        <a href="login.php" name="admin" class="small button radius secondary">ADMIN</a>
	      </div>
	    </div>
    </fieldset>
</form>

</body>
</html>