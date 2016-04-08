<?php
	require_once("db_config.php");

	//This function attempts to log a user in, returns false if it doesnt work
	function attemptLogin($username, $password, &$id)
	{
		try
		{
			$pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			//Prepare a statement by setting parameters
			$sql = 'SELECT id, username, password FROM mm_users WHERE username=:username';
			$statement = $pdo->prepare($sql);
			$statement->bindValue(':username', $username); //Bind value of sql statement with value of id in query string
			$statement->execute();

			while ($row = $statement->fetch())
			{
			    //PASSWORD HASHING DOESN'T WORK ON SCHOOL SERVER
			    //if (password_verify($password, $row['password']))
			    if ($password == $row['password'])
			    {
					$id = $row["id"];
					return true;
				}
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
			 $sql = 'INSERT INTO mm_users (username, password, email, type) VALUES (:username, :password, :email, :type)';
			 $statement = $pdo->prepare($sql);
			 $statement->bindValue(':username', $username); //Bind value of sql statement with value of id in query string

			 //PASSWORD HASHING DOESN'T WORK ON SCHOOL SERVER
			 //$password = password_hash($password, PASSWORD_DEFAULT);

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
	   	return false;
	}
	//This function checks to see if a username already exists (for registration purposes)
	function userExists($username)
	{
		try
		{
			$pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			//Prepare a statement by setting parameters
			$sql = 'SELECT username FROM mm_users WHERE username=:username';
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
	function getUserNames()
	{
		try
		{
			$pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			//Prepare a statement by setting parameters
			$sql = 'SELECT username FROM mm_users';
			$statement = $pdo->prepare($sql);
			$statement->execute();

			$names = array();
			while($result = $statement->fetch()){
				array_push($names,$result);
			}
			$pdo = null;
			return $names;
		}

		catch (PDOException $e) {
			die( $e->getMessage() );
		}
	}
	function addToken($name, $sess_id)
	{
		$id;
		$hashed_sess = hash("sha256", hash("md5", hash("sha256", $sess_id)));
		try
		{
			$pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			//Prepare a statement by setting parameters
			$sql_id = 'SELECT id FROM mm_users WHERE username = :name';
			$sql_auth = 'INSERT INTO mm_auth (token, user_id, selector) VALUES(:token, :u_id, :selector)';

			$statement_id = $pdo->prepare($sql_id);
			$statement_auth = $pdo->prepare($sql_auth);

			$statement_id->bindValue(':name', $name);
			$statement_auth->bindValue(':token', $hashed_sess);
			$statement_auth->bindValue(':selector', $sess_id);
			$statement_id->execute();

			while($row = $statement_id->fetch()){
				$id = $row["id"];
			}
			if (isset($id))
			{
				$statement_auth->bindValue(':u_id', $id);
				$statement_auth->execute();
			}

			$pdo = null;
		}

		catch (PDOException $e) {
			die( $e->getMessage() );
		}

	}
	function checkToken($sess_id)
	{
		$hashed_sess = hash("sha256", hash("md5", $sess_id));
		try
		{
			$pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			//Prepare a statement by setting parameters
			$sql_auth = 'SELECT user_id, selector FROM mm_auth WHERE token=:token';

			$statement_auth = $pdo->prepare($sql_auth);

			$statement_auth->bindValue(':token', $hashed_sess);

			$statement_auth->execute();

			while($row = $statement_auth->fetch()){
				return $row["selector"];
			}

			$pdo = null;
		}

		catch (PDOException $e) {
			die( $e->getMessage() );
		}
	}
	function deleteToken($sess_id, $user_id)
	{
		//$hashed_sess = hash("sha256", hash("md5", hash("sha256", $sess_id)));
		try
		{
			$pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			//Prepare a statement by setting parameters
			$sql_auth = 'DELETE FROM mm_auth WHERE selector=:sel AND user_id=:u_id';

			$statement_auth = $pdo->prepare($sql_auth);

			$statement_auth->bindValue(':sel', $sess_id);
			$statement_auth->bindValue(':u_id', $user_id);

			$statement_auth->execute();

			$pdo = null;
		}

		catch (PDOException $e) {
			die( $e->getMessage() );
		}
	}

	function getUserId($user){
		try
			{

				$pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
				$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				//Prepare a statement by setting parameters
				$sql = 'SELECT id FROM mm_users WHERE username=:user';
				$statement = $pdo->prepare($sql);
				$statement->bindValue(':user', $user);
				$statement->execute();


				$result = $statement->fetch();
				$userId = $result["id"];

				$pdo = null;
				return $userId;
			}

			catch (PDOException $e) {
				die( $e->getMessage() );
			}

	}
	function updateInfo($user, $input, $mode){
		if ($mode == "username" && userExists($input))
			return "That username is already taken.";
		switch ($mode) {
			case 'username':
				$sql = 'UPDATE mm_users SET username=:input WHERE id=:id';
				break;
			case 'password':
				$sql = 'UPDATE mm_users SET password=:input WHERE id=:id';
				break;
			case 'email':
				$sql = 'UPDATE mm_users SET email=:input WHERE id=:id';
				break;

			default:
				break;
		}
		try
			{
				$id = getUserId($user);
				$pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
				$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				//Prepare a statement by setting parameters

				$statement = $pdo->prepare($sql);
				$statement->bindValue(':input', $input);
				$statement->bindValue(':id', $user);
				$statement->execute();

				$pdo = null;
				if($mode=='username'){
					header("Location: logout.php");
				}
				return "Details successfully updated!";
			}

			catch (PDOException $e) {
				die( $e->getMessage() );
				return "An error occurred, please try again later.";
			}
	}
?>