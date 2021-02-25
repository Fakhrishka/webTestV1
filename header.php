<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
<form method="POST">
	<div class="header" style="border: 1.5px solid black; padding-bottom: 50px">
		<input style="margin-left:85%; margin-top:10px" type="submit" name="action" value="Sign in">
		<input style="margin-top:10px" type="submit" name="action" value="Sign up">
	</div>	
</form>

</body>
</html>


<?php
if(!empty($_POST))
{
	if($_POST['action'] == 'Sign up')
	{
		echo 'wtf';
		header('Location: registration.php');
	}
	else if($_POST['action'] == 'Sign in')
		header('Location: logging.php');
}
?>