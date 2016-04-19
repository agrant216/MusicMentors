<?php
	$error="";
	if (isset($_COOKIE["auth"]))
	{
		$sess = checkToken($_COOKIE["auth"]);
		if (isset($sess))
		{
			session_id($sess);
			session_start();
			header("Location: index.php");
		}
		else
			header("Location: logout.php");
	}
	else
	{
		session_start();
		if (isset($_SESSION["user_id"]))
			header("Location: index.php");

		if (isset($_POST["username"]) && isset($_POST["password"]))
		{
			$user_id;
			$user_type;
			if (attemptLogin($_POST["username"], $_POST["password"], $user_id, $user_type))
			{
				$_SESSION["username"] = $_POST["username"];
				$_SESSION["user_id"] = $user_id;
				$_SESSION["user_type"] = $user_type;
				if (isset($_POST["remember"]))
				{
					addToken($_POST["username"], session_id());
					setcookie("auth", hash("sha256", session_id()), time()+3600*24*30); //COULD HASH HERE USING DATABASE
				}
				header("Location:	index.php");
				exit();
			}
			else
			{
				if (!userExists($_POST['username']))
					$error = "User doesn't exist.";
				else
					$error = "Login failed, please check your username and password.";
			}
		}
	}
?>