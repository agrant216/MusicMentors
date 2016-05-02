<?php
	require_once("sql/queries.php");
	session_start();

	if ($_SESSION["user_type"] == 0)
		header("Location: index.php");

	$appt=null;
	if (isset($_SESSION["appt"]))
		$appt = getAppointmentByID($_SESSION["appt"]);

	$error = "";
	if (isset($_POST) && !empty($_POST))
	{
		if (checkAppointmentValues($_POST) && isset($_SESSION["appt"]))
		{
			$error = updateAppointmentInfo($_POST, $_SESSION["appt"]);
			unset($_SESSION["appt"]);
		}
		else if (!isset($_SESSION["appt"]))
			$error = "No valid appointment selected for editing.";
		else if (!checkAppointmentValues($_POST))
			$error = "Please check input values";
	}

	function displaySearchOptions($option, $appt)
	{
		foreach (getAllOptions($option) as $g)
		{
			if ((isset($_POST["option_".$option]) && $_POST["option_".$option] == $g["id"]) || ($appt!=null && $appt->getInstrument() == $g["name"]))
				echo '<option value="'.$g["id"].'" selected>'.$g["name"].'</option>';
			else
				echo '<option value="'.$g["id"].'">'.$g["name"].'</option>';
		}
	}
	function displayForm($appt)
	{
		echo '<form id="login" role="form" method="post">
			<label for="date">Date:</label>
			';
		if (!isset($_SESSION["appt"]))
			echo '<input type="date" name="date" min="'.date("Y-m-d").'" required="required" data-validation-help="This is the date of the appointment.It must be a valid date in the following format MM/DD/YYYY starting from '.date("m/d/Y").'" data-validation-error-msg="Must be a valid date in the following format MM/DD/YYYY starting from '.date("m/d/Y").'">';
		else
			echo '<input type="date" name="date" min="'.date("Y-m-d").'" value="'.$appt->getDate().'" required="required" data-validation-help="This is the date of the appointment.It must be a valid date in the following format MM/DD/YYYY starting from '.date("m/d/Y").'" data-validation-error-msg="Must be a valid date in the following format MM/DD/YYYY starting from '.date("m/d/Y").'">';
			echo '<label for="startTime">Start Time:</label>';
		if (!isset($_SESSION["appt"]))
			echo '<input type="time" name="startTime" required="required" data-validation-help="This is time that the appointment will start. It must be a valid time in the following format HH:MM AM/PM using the 12 hour clock" data-validation-error-msg="Must be a valid time in the following format HH:MM AM/PM using the 12 hour clock">';
		else
			echo '<input type="time" name="startTime" value="'.$appt->getStartTime().'" required="required" data-validation-help="This is time that the appointment will start. It must be a valid time in the following format HH:MM AM/PM using the 12 hour clock" data-validation-error-msg="Must be a valid time in the following format HH:MM AM/PM using the 12 hour clock">';
		echo '<label for="endTime">End Time:</label>';
		if (!isset($_SESSION["appt"]))
			echo '<input type="time" name="endTime" required="required" data-validation-help="This is the time that the appointment will end. It must be a valid time in the following format HH:MM AM/PM using the 12 hour clock" data-validation-error-msg="Must be a valid time in the following format HH:MM AM/PM using the 12 hour clock">';
		else
			echo '<input type="time" name="endTime" value="'.$appt->getEndTime().'" required="required" data-validation-help="This is the time that the appointment will end. It must be a valid time in the following format HH:MM AM/PM using the 12 hour clock" data-validation-error-msg="Must be a valid time in the following format HH:MM AM/PM using the 12 hour clock">';
		echo '<label for="timezone">Time Zone:</label>';
		if (!isset($_SESSION["appt"]))
			include("includes/timezone.php");
		else
			include("includes/timezone.php");
		echo '<label for="price">Price (USD):</label>';
		if (!isset($_SESSION["appt"]))
			echo '<input type="number" name="price" min="1" step=".01" pattern="^-?\d+(\.\d{2})?$" required="required" data-validation-help="Enter the price of the lesson as a decimal value in United States Dollars (USD). Minimum of $1.00" data-validation-error-msg="The value must be a decimal with a minimum value of 1.00.">';
		else
			echo '<input type="number" name="price" value="'.$appt->getPrice().'" min="1" step=".01" pattern="^-?\d+(\.\d{2})?$" required="required" data-validation-help="Enter the price of the lesson as a decimal value in United States Dollars (USD). Minimum of $1.00" data-validation-error-msg="The value must be a decimal with a minimum value of 1.00.">';
		echo '<label for="option_instrument">Instrument:</label>';

		echo '<select class="form-control" name="option_instrument">';
		displaySearchOptions("instrument", $appt);
		echo '</select>';

		echo '<label for="location">Location:</label>';
		if (!isset($_SESSION["appt"]))
			echo '<input id="autocomplete" onFocus="geolocate()" type="text" name="location" placeholder="Enter Online for online lesson" required="required" data-validation-help="This is the location of the lesson. Enter Online for an online lesson." data-validation-error-msg="Enter a valid location or Online for an Online lesson">';
		else
			echo '<input id="autocomplete" onFocus="geolocate()" type="text" name="location" value="'.$appt->getLocation().'" placeholder="Enter Online for online lesson" required="required" data-validation-help="This is the location of the lesson. Enter Online for an online lesson." data-validation-error-msg="Enter a valid location or Online for an Online lesson">';
		echo '<input type="hidden" id="lat" name="lat">
			<input type="hidden"id="lng" name="lng">';
		echo '<button class="button success large expanded" type="submit">Update Appointment</button>';
		echo '</form>';
	}
?>

<!doctype html>
<html class="no-js" lang="en" dir="ltr">
<head>
	<meta charset="utf-8"/>
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	<title>Music Mentors</title>
	<!-- Bootstrap core CSS  -->
	<link rel="stylesheet" href="assets/css/foundation.min.css">
	<link rel="stylesheet" href="assets/css/userprofile.css">
</head>
<body>
	<?php include("includes/mm_header.inc.php");?>
	<div class="row">
		<div class="medium-6 large-12 columns">
			<div class="page-header">
				<h2>Update Appointment</h2>
            </div>
            <h3><?php echo $error;?></h3>
           <?php if (isset($_SESSION["appt"]))displayForm($appt); ?>
		</div>
	</div>
	<?php include("includes/mm_footer.inc.php");?>
	<script src="assets/js/vendor/jquery.js"></script>
	 <script src="assets/js/vendor/form-validator/jquery.form-validator.min.js"></script>
	<script type="text/javascript" src="assets/js/js-validation.js"></script>
	<script src="assets/js/vendor/foundation.js"></script>
	<script>
		$(document).foundation();
	</script>
	<script src="assets/js/locationInput.js"></script>
	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyApgsOVdVnT6BvjyR_baJ4-70YRn6YrERU&libraries=places&callback=initAutocomplete"
        async defer></script>

</body>
</html>