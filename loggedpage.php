<form method="POST">
	<input type="submit" name="logout" value='Logout'><br>
	<input type="submit" name="changepass" value='Change password'>
	<!-- <input type="text" id="passchange" hidden> -->
</form>

<?php 	

include_once('functionality/logger.php');
if(isset($_POST['logout']))
	Logger::Logout();
else if(isset($_POST['changepass']))
	Header('Location: passchange.php');
	
?>
