<?php
	require_once("db_config.php");
	require_once("./includes/User.class.php");
	require_once("./includes/Review.class.php");

	function getAllInfo($name)
	{
		$user;
		try
		{
			$pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			//Prepare a statement by setting parameters

			//SQL STATEMENTS
			$sql_user = 'SELECT id, username, bio, email, type, profile_image_name FROM mm_users WHERE username = :name';
			$sql_genre = 'SELECT genre FROM mm_genres INNER JOIN mm_user_genres ON mm_genres.id = mm_user_genres.genre_id WHERE mm_user_genres.user_id = :id';
			$sql_inst = 'SELECT instrument FROM mm_instruments INNER JOIN mm_user_instruments ON mm_instruments.id = mm_user_instruments.instrument_id WHERE mm_user_instruments.user_id = :id';

			//PREPARE STATEMENTS
			$statement_user = $pdo->prepare($sql_user);
			$statement_genre = $pdo->prepare($sql_genre);
			$statement_inst = $pdo->prepare($sql_inst);

			//BIND VALUES FOR INITIAL QUERY and EXECUTE
			$statement_user->bindValue(':name', $name);

			$statement_user->execute();
			while ($row =  $statement_user->fetch())
			{
				$user = new User($row["id"], $row["username"]);
				$user->setBiography($row["bio"]);
				$user->setEmail($row["email"]);
				$user->setType($row["type"]);
				$user->setImageFileName($row["profile_image_name"]);
			}

			//BIND VALUES FOR USERNAME, GENRES, INSTRUMENTS AND EXECUTE THE RESPECTIVE STATEMENTS
			$genres = array();
			$inst = array();
			$statement_genre->bindValue(':id', $user->getID());
			$statement_inst->bindValue(':id', $user->getID());

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
			$user->setGenres($genres);
			$user->setInstruments($inst);

			$pdo = null;
		}

		catch (PDOException $e) {
			die( $e->getMessage() );
		}
		return $user;
	}

	function getReviews($name)
	{
		$reviews = array();
		try
		{
			$pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			//Prepare a statement by setting parameters

			//SQL STATEMENTS
			$sql = 'SELECT mm_users.username, review_date, review_text, rating, mm_reviews.id FROM mm_users INNER JOIN mm_reviews ON mm_users.id = mm_reviews.student_id WHERE mm_reviews.mentor_id = (SELECT id FROM mm_users WHERE username = :name)';

			//PREPARE STATEMENTS
			$statement = $pdo->prepare($sql);

			//BIND VALUES FOR INITIAL QUERY and EXECUTE
			$statement->bindValue(':name', $name);

			$statement->execute();
			while ($row =  $statement->fetch())
			{
				$reviews[] = new Review($row["id"], $row["username"], $row["review_date"], $row["review_text"], $row["rating"]);
			}
			$pdo = null;
		}

		catch (PDOException $e) {
			die( $e->getMessage() );
		}
		return $reviews;
	}

	function addReview($mentorID, $studentID, $reviewText, $rating)
	{
		try
		{
			$pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			//Prepare a statement by setting parameters

			//SQL STATEMENTS
			$sql = 'INSERT INTO mm_reviews (mentor_id, student_id, review_date, review_text, rating) VALUES (:m_id, :s_id, :date, :text, :rating)';

			//PREPARE STATEMENTS
			$statement = $pdo->prepare($sql);

			//BIND VALUES FOR INITIAL QUERY and EXECUTE
			$statement->bindValue(':m_id', $mentorID);
			$statement->bindValue(':s_id', $studentID);
			$statement->bindValue(':date', date("Y-m-d"));
			$statement->bindValue(':text', $reviewText);
			$statement->bindValue(':rating', $rating);

			$statement->execute();
			$pdo = null;
		}

		catch (PDOException $e) {
			die( $e->getMessage() );
		}
	}

	function submitChanges($id, $bio, $instruments, $genres, $imageFile)
	{
		global $user;
		$max_file_size = 1048576;
		$validExt = array("jpg", "jpeg", "png");
		$validMime = array("image/jpeg", "image/png");

		if ($imageFile != null)
		{
			if ($imageFile["size"] > $max_file_size)
			{
				echo "File too big";
			}
			else
			{
				$fileToMove = $imageFile["tmp_name"];
				$destination = "./profile_images/".$imageFile["name"];
				$extension = end(explode(".", $imageFile["name"]));
				if (in_array($imageFile["type"], $validMime) && in_array($extension, $validExt))
				{
					if (move_uploaded_file($fileToMove, $destination))
					{

					}
					else
					{
						echo "Problem moving file";
					}
				}
				else
					echo "Invalid MIME type or extension";
			}
		}

		try
		{
			$pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			//Prepare a statement by setting parameters

			//SQL STATEMENTS
			$sql_delete_genres = 'DELETE FROM mm_user_genres WHERE user_id = :id';
			$sql_delete_instruments = 'DELETE FROM mm_user_instruments WHERE user_id = :id';
			$sql_update_user = 'UPDATE mm_users SET bio = :bio, profile_image_name = :file WHERE id = :id';
			$sql_insert_genres = 'INSERT INTO mm_user_genres VALUES (:id, :genre)';
			$sql_insert_instruments ='INSERT INTO mm_user_instruments VALUES (:id, :inst)';
			//PREPARE STATEMENTS
			$statement_del_g = $pdo->prepare($sql_delete_genres);
			$statement_del_i = $pdo->prepare($sql_delete_instruments);
			$statement_up = $pdo->prepare($sql_update_user);
			$statement_ins_g = $pdo->prepare($sql_insert_genres);
			$statement_ins_i = $pdo->prepare($sql_insert_instruments);

			//BIND VALUES FOR INITIAL QUERY and EXECUTE
			$statement_del_g->bindValue(':id', $id);
			$statement_del_i->bindValue(':id', $id);
			$statement_up->bindValue(':id', $id);
			$statement_ins_g->bindValue(':id', $id);
			$statement_ins_i->bindValue(':id', $id);
			$statement_up->bindValue(':bio', $bio);
			if ($imageFile != null)
				$statement_up->bindValue(':file', $imageFile['name']);
			else
				$statement_up->bindValue(':file', $user->getImageFileName());

			//Execute deletes and user table update
			$statement_del_g->execute();
			$statement_del_i->execute();
			$statement_up->execute();

			//Execute insert statements for each new record
			foreach ($genres as $g)
			{
				$statement_ins_g->bindValue(':genre', $g);
				$statement_ins_g->execute();
			}
			foreach ($instruments as $i)
			{
				$statement_ins_i->bindValue(':inst', $i);
				$statement_ins_i->execute();
			}
			$pdo = null;
		}

		catch (PDOException $e) {
			die( $e->getMessage() );
		}

	}
?>