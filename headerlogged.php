<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
<form method="POST">
	<div class="header" style="border: 1.5px solid black; padding-bottom: 50px">
		<input style="margin-left:70%; margin-top:10px" type="submit" name="logout" value='Logout'>
		<input style="margin-top:10px" type="submit" name="changepass" value='Change password'>
	</div>	
</form>

</body>
</html>


<?php 	
include_once('functionality/logger.php');
if(isset($_POST['logout']))
	Logger::Logout();
else if(isset($_POST['changepass']))
	Header('Location: passchange.php');
	
?>
