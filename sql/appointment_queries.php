<?php
	require_once("db_config.php");
	require_once("./includes/Appointment.class.php");
	date_default_timezone_set('UTC');

	function getAppointments($name, $open)
	{
		$appts = array();
		try
		{
			$pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			//Prepare a statement by setting parameters

			//SQL STATEMENTS
			if ($open == 0)
				$sql = 'SELECT mm_appointments.id, date, mm_users.username AS student_name, mm_appointments.mentor_id, start_time, end_time, mm_instruments.instrument, price, location, open, timezone FROM mm_appointments
				INNER JOIN mm_instruments ON mm_appointments.instrument_id = mm_instruments.id INNER JOIN mm_users ON mm_appointments.student_id = mm_users.id
				WHERE mm_appointments.mentor_id = (SELECT id FROM mm_users WHERE username = :name) AND open=:open';
			else
				$sql = 'SELECT mm_appointments.id, date, mm_appointments.mentor_id, start_time, end_time, mm_instruments.instrument, price, location, open, timezone FROM mm_appointments
				INNER JOIN mm_instruments ON mm_appointments.instrument_id = mm_instruments.id
				WHERE mm_appointments.mentor_id = (SELECT id FROM mm_users WHERE username = :name) AND open=:open';

			//PREPARE STATEMENTS
			$statement = $pdo->prepare($sql);

			//BIND VALUES FOR INITIAL QUERY and EXECUTE
			$statement->bindValue(':name', $name);
			$statement->bindValue(':open', $open);

			$statement->execute();
			while ($row =  $statement->fetch())
			{
				if (strtotime($row["date"])<strtotime(date("Y-m-d")))
				{
					deleteAppointment($row["id"]);
					continue;
				}
				if ($open == 0)
					$appts[] = new Appointment($row["id"], $row["mentor_id"], $row["student_name"], $row["date"], $row["start_time"], $row["end_time"], $row["price"], $row["instrument"], $row["location"], $row["open"], $row["timezone"]);
				else
					$appts[] = new Appointment($row["id"], $row["mentor_id"], null, $row["date"], $row["start_time"], $row["end_time"], $row["price"], $row["instrument"], $row["location"], $row["open"], $row["timezone"]);
			}
			$pdo = null;
		}

		catch (PDOException $e) {
			die( $e->getMessage() );
		}
		return $appts;
	}

	function getAppointmentByID($id)
	{
		$appts;
		try
		{
			$pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			//Prepare a statement by setting parameters

			//SQL STATEMENTS
			$sql = 'SELECT mm_appointments.id, mentor_id, date, start_time, end_time, mm_instruments.instrument, price, location, open, timezone FROM mm_appointments
			INNER JOIN mm_instruments on mm_appointments.instrument_id = mm_instruments.id
			WHERE mm_appointments.id = :id';

			//PREPARE STATEMENTS
			$statement = $pdo->prepare($sql);

			//BIND VALUES FOR INITIAL QUERY and EXECUTE
			$statement->bindValue(':id', $id);

			$statement->execute();
			while ($row =  $statement->fetch())
			{
				$appts = new Appointment($row["id"], $row["mentor_id"], null, $row["date"], $row["start_time"], $row["end_time"], $row["price"], $row["instrument"], $row["location"], $row["open"], $row["timezone"]);
			}
			$pdo = null;
		}

		catch (PDOException $e) {
			die( $e->getMessage() );
		}
		return $appts;
	}

	function getAppointmentByLoc($location)
	{
		$appts;
		try
		{
			$pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			//Prepare a statement by setting parameters

			//SQL STATEMENTS
			$sql = 'SELECT mm_appointments.id, mentor_id, date, start_time, end_time, mm_instruments.instrument, price, location, open FROM mm_appointments
			INNER JOIN mm_instruments on mm_appointments.instrument_id = mm_instruments.id
			WHERE mm_appointments.location = :location';

			//PREPARE STATEMENTS
			$statement = $pdo->prepare($sql);

			//BIND VALUES FOR INITIAL QUERY and EXECUTE
			$statement->bindValue(':location', $location);

			$statement->execute();
			while ($row =  $statement->fetch())
			{
				$appts = new Appointment($row["id"], $row["mentor_id"], null, $row["date"], $row["start_time"], $row["end_time"], $row["price"], $row["instrument"], $row["location"], $row["open"]);
			}
			$pdo = null;
		}

		catch (PDOException $e) {
			die( $e->getMessage() );
		}
		return $appts;
	}

	function getAppointmentsByStudentID($id)
	{
		$appts = array();
		try
		{
			$pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			//Prepare a statement by setting parameters

			//SQL STATEMENTS
			$sql = 'SELECT mm_appointments.id, mentor_id, date, start_time, end_time, mm_instruments.instrument, price, location, open, timezone FROM mm_appointments
			INNER JOIN mm_instruments on mm_appointments.instrument_id = mm_instruments.id
			WHERE mm_appointments.student_id = :id';

			//PREPARE STATEMENTS
			$statement = $pdo->prepare($sql);

			//BIND VALUES FOR INITIAL QUERY and EXECUTE
			$statement->bindValue(':id', $id);

			$statement->execute();
			while ($row =  $statement->fetch())
			{
				$appts[] = new Appointment($row["id"], $row["mentor_id"], null, $row["date"], $row["start_time"], $row["end_time"], $row["price"], $row["instrument"], $row["location"], $row["open"], $row["timezone"]);
			}
			$pdo = null;
		}

		catch (PDOException $e) {
			die( $e->getMessage() );
		}
		return $appts;
	}

	function checkAppointmentValues($values)
	{
		if(!strtotime($values["date"]) || strtotime($values["date"])<strtotime(date("Y-m-d")))
			return false;
		if (!preg_match("/^(2[0-3]|[01][0-9]):([0-5][0-9])$/", $values["startTime"]))
			return false;
		if (!preg_match("/^(2[0-3]|[01][0-9]):([0-5][0-9])$/", $values["endTime"]))
			return false;
		if (!preg_match("/^-?\d+(\.\d{2})?$/", $values["price"]) || $values["price"] < 1)
			return false;
		return true;
	}

	function addAppointment($values, $id)
	{
		$error="";
		try
		{
			$pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			//Prepare a statement by setting parameters

			//SQL STATEMENTS
			$sql = 'INSERT INTO mm_appointments(mentor_id, date, start_time, end_time, price, instrument_id, location, open, timezone) VALUES(:id, :date, :s_t, :e_t, :price, :inst, :loc, "1", :tz)';

			//PREPARE STATEMENTS
			$statement = $pdo->prepare($sql);

			//BIND VALUES FOR INITIAL QUERY and EXECUTE
			$statement->bindValue(':id', $id);
			$statement->bindValue(':date', $values["date"]);
			$statement->bindValue(':s_t', $values["startTime"]);
			$statement->bindValue(':e_t', $values["endTime"]);
			$statement->bindValue(':price', $values["price"]);
			$statement->bindValue(':inst', $values["option_instrument"]);
			$statement->bindValue(':loc', $values["location"]);
			$statement->bindValue(':tz', $values["timezone"]);

			$statement->execute();
			$pdo = null;
			$error="Success! Appointment added.";
		}

		catch (PDOException $e) {
			$error = "Unexpected error, please try again later.";
			die( $e->getMessage() );
		}
		return $error;
	}
