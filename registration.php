<div style="text-align: center; margin-top:250px">	
	<form method="POST">
		Login: <input type="text" name="login"><br>
		Password: <input type="text" name="pass"><br>
		Who are you? 
		<select name="usertype">
			<option value="cardealer">Car dealer</option>
			<option value="saab">Client</option>
		</select><br>
		<input type="submit" name="action" value="Register">
</form>
</div>


<?php 
if(!include_once('functionality/logger.php'))
	echo 'failed to include';


if(!($db = mysqli_connect("localhost", "root", "", "autospot_test")))
	echo 'pizdes';

if(!empty($_POST))
	$bRes = Logger::Register($_POST['login'], $_POST['pass'], $_POST['usertype'], $db);

 ?>