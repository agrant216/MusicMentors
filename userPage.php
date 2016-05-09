<?php
	require_once("sql/queries.php");
	require_once("includes/profile_functions.php");
	session_start();

	if(isset($_GET["user"])){
		$username=$_GET["user"];
		$user = getAllInfo($username);
	}

	if ($_SERVER["REQUEST_METHOD"] == "POST")
	{
		if (isset($_POST["checkAppointments"]) && !empty($_POST["checkAppointments"]))
		{
			foreach($_POST["checkAppointments"] as $a)
			{
				if (!in_array($a, $_SESSION["cart"]))
					$_SESSION["cart"][] = $a;
			}
			header("Location: cart.php");
		}

		if (isset($_POST["reviewText"]) && !empty($_POST["reviewText"]))
			addReview($user->getID(), $_SESSION["user_id"], $_POST["reviewText"], $_POST["rating"]);
		else
			echo "NO REVIEW TEXT";
	}

?>
<!doctype html>
<html class="no-js" lang="en">
<head>
	<meta charset="utf-8"/>
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	<title>Music Mentors</title>

	<link rel="stylesheet" href="assets/css/foundation.min.css">
	<link rel="stylesheet" href="assets/css/userprofile.css">
</head>
<body>
	<?php include("includes/mm_header.inc.php"); ?>

	<br>

	<div class="row columns">
		<nav aria-label="You are here:" role="navigation">
			<ul class="breadcrumbs">
				<li><a href="index.php">Home</a></li>
				<li>
					<span class="show-for-sr">Current: </span> <?php if (isset($username)) echo $username; ?>
				</li>
			</ul>
		</nav>
	</div>
		<div class="row">
		<div class="medium-6 large-4 columns">
			<h2><?php echo $username; ?></h2>
			<?php if($user->getType()==1){ echo '<span class="stars">'.getUserRating($user->getID()).'</span>';} ?>
			<?php if ($user->getImageFileName()!== null) echo '<img class="thumbnail" id="uPicture" alt="profile image" src="profile_images/'.$user->getImageFileName().'">';
			else echo '<img class="thumbnail" id="uPicture" alt="profile image" src="assets/images/default.png">'; ?>
			<div>
				<h5><em><u>Instruments</u></em>:</h5><?php foreach ($user->getInstruments() as $i) echo $i.'<br/>'; ?>
			</div>
			<div>
				<h5><em><u>Genres</u></em>:</h5><?php foreach ($user->getGenres() as $g) echo $g.'<br/>'; ?>
			</div>
		</div>
		<div class="medium-6 large-8 columns">
			<h3>About Me</h3>
			<?php
				echo '<p>'.$user->getBiography().'</p>';
				echo '<h5 class="bg-primary">Email: '.$user->getEmail().'</h5>';
				if (!isset($_SESSION["user_id"]) || $user->getID() != $_SESSION["user_id"])
					displayAppointments($user, 1); //Display only open appointments
			?>
		</div>
	</div>
	<div class="column row">
				<?php
					displayReviews($user);
					myReview($user);
				?>

			</div>
		</div>
	</div>
<?php include("includes/mm_footer.inc.php"); ?>
	<script src="assets/js/vendor/jquery.js"></script>
	<script src="assets/js/vendor/foundation.js"></script>
	<script src="assets/js/userpage.js"></script>
	<script>
		$(document).foundation();
	</script>
</body>
</html>
