<?php
session_start();
include_once ("include/dbconnect.php");
include_once ("include/Encryption.php");
include_once ("include/Employee.php");

	$db = new dbcon();
	$emplyee = new Employee();
	$encrypt = new Encryption();
	
	if(!isset($_SESSION['user'])){
		header('Location: http://localhost/Timelogsdev/login.php');
	}

	if(isset($_GET['edit'])){	
		if(($_GET['edit']=="true")){
			$emp_num = $_GET['emp_num'];
			$db = new dbcon();
			$employee = $emplyee->getEmployee($emp_num);
			$_SESSION['emp_no'] = $employee[1];
			$_SESSION['fname'] = $employee[2];
			$_SESSION['mname'] = $employee[3];
			$_SESSION['lname'] = $employee[4];
			$_SESSION['aname'] = $employee[5];
			$_SESSION['bday'] = $employee[6];
			$_SESSION['address'] = $employee[7];
			$_SESSION['email'] = $employee[9];
			$_SESSION['password'] = $employee[8];
			$_SESSION['user_type'] = $employee[10];
			$_SESSION['effectivity_date'] = $employee[11];
			$_SESSION['edit'] = "true";
		}
	}
	
	if(isset($_POST['view'])){	
		var_dump($_SESSION);
		$emp_to_view = $emplyee->getEmployee($_POST['emp_num']);
		$_SESSION['emp_no'] = $emp_to_view[1];
		$_SESSION['fname'] = $emp_to_view[2];
		$_SESSION['mname'] = $emp_to_view[3];
		$_SESSION['lname'] = $emp_to_view[4];
		$_SESSION['aname'] = $emp_to_view[5];
		$_SESSION['bday'] = $emp_to_view[6];
		$_SESSION['address'] = $emp_to_view[7];
		$_SESSION['email'] = $emp_to_view[9];
		$_SESSION['password'] = $emp_to_view[8];
		$_SESSION['user_type'] = $emp_to_view[10];
		$_SESSION['effectivity_date'] = $emp_to_view[11];
		$_SESSION['view'] = "true";
	}
	
	if(isset($_POST['fname'])){	
		
		if($_POST['submitted']=="true")
			header('Location: http://localhost/Timelogsdev/manage_user.php');
			
		$fname = $_POST['fname'];
		$mname = $_POST['mname'];
		$lname = $_POST['lname'];
		$aname = $_POST['aname'];
		$bday = $_POST['bday'];
		$address = $_POST['address'];
		$email = $_POST['email'];
		$pwd = $encrypt->encode($_POST['password']);
		$user_type = $_POST['user_type'];
		date_default_timezone_get();
		$effectivity = date('m-d-Y', time());
		$_POST['submitted'] = "true";
		$last = $db->getLastEmpNum();
		$emp_num="00-";
		$empnum = intval(substr($last,-5))+1;
		$len=5-strlen($empnum);
		for($i=0; $i<$len; $i++){
			$emp_num = $emp_num."0";
		}
		$emp_num = $emp_num.$empnum;
		if($_POST['edit']=="false"){
			mysql_query("INSERT INTO users (emp_no,fname,mname,lname,auxname,birthday,address,emp_pass,email,u_type,effectivity_date) VALUE ('$emp_num','$fname','$mname','$lname','$aname','$bday','$address','$pwd','$email','$user_type','$effectivity')") or die(mysql_error());
		}elseif($_SESSION['edit']=="true"){
			$emp_num = $_SESSION['emp_no'];
			$fname = $_POST['fname'];
			$mname = $_POST['mname'];
			$lname = $_POST['lname'];
			$aname = $_POST['aname'];
			$bday = $_POST['bday'];
			$address = $_POST['address'];
			$email = $_POST['email'];
			$pwd = $_POST['password'];
			$user_type = $_POST['user_type'];
			$effectivity = $_SESSION['effectivity_date'];
			$_SESSION['edit']="false";
			
			mysql_query("UPDATE users SET emp_no='$emp_num',fname='$fname',mname='$mname',lname='$lname',auxname='$aname',birthday='$bday',address='$address',emp_pass='$pwd',email='$email',u_type=$user_type, effectivity_date='$effectivity' WHERE emp_no='$emp_num'");
		}
		header('Location: http://localhost/Timelogsdev/manage_user.php');
	}
