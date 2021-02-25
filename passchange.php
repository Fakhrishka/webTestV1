<!DOCTYPE html>
<html>
<head>
	<title>	Password change</title>
</head>
<body>
	<form method="POST">	
		Enter old password: <input type="text" name="oldpass"><br>
		Enter new password: <input type="text" name="newpass"><br>
		<input type="submit" name="submit" value="Submit">
	</form>
</body>
</html>

<?php
	include_once('functionality/logger.php');
	if(!($db = mysqli_connect("localhost", "root", "", "autospot_test")))
		echo 'pizdes';

	if(isset($_POST['submit'])
		&& isset($_POST['oldpass']) && !empty($_POST['oldpass']) && is_string($_POST['oldpass'])
		&& isset($_POST['newpass']) && !empty($_POST['newpass']) && is_string($_POST['newpass'])
	)
		Logger::ChangePass($_POST['newpass'], $_POST['oldpass']);
?>