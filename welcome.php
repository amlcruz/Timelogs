<form>
  <fieldset>
    <legend>Welcome, <?php if (isset($_COOKIE["fname"])) echo $_COOKIE["fname"]; ?>!</legend>
	    <div class="row">
	      <div class="large-12 columns">
	        <a href="main.php?linkPass=0" name="home">Home</a>
	        <br />
	        <a href="main.php?linkPass=1" name="viewLog">View Logs</a>
	        <br />
	        <a href="update_password.php" name="accManage" data-reveal-id="myModal2" data-reveal-ajax="true">Account Management</a>
	        <br /><br /><br />
	        <a href="logout.php" name="accManage">Logout</a>
	      </div>
	    </div>
    </fieldset>
</form>

<div id="myModal2" class="reveal-modal">
 
  
</div>