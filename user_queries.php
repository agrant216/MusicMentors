<?php
	require_once("db_config.php");

	//This function attempts to log a user in, returns false if it doesnt work
	function attemptLogin($username, $password)
	{
		try
		{
			$pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			//Prepare a statement by setting parameters
			$sql = 'SELECT * FROM '.TAB_USER.' WHERE username=:username';
			$statement = $pdo->prepare($sql);
			$statement->bindValue(':username', $username); //Bind value of sql statement with value of id in query string
			$statement->execute();

			while ($row =  $statement->fetch())
			{
			    if (password_verify($password, $row['password']))
					return true;
				else
					return false;
			}
			$pdo = null;
		}

		catch (PDOException $e) {
			die( $e->getMessage() );
		}
		return false;
	}

	//This functon registers new users
	function registerUser($username, $password, $email, $type)
	{
		unset($_POST);
		try {
			 $pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
			 $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			//Prepare a statement by setting parameters
			 $sql = 'INSERT INTO '.TAB_USER.' VALUES (:username, :password, :email, :type)';
			 $statement = $pdo->prepare($sql);
			 $statement->bindValue(':username', $username); //Bind value of sql statement with value of id in query string
			 $password = password_hash($password, PASSWORD_DEFAULT);
			 $statement->bindValue(':password', $password);
			 $statement->bindValue(':email', $email);
			 $statement->bindValue(':type', $type);
			 $statement->execute();

			 $pdo = null;
			 return true;
		  }

		   catch (PDOException $e) {
		   		return false;
			  die( $e->getMessage() );
	   	}
	}
	//This function checks to see if a username already exists (for registration purposes)
	function userExists($username)
	{
		try
		{
			$pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			//Prepare a statement by setting parameters
			$sql = 'SELECT username FROM '.TAB_USER.' WHERE username=:username';
			$statement = $pdo->prepare($sql);
			$statement->bindValue(':username', $username); //Bind value of sql statement with value of id in query string
			$statement->execute();

			while ($row =  $statement->fetch())
			{
				return true;
			}
			$pdo = null;
		}

		catch (PDOException $e) {
			die( $e->getMessage() );
		}
		return false;
	}

?>