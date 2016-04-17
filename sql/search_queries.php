<?php
	require_once("db_config.php");
	require_once("./includes/User.class.php");

	//Search for mentors based on a combination of username, genre, and instrument
	function searchMentor($name, $genre, $instrument)
	{
		$users = array();
		try
		{
			$pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			//Prepare a statement by setting parameters

			//SQL STATEMENTS
			if ($genre == "*" && $instrument != "*")		//Genre ANY
				$sql_user = 'SELECT id FROM mm_users INNER JOIN mm_user_instruments ON mm_user_instruments.user_id = id WHERE mm_user_instruments.instrument_id = :inst AND mm_users.type = 1 AND mm_users.username LIKE :name';
			else if ($genre != "*" && $instrument == "*")	//Instrument ANY
				$sql_user = 'SELECT id FROM mm_users INNER JOIN mm_user_genres ON mm_user_genres.user_id = id WHERE mm_user_genres.genre_id = :genre AND mm_users.type = 1 AND mm_users.username LIKE :name';
			else if ($genre == "*" && $instrument == "*")	//Genre and Instrument ANY
				$sql_user = 'SELECT id FROM mm_users WHERE mm_users.type = 1 AND mm_users.username LIKE :name';
			else if ($genre != "*" && $instrument != "*")	//Genre and Instrument SET
				$sql_user = 'SELECT id FROM mm_users INNER JOIN mm_user_instruments ON mm_user_instruments.user_id = id INNER JOIN mm_user_genres ON mm_user_genres.user_id = id WHERE mm_user_instruments.instrument_id = :inst AND mm_user_genres.genre_id = :genre AND mm_users.type = 1 AND mm_users.username LIKE :name';
			$sql_name = 'SELECT username FROM mm_users WHERE id = :id';
			$sql_genre = 'SELECT genre FROM mm_genres INNER JOIN mm_user_genres ON mm_genres.id = mm_user_genres.genre_id WHERE mm_user_genres.user_id = :id';
			$sql_inst = 'SELECT instrument FROM mm_instruments INNER JOIN mm_user_instruments ON mm_instruments.id = mm_user_instruments.instrument_id WHERE mm_user_instruments.user_id = :id';

			//PREPARE STATEMENTS
			$statement_user = $pdo->prepare($sql_user);
			$statement_name = $pdo->prepare($sql_name);
			$statement_genre = $pdo->prepare($sql_genre);
			$statement_inst = $pdo->prepare($sql_inst);

			//BIND VALUES FOR INITIAL QUERY and EXECUTE
			$statement_user->bindValue(':name', $name);
			if ($genre != "*") $statement_user->bindValue(':genre', $genre);
			if ($instrument != "*") $statement_user->bindValue(':inst', $instrument); //Bind value of sql statement with value of id in query string

			$statement_user->execute();
			while ($row =  $statement_user->fetch())
			{
				$users[] = new User($row["id"], null);
			}

			//BIND VALUES FOR USERNAME, GENRES, INSTRUMENTS AND EXECUTE THE RESPECTIVE STATEMENTS
			foreach ($users as $u)
			{
				$genres = array();
				$inst = array();
				$statement_name->bindValue(':id', $u->getID());
				$statement_genre->bindValue(':id', $u->getID());
				$statement_inst->bindValue(':id', $u->getID());
				$statement_name->execute();
				while ($row = $statement_name->fetch())
				{
					$u->setUsername($row["username"]);
				}
				$statement_genre->execute();
				while ($row = $statement_genre->fetch())
				{
					$genres[] = $row["genre"];
				}
				$statement_inst->execute();
				while ($row = $statement_inst->fetch())
				{
					$inst[] = $row["instrument"];
				}
				$u->setGenres($genres);
				$u->setInstruments($inst);
			}
			$pdo = null;
		}

		catch (PDOException $e) {
			die( $e->getMessage() );
		}
		return $users;
	}


	//This function is used to populate drop-down lists with genres and instruments
	function getAllOptions($x)
	{
		$options = array();
		try
		{
			$pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			//Prepare a statement by setting parameters
			$sql = 'SELECT id, '.$x.' FROM mm_'.$x.'s';
			$statement = $pdo->prepare($sql);
			$statement->execute();

			while ($row =  $statement->fetch())
			{
				$options[] = ["id"=>$row["id"], "name"=>$row[$x]];
			}
			$pdo = null;
		}

		catch (PDOException $e) {
			die( $e->getMessage() );
		}
		return $options;
	}
?>