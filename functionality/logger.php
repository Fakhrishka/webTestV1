<?php   
class Logger
{
	static function Login(string $sLogin, string $sPass, $db)
	{
		// checking data in DB
		// if(!($db = mysqli_connect("localhost", "root", "", "autospot_test")))
		// 	echo 'pizdes';

		$query = mysqli_query($db, "SELECT USER_ID,PASS FROM users WHERE LOGIN='".mysqli_real_escape_string($db, $sLogin)."'");
		$arData = mysqli_fetch_assoc($query);

		if($arData['PASS'] == md5(md5($sPass)))
		{
			$sNewHash = md5(md5(self::generateCode(10)));
			if(!mysqli_query($db,"UPDATE users SET HASH='".$sNewHash."' WHERE USER_ID='".$arData['USER_ID']."'"))
				echo 'user not added';

			setcookie("id", $arData['USER_ID'], time()+60*60*24*30, "/");
			setcookie("hash", $sNewHash, time()+60*60*24*30, "/", null, null, true);

			echo 'Login finished...<br>';
			self::FinalCheckUp($arData['USER_ID'], $sNewHash, $db);
			exit();
		}
		else
		{
			echo 'Password is wrong...';
			return false;
		}

	}

	static function Register(string $sLogin, string $sPass, string $sUserType, $db)
	{
			// register new user
			// if(!($db = mysqli_connect("localhost", "root", "", "autospot_test")))
			// 	echo 'pizdes';


			$query = mysqli_query($db, "SELECT USER_ID FROM users WHERE LOGIN='".mysqli_real_escape_string($db, $sLogin)."'");
			if(mysqli_num_rows($query) > 0)
			{
					echo 'user exists...';
					return false;
			}

			$password = md5(md5(trim($sPass)));
			if(!mysqli_query($db,"INSERT INTO users SET LOGIN='".$sLogin."', PASS='".$password."', USER_TYPE='".$sUserType."'"))
					echo 'user not added';
			echo 'Register finished...<br>';
			self::Login($sLogin, $sPass, $db);
			exit();

	}

	static function generateCode($length=6)
	{
		$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHI JKLMNOPRQSTUVWXYZ0123456789";
		$code = "";
		$clen = strlen($chars) - 1;
		while (strlen($code) < $length)
			$code .= $chars[mt_rand(0,$clen)];
		return $code;
	}

	static function Logout()
	{
		setcookie("id", "", time() - 3600*24*30*12, "/");
		setcookie("hash", "", time() - 3600*24*30*12, "/", null, null, true);

		header("Location: /");
	}

	static function ChangePass(string $sNewPass, string $sOldPass, $db)
	{
		// if(!($db = mysqli_connect("localhost", "root", "", "autospot_test")))
		// 	echo 'pizdes';		

		$query = mysqli_query($db, "SELECT USER_ID,PASS FROM users WHERE USER_ID='".$_COOKIE['id']."'");
		$arData = mysqli_fetch_assoc($query);

		if($arData['PASS'] == md5(md5($sOldPass)))
		{
			$sNewHash = md5(md5(self::generateCode(10)));
			if(!mysqli_query($db,"UPDATE users SET HASH='".$sNewHash."',PASS='".md5(md5(trim($sNewPass))) ."' WHERE USER_ID='".$arData['USER_ID']."'"))
				echo 'user not added';

			setcookie("id", $arData['USER_ID'], time()+60*60*24*30, "/");
			setcookie("hash", $sNewHash, time()+60*60*24*30, "/", null, null, true);

			echo 'Pass change finished...<br>';
			self::FinalCheckUp($arData['USER_ID'], $sNewHash, $db);
			exit();
		}
		else
			echo 'Old password is wrong';

	}

	static function FinalCheckUp(int $nUserId, string $sCookieHash, $db)
	{
		// if(!($db = mysqli_connect("localhost", "root", "", "autospot_test")))
		// 	echo 'pizdes';


		$query = mysqli_query($db, "SELECT LOGIN,USER_ID,HASH FROM users WHERE USER_ID = '".intval($nUserId)."' LIMIT 1");
		$arUserData = mysqli_fetch_assoc($query);


		if(($arUserData['HASH'] !== $sCookieHash))
		{
			setcookie("id", "", time() - 3600*24*30*12, "/");
			setcookie("hash", "", time() - 3600*24*30*12, "/", null, null, true); // httponly !!!
			echo "Cookie error"; // CATCH THIS MF
		}
		else
		{
			header("Location: /");
		}
	}
}
?>