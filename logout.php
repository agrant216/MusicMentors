<?php
	require_once("sql/queries.php");
	session_start();
	if (session_status() == PHP_SESSION_ACTIVE)
	{
		if (isset($_COOKIE["auth"]))
		{
			setcookie("auth", "", time()-3600*24*30);
			deleteToken(session_id(), $_SESSION["user_id"]);
		}
		session_unset();
		session_destroy();
	}
	header("Location: ".$_SERVER["HTTP_REFERER"]);

?>