function addLocation($user_id,$values){
		$a = getAppointmentByLoc($values["location"]);
		$username = getUsername($a->getMentorID());
		$info = "<div><h2>".$username."</h2><h4>".$a->getLocation()."</h4><h4>".$a->getDate()."</h4><h4>".$a->getStartTime()." - ".$a->getEndTime()."</h4><h4>".$a->getInstrument()."</h4><h4>".$a->getPrice()."</h4><h3><a href='userPage.php?user=".$username."'>Visit User Page</a></h3></div>";
		try {
			 $pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
			 $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			//Prepare a statement by setting parameters
			 $sql = 'INSERT INTO mm_locations (appt_id, address, lat, lng, marker) VALUES (:appt_id, :address, :lat, :lng, :marker)';
			 $statement = $pdo->prepare($sql);

			 $statement->bindValue(':appt_id', $a->getAppointmentID()); //Bind value of sql statement with value of id in query string
			 $statement->bindValue(':address', $values["location"]);
			 $statement->bindValue(':lat', $values["lat"]);
			 $statement->bindValue(':lng', $values["lng"]);
			 $statement->bindValue(':marker', $info);
			 $statement->execute();
			 $pdo = null;
		  }

		   catch (PDOException $e) {
			  die( $e->getMessage() );
	   		}

	}
	function deleteAppointment($id)
	{
		try
		{
			$pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			//Prepare a statement by setting parameters

			//SQL STATEMENTS
			$sql = 'DELETE FROM mm_appointments WHERE id=:id';

			//PREPARE STATEMENTS
			$statement = $pdo->prepare($sql);

			//BIND VALUES FOR INITIAL QUERY and EXECUTE
			$statement->bindValue(':id', $id);

			$statement->execute();
			$pdo = null;
		}

		catch (PDOException $e) {
			die( $e->getMessage() );
		}
	}

	function updateAppointmentStudent($id, $studentID, $index)
	{
		$error="";
		try
		{
			$pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			//Prepare a statement by setting parameters

			if (!getAppointmentByID($id)->getOpen())
			{
				$error="Appointment $index has already been booked.";
				return $error;
			}
			//SQL STATEMENTS
			$sql = 'UPDATE mm_appointments SET open = 0, student_id = :s_id WHERE id = :id';

			//PREPARE STATEMENTS
			$statement = $pdo->prepare($sql);

			//BIND VALUES FOR INITIAL QUERY and EXECUTE
			$statement->bindValue(':id', $id);
			$statement->bindValue(':s_id', $studentID);

			$statement->execute();
			$pdo = null;
			$error = "Successfully booked appointment!";
			return $error;
		}

		catch (PDOException $e) {
			$error = "An unexpected error occurred, please try again later.";
			return $error;
			die( $e->getMessage() );
		}
	}
	function updateAppointmentInfo($values, $id)
	{
		$error="";
		try
		{
			$pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			//Prepare a statement by setting parameters

			//SQL STATEMENTS
			$sql = 'UPDATE mm_appointments SET date=:date, start_time=:s_t, end_time=:e_t, price=:price, instrument_id=:inst, location=:loc, timezone=:tz WHERE id = :id';

			//PREPARE STATEMENTS
			$statement = $pdo->prepare($sql);

			//BIND VALUES FOR INITIAL QUERY and EXECUTE
			$statement->bindValue(':id', $id);
			$statement->bindValue(':date', $values["date"]);
			$statement->bindValue(':s_t', $values["startTime"]);
			$statement->bindValue(':e_t', $values["endTime"]);
			$statement->bindValue(':price', $values["price"]);
			$statement->bindValue(':inst', $values["option_instrument"]);
			$statement->bindValue(':loc', $values["location"]);
			$statement->bindValue(':tz', $values["timezone"]);

			$statement->execute();
			$pdo = null;
			$error="Success! Appointment updated.";
		}

		catch (PDOException $e) {
			$error = "Unexpected error, please try again later.";
			die( $e->getMessage() );
		}
		return $error;
	}
?>