?>
<html>
	<head>
		<title>TimeLogs</title>
		<style type='text/css'>
		   .container { position:relative; padding:0 0 0 55px; }
			#sidebar {
			    position:absolute;
			    top:0; bottom:0; left:0;
			    width:250px;
			    background:#6699FF;
			    border:1px solid #000;
			}
			#content { border:1px solid #000; width:1090px; height:500px;
			    margin:5px 5px 5px 200px; background:#66CCCC; vertical-align:middle; line-height: 14px;
			}
			#logout{ position: absolute; bottom: 0; left:100;
			}
		</style>
		<link rel="stylesheet" href="Styles/jquery-ui.css" />
		<script type="text/javascript" src="js/jquery.js"></script>
		<script type="text/javascript" >

		$(document).ready(function(){
			
			$("#view_emp").click(function(event){
				$("#content").load("view_employee.php");
				window.location.reload();
	        });

			$("#create_emp").click(function(event){
				$.get('kill.php', function() {
				});
	        	$("#content").load("create_employee.php");
	        });

			$("#logout").click(function(event){
				$.get('kill.php', function() {
				});
	        	window.location="login.php";
	        });
	        
		});
		</script>
		
		<!-- view employee -->
		<script type="text/javascript" src="js/jquery.js"></script>
		<script type="text/javascript" src="js/jquery-ui.js"></script>
		<script type="text/javascript" src="js/jquery-ui.min.js"></script>
		<script type="text/javascript" src="js/jquery.alerts/jquery.alerts.js"></script>
		<script type="text/javascript" src="js/jquery.ui.core.js"></script>
		<script type="text/javascript" src="js/jquery.ui.widget.js"></script>
		<script type="text/javascript" >

		$(document).ready(function(){

			$(".edit").live('click',function() { // catch the form's submit event
				var emp_num = $(this).attr('id');
			    $.ajax({ // create an AJAX call...
			    	data: {emp_num: emp_num, edit:"true"}, // get the form data
			        type: "GET", 
			        async: false,
			        url: "manage_user.php", // the file to call
			        success: function(response) { // on success..
				        console.log( "ok");
			        	$("#content").load("create_employee.php"); // update the DIV
			        },
			        error: function(response){
							alert("error");
				    }
			    });
			});
			
			$(".delete").live('click',function() {
				var emp_num = $(this).attr('id');
				$.get('kill.php', function() {
				});
			      var $dialog = $('<div>Are you sure you wish to delete this record?</div>').dialog({
			            buttons: [
			                  {
			                        text: "Ok",
			                        click: function(){
			    					    $.ajax({ // create an AJAX call...
			    					        data: {emp_num: emp_num}, // get the form data
			    					        type: "POST", 
			    					        async: false,
			    					        url: "delete_employee.php", // the file to call
			    					        success: function(response) { // on success..
			    					        	window.location.reload(); // update the DIV
			    					        }
			    					    });
			                              $dialog.remove();
			                        }
			                  },
			                  {
			                        text: "Cancel",
			                        click: function(){
			                              $dialog.remove();
			                        }
			                  }
			            ]
			      });
			});

			$("a[name='view']").click(function(event){
				var emp_num = $(this).attr('id');
				$.ajax({ // create an AJAX call...
			        data: {emp_num: emp_num, view:"true"}, // get the form data
			        type: "POST", 
			        async: false,
			        url: "manage_user.php", // the file to call
			        success: function(response) { // on success..
			        	$("#content").load("view.php"); // update the DIV
			        }
			    });
	        });
			
		}); //end document.ready
		</script>
	</head>
	
	<body>
		<div class="container">
		    <div align="center" id="sidebar">
		    
		    <p>Hello <?php if(isset($_SESSION['user'])) echo $_SESSION['user']; ?>!</p>
		    <p><a href="#" id="view_emp">View Employees</a></p>	
		    <p><a href="#" id="create_emp">Enroll Employee</a></p>	
		    <div id="logout"><p><a href="#" id="view_emp">Logout</a></p></div>
		    </div>
		    <div id="content"><?php include('view_employee.php'); ?></div>
		</div>
	</body>
</html>
