<?php
	require_once("sql/queries.php");
	session_start();

	if (!isset($_SESSION["user_id"]))
		header("Location: index.php");
	function displayOrders($caption)
	{
		$orders = getOrdersByStudentID($_SESSION["user_id"]);
		echo '<table class="table table-hover">
		<caption>'.$caption.'</caption>
			<thead>
			<tr>';
			echo '<th>Order #</th>
				<th>Date</th>
				<th>Total</th>
			</tr>
			</thead>
			<tbody>';
		if (!empty($orders))
		{
			foreach ($orders as $a)
			{
				echo '<tr>';
				echo '<td>'.$a->getOrderID().'</td>
					<td>'.$a->getDateTime().'</td>
					<td>$'.number_format($a->getTotal(), 2, '.', ',').' USD</td>
				</tr>';
			}
		}
		else
			echo '<tr><td colspan="3">No results to display</td></tr>';
		echo '</tbody>
			</table>';
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
               <h2>Orders</h2>
            </div>
			<?php
				displayOrders("MY ORDERS");
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