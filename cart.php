<?php
	require_once("sql/queries.php");
	session_start();

	if (!isset($_SESSION["user_id"]))
		header("Location: index.php");
	$error = "";
	$appts = array();

	if ($_SERVER["REQUEST_METHOD"] == "POST")
	{
		$i=0;
		$total=0;
		foreach ($_SESSION["cart"] as $a)
		{
			$i++;
			$error = updateAppointmentStudent($a, $_SESSION["user_id"], $i);
			$appt = getAppointmentByID($a);
			$total+=$appt->getPrice();
		}
		addOrder($_SESSION["user_id"], $total);
		unset($_SESSION["cart"]);
	}

	function displayCart()
	{
		$total = 0;
		echo '<form role="form" method="post">
				<table class="table table-hover">
				<caption>Appointments in Cart</caption>
					<thead>
					<tr>
						<th>Mentor</th>
						<th>Date</th>
						<th>Start Time</th>
						<th>End Time</th>
						<th>Instrument</th>
						<th>Price</th>
						<th>Location</th>
					</tr>
					</thead>
			<tbody>';
		if (isset($_SESSION["cart"]) && !empty($_SESSION["cart"]))
		{
			foreach($_SESSION["cart"] as $a)
			{
				$appts[] = getAppointmentByID($a);
			}
		}
		if (!empty($appts))
		{
			foreach ($appts as $a)
			{
				$total+=$a->getPrice();
				echo '<tr>
						<td><a href="userPage.php?user='.getUsername($a->getMentorID()).'">'.getUsername($a->getMentorID()).'</td>
						<td>'.$a->getDate().'</td>
						<td>'.$a->getStartTime().'</td>
						<td>'.$a->getEndTime().'</td>
						<td>'.$a->getInstrument().'</td>
						<td>$'.number_format($a->getPrice(), 2, '.', ',').' USD</td>
						<td>'.$a->getLocation().'</td>
					</tr>
				';
			}
			echo '</tbody>
				<tfoot>
					<tr>
						<td colspan="7">Total: $'.number_format($total, 2, '.', ',').' USD</td>
					</tr>
				</tfoot>
				</table>
				<button class="button primary large expanded" type="submit">Checkout</button>';
		}
		else
			echo '<tr><td colspan="7">No results to display</td></tr></tbody></table>';
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
               <h2>Shopping Cart</h2>
            </div>
		<?php if ($_SERVER["REQUEST_METHOD"] != "POST")
			displayCart();
			else
				echo '<h3>'.$error.'</h3>'; ?>
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