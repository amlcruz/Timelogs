<?php
session_start();
	if(isset($_SESSION['edit'])&& ($_SESSION['edit']=="true")){
		if($_SESSION['u_type']==0)
			echo "<option value='5'>Admin</option><option value='0' selected>Employee</option>";
		else if($_SESSION['u_type']==5)
			echo "<option value='5' selected>Admin</option><option value='0'>Employee</option>";
		}else{
			echo "<option value='5'>Admin</option><option value='0'>Employee</option>";
	}
?>