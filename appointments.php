<?php
	require_once("sql/queries.php");
	session_start();

	if (!isset($_SESSION["user_id"]))
		header("Location: index.php");

	if ($_SERVER["REQUEST_METHOD"] == "POST")
	{
		if (isset($_POST["submit"]) && $_POST["submit"] == "delete")
		{
			deleteAppointment($_POST["selectedAppt"]);
		}
		if (isset($_POST["submit"]) && $_POST["submit"] == "edit")
		{
			$_SESSION["appt"] = $_POST["selectedAppt"];
			header("Location: editAppointment.php");
		}

	}
	function displayAppointments($open, $caption, $student)
	{
		if ($student)
			$appointments = getAppointmentsByStudentID($_SESSION["user_id"]);
		else
			$appointments = getAppointments($_SESSION["username"], $open);
		echo '<form role="form" method="post">
		<table class="table table-hover">
		<caption>'.$caption.'</caption>
			<thead>
			<tr>';
			if (!$open)
				echo '<th>Student</th>';
			else
				echo '<th></th>';
			echo '
				<th>Date</th>
				<th>Start Time</th>
				<th>End Time</th>
				<th>Time Zone</th>
				<th>Instrument</th>
				<th>Price</th>
				<th>Location</th>
			</tr>
			</thead>
			<tbody>';
		if (!empty($appointments))
		{
			foreach ($appointments as $a)
			{
				echo '<tr>';
				if (!$open)
					echo '<td><a href="userPage.php?user='.$a->getStudentUsername().'">'.$a->getStudentUsername().'</td>';
				else
					echo '<td><input type="radio" name="selectedAppt" value='.$a->getAppointmentID().'></td>';
					echo '
						<td>'.$a->getDate().'</td>
						<td>'.$a->getStartTime().'</td>
						<td>'.$a->getEndTime().'</td>
						<td>'.$a->getTimeZone().'</td>
						<td>'.$a->getInstrument().'</td>
						<td>$'.number_format($a->getPrice(), 2, '.', ',').' USD</td>
						<td>'.$a->getLocation().'</td>
					</tr>';
			}
		}
		else
		{
			echo '<tr><td colspan="7">No results to display</td></tr>';
		}
		echo '</tbody>
			</table>';
		if ($open)
		{
			echo '<button type="submit" class="button warning large expanded" name="submit" value="edit">Edit Appointment</button>';
			echo '<button type="submit" class="button danger large expanded" name="submit" value="delete">Delete Appointment</button>';

		}
		echo '</form>';
	}

?>

<!doctype html>
<html class="no-js" lang="en" dir="ltr">
<head>
	<meta charset="utf-8"/>
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	<title>Music Mentors</title>

	<link rel="stylesheet" href="assets/css/foundation.min.css">
	<link rel="stylesheet" href="assets/css/userprofile.css">
</head>
<body>
	<?php include("includes/mm_header.inc.php");?>
	<div class="row">
		<div class="medium-6 large-12 columns">
			<div class="page-header">
               <h2>Appointments</h2>
            </div>
			<?php
			if ($_SESSION["user_type"] == 1)
			{
				displayAppointments(0, "CLOSED APPOINTMENTS", false);
				displayAppointments(1, "OPEN APPOINTMENTS", false);
			}
			displayAppointments(0, "MY APPOINTMENTS", true);
			?>
		</div>
	</div>
	<?php include("includes/mm_footer.inc.php");?>
	<script src="assets/js/vendor/jquery.js"></script>
	<script src="assets/js/vendor/foundation.js"></script>
	<script>
		$(document).foundation();
	</script>
</body>
</html>