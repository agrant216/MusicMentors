<?php
require_once("db_config.php");
require_once("./includes/Order.class.php");
	function addOrder($student_id, $total)
	{
		try
		{
			$pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			//Prepare a statement by setting parameters

			//SQL STATEMENTS
			$sql = 'INSERT INTO mm_orders (student_id, date_time, total) VALUES (:id, :date, :total)';

			//PREPARE STATEMENTS
			$statement = $pdo->prepare($sql);

			//BIND VALUES FOR INITIAL QUERY and EXECUTE
			$statement->bindValue(':id', $student_id);
			$statement->bindValue(':date', date("Y-m-d H:i:s"));
			$statement->bindValue(':total', $total);

			$statement->execute();
			$pdo = null;
			$error = "Successfully placed order!";
			return $error;
		}

		catch (PDOException $e) {
			$error = "An unexpected error occurred, please try again later.";
			return $error;
			die( $e->getMessage() );
		}
	}
	function getOrdersByStudentID($id)
	{
		$orders = array();
		try
		{
			$pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			//Prepare a statement by setting parameters

			//SQL STATEMENTS
			$sql = 'SELECT id, student_id, date_time, total FROM mm_orders WHERE student_id = :id';

			//PREPARE STATEMENTS
			$statement = $pdo->prepare($sql);

			//BIND VALUES FOR INITIAL QUERY and EXECUTE
			$statement->bindValue(':id', $id);

			$statement->execute();
			while ($row =  $statement->fetch())
			{
				$orders[] = new Order($row["id"], $row["student_id"], $row["date_time"], $row["total"]);
			}
			$pdo = null;
		}

		catch (PDOException $e) {
			die( $e->getMessage() );
		}
		return $orders;
	}
?>