<?php
	require_once("db_config.php");
	require_once("./includes/Appointment.class.php");

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
				$sql = 'SELECT mm_appointments.id, date, mm_users.username AS student_name, mm_appointments.mentor_id, start_time, end_time, mm_instruments.instrument, price, location, open FROM mm_appointments
				INNER JOIN mm_instruments ON mm_appointments.instrument_id = mm_instruments.id INNER JOIN mm_users ON mm_appointments.student_id = mm_users.id
				WHERE mm_appointments.mentor_id = (SELECT id FROM mm_users WHERE username = :name) AND open=:open';
			else
				$sql = 'SELECT mm_appointments.id, date, mm_appointments.mentor_id, start_time, end_time, mm_instruments.instrument, price, location, open FROM mm_appointments
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
				if ($open == 0)
					$appts[] = new Appointment($row["id"], $row["mentor_id"], $row["student_name"], $row["date"], $row["start_time"], $row["end_time"], $row["price"], $row["instrument"], $row["location"], $row["open"]);
				else
					$appts[] = new Appointment($row["id"], $row["mentor_id"], null, $row["date"], $row["start_time"], $row["end_time"], $row["price"], $row["instrument"], $row["location"], $row["open"]);
			}
			$pdo = null;
		}

		catch (PDOException $e) {
			die( $e->getMessage() );
		}
		return $appts;
	}

?>