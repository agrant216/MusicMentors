<?php
	require_once("sql/queries.php");
	session_start();

	if ($_SESSION["user_type"] == 0)
		header("Location: index.php");

	$error = "";
	if (isset($_POST) && !empty($_POST))
	{
		if (checkAppointmentValues($_POST))
			addAppointment($_POST, $_SESSION["user_id"]);
		else
			$error = "Please check input values";
	}

	function displaySearchOptions($option)
		{
			foreach (getAllOptions($option) as $g)
			{
				if (isset($_POST["option_".$option]) && $_POST["option_".$option] == $g["id"])
					echo '<option value="'.$g["id"].'" selected>'.$g["name"].'</option>';
				else
					echo '<option value="'.$g["id"].'">'.$g["name"].'</option>';
			}
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
               <h2>Add Appointment</h2>
            </div>
            <h3><?php echo $error;?></h3>
		<form role="form" method="post">
			Date: <input type="date" name="date" min="<?php echo date('Y-m-d');?>" required>
			Start Time: <input type="time" name="startTime" required>
			End Time: <input type="time" name="endTime" required>
			Time Zone:  <?php include("includes/timezone.php");?>
			Price: <input type="number" name="price" min="1" step=".01" pattern="^-?\d+(\.\d{2})?$" required> USD
			Instrument: <select class="form-control" name="option_instrument">
				<?php displaySearchOptions("instrument"); ?>
			</select>
			Genre: <select class="form-control" name="option_genre">
				<?php displaySearchOptions("genre"); ?>
			</select>
			Location: <input type="text" name="location" placeholder="Enter Online for online lesson" required>
			<button class="button success large expanded" type="submit">Make Appointment</button>
		</form>

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