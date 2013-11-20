<?php
session_start();	
include_once ("include/dbconnect.php");
?>
	<?php if(isset($_SESSION['edit'])&& ($_SESSION['edit']=="true")) echo "<p>Edit Employee</p>"; else echo "<p>Create Employee</p>"; ?>
		
		<head>		
		<link rel="stylesheet" href="Styles/jquery-ui.css" />
		<script type="text/javascript" src="js/jquery.js"></script>
		<script type="text/javascript" src="js/jquery-ui.js"></script>
		<script type="text/javascript" src="js/jquery-ui.min.js"></script>
		<script type="text/javascript" src="js/jquery.ui.core.js"></script>
		<script type="text/javascript" src="js/jquery.ui.widget.js"></script>
		<script type="text/javascript" src="js/jquery.ui.datepicker.js"></script>
		<script type="text/javascript" >

		$('#create').submit(function() { // catch the form's submit event
			var check = 0;
			$(".required").each(function(){
				var a = $(this).val();
				if(a.trim() == "" || a.trim() == null){
					check+=1;
				}
			});
			var edit = $('.edit_employee').val();
			var fname = $('#fname').val();
			var mname = $('#mname').val();
			var lname = $('#lname').val();
			var aname = $('#aname').val();
			var bday = $('#bday').val();
			var address = $('#address').val();
			var password = $('#password').val();
			var user_type = $('#user_type').val(); 
			var email = $('#email').val();
			var submitted = "false";
			if(check > 0){
				alert("Please fill out all required fields.");
				return false;
			}else{
			    $.ajax({ // create an AJAX call...
			        data: {fname: fname, mname: mname, lname: lname, aname: aname, bday: bday, address: address, password: password, user_type: user_type, email: email, submitted: submitted, edit:edit }, // get the form data
			        type: "POST", 
			        async:false,
			        url: "manage_user.php", // the file to call
			        success: function(response) { // on success..
			        	$("#content").load("view_employee.php"); // update the DIV
			        },
			        error: function(response) {
			        	  alert(response.message);
			        	}
			    });
			}
		});

		$(function() {
			$( "#bday" ).datepicker({
				dateFormat: 'yy-mm-dd',
	            changeMonth: true,
	            changeYear: true,
	            yearRange:'-100y:c+nn'
	        });
	    });

		var alphaReg = /^\S[A-Za-z\s]{0,}$/;

		$("input[name='mname'],input[name='fname'],input[name='lname'],input[name='aname']").keypress(function(event) {
        	
			var inputVal = $(this).val();
			//var len = $(this).val().length;

			if (inputVal) {

				if (event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 37 || event.keyCode == 39) {
	    				// let it happen, don't do anything
	    		} else {

	    			if(event.keyCode > 64 || event.keyCode < 91 || event.keyCode > 96 || event.keyCode < 123){
	    		        
	    		    } else {
		    		event.preventDefault();
		    		return false;
	    		    }
	    			//validateAlphaReg(inputVal,$(this));
	    		}
	    	}
	    });
    
		function validateAlphaReg(value,element) {
        	if (!alphaReg.test(value)) {
    			
				var str = value.slice(0,-1);
				console.log('elem: ' + element)
				console.log('val: ' + str)
				//element.val(str);
				$(element).val(str);
				
			}
    	}

		</script>
	</head>
	
	<body>
		<form action="manage_user.php" method="POST" id="create">
			<table>
				<tr>
					<td>First Name: <font color = "red">*</font></td>
					<td><input class="required" type="text" name="fname" id = "fname" <?php if(isset($_SESSION['edit'])&& ($_SESSION['edit']=="true")) echo " value='".$_SESSION['fname']."'"; ?>></br></td>
				</tr>
				<tr>
					<td>Middle Name: <font color = "red">*</font></td>
					<td><input class="required"  type="text" name="mname" id = "mname" <?php if(isset($_SESSION['edit'])&& ($_SESSION['edit']=="true")) echo " value='".$_SESSION['mname']."'"; ?>></br></td>
				</tr>
				<tr>
					<td>Last Name: <font color = "red">*</font></td>
					<td><input class="required"  type="text" name="lname" id = "lname" <?php if(isset($_SESSION['edit'])&& ($_SESSION['edit']=="true")) echo " value='".$_SESSION['lname']."'"; ?>></br></td>
				</tr>
				<tr>
					<td>Auxiliary Name:</td>
					<td><input type="text" name="aname" id = "aname" <?php if(isset($_SESSION['edit'])&& ($_SESSION['edit']=="true")) echo " value='".$_SESSION['aname']."'"; ?>></br></td>
				</tr>
				<tr>
					<td>Birthday: <font color = "red">*</font></td>
					<td><input class="required"  type="text" name="bday" id = "bday" <?php if(isset($_SESSION['edit'])&& ($_SESSION['edit']=="true")) echo " value='".$_SESSION['bday']."'"; ?>></br></td>
				</tr>
				<tr>
					<td>Address: <font color = "red">*</font></td>
					<td><input class="required"  type="text" name="address" id = "address" <?php if(isset($_SESSION['edit'])&& ($_SESSION['edit']=="true")) echo " value='".$_SESSION['address']."'"; ?>></br></td>
				</tr>
				<tr>
					<td>email: <font color = "red">*</font></td>
					<td><input class="required"  type="text" name="email" id = "email" <?php if(isset($_SESSION['edit'])&& ($_SESSION['edit']=="true")) echo " value='".$_SESSION['email']."'"; ?>></br></td>
				</tr>
				<tr>
					<td>Password: <font color = "red">*</font></td>
					<td><input class="required"  type="password" name="password" id = "password"  <?php if(isset($_SESSION['edit'])&& ($_SESSION['edit']=="true")) echo " value='".$_SESSION['password']."'"; ?>></br></td>
				</tr>
				<tr>
					<td>User Type:</td>
					<td><select name="user_type" id = "user_type">
						  <?php 

						  	if(isset($_SESSION['edit'])&& ($_SESSION['edit']=="true")){
								if($_SESSION['u_type']==0)
									echo "<option value='5'>Admin</option><option value='0' selected>Employee</option>";
								else if($_SESSION['u_type']==5)
									echo "<option value='5' selected>Admin</option><option value='0'>Employee</option>";
						  	}else{
						  		echo "<option value='5'>Admin</option><option value='0'>Employee</option>";
						  	}
						?>
						</select>
					</td>
				</tr>
		
			</table>
			<input name="submit" type="submit" value="Submit">
			<input type = "hidden" name="create_employee" <?php if(isset($_SESSION['edit'])&& ($_SESSION['edit']=="false")) echo "value='false'"; else echo "value='true'";?> >
			<input type = "hidden" class="edit_employee"  <?php if(isset($_SESSION['edit'])&& ($_SESSION['edit']=="true")) echo "value='true'"; else echo "value='false'"; ?> >
		</form>
		</body>