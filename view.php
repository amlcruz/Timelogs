<?php session_start();
include_once ("include/Encryption.php");
$encrypt = new Encryption(); ?>
<p><strong>Employee Details</strong></p>
<table>
				<tr>
					<td>Employee ID: </td>
					<td><?php if(isset($_SESSION['view'])&& ($_SESSION['view']=="true")) echo $_SESSION['emp_no']; ?></td>
				</tr>
				<tr>
					<td>First Name: </td>
					<td><?php if(isset($_SESSION['view'])&& ($_SESSION['view']=="true")) echo $_SESSION['fname']; ?></br></td>
				</tr>
				<tr>
					<td>Middle Name: </td>
					<td><?php if(isset($_SESSION['view'])&& ($_SESSION['view']=="true")) echo $_SESSION['mname']; ?></br></td>
				</tr>
				<tr>
					<td>Last Name: </td>
					<td><?php if(isset($_SESSION['view'])&& ($_SESSION['view']=="true")) echo $_SESSION['lname']; ?></br></td>
				</tr>
				<tr>
					<td>Auxiliary Name:</td>
					<td><?php if(isset($_SESSION['view'])&& ($_SESSION['view']=="true")) echo $_SESSION['aname']; ?></br></td>
				</tr>
				<tr>
					<td>Birthday: </td>
					<td><?php if(isset($_SESSION['view'])&& ($_SESSION['view']=="true")) echo $_SESSION['bday']; ?></br></td>
				</tr>
				<tr>
					<td>Address: </td>
					<td><?php if(isset($_SESSION['view'])&& ($_SESSION['view']=="true")) echo $_SESSION['address']; ?></br></td>
				</tr>
				<tr>
					<td>email: </td>
					<td><?php if(isset($_SESSION['view'])&& ($_SESSION['view']=="true")) echo $_SESSION['email']; ?></br></td>
				</tr>
				<tr>
					<td>Password: </td>
					<td><?php if(isset($_SESSION['view'])&& ($_SESSION['view']=="true")) echo $encrypt->decode($_SESSION['password']); ?></td>
				</tr>
				<tr>
					<td>User Type:</td>
					<td><?php  if(isset($_SESSION['view'])&& ($_SESSION['view']=="true")){echo $_SESSION['user_type'];}?></td>
				</tr>
				<tr>
					<td>Effectivity Date: </td>
					<td><?php if(isset($_SESSION['view'])&& ($_SESSION['view']=="true")) echo $_SESSION['effectivity_date']; ?></td>
				</tr>
			</table>
