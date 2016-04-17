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
		if (isset($_POST["reviewText"]))
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
	<!-- Bootstrap core CSS  -->
	<link href="bootstrap3_defaultTheme/dist/css/bootstrap.css" rel="stylesheet">
	<!-- Custom styles for this template -->
    <link href="bootstrap3_defaultTheme/theme.css" rel="stylesheet">
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
					<span class="show-for-sr">Current: </span> <?php if (isset($_SESSION["username"])) echo $_SESSION["username"]; ?>
				</li>
			</ul>
		</nav>
	</div>
		<div class="row">
		<div class="medium-6 large-4 columns">
			<h2><?php echo $username; ?></h2>

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
				displayAppointments($user, 1); //Display only open appointments
			?>
			<div class="small secondary expanded button-group">
				<a class="button">Facebook</a>
				<a class="button">Twitter</a>
				<a class="button">LinkedIn</a>
			</div>
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
	<div class="row column">
		<hr>
		<ul class="menu">
			<li>Music Mentors</li>
			<li><a href="#">Home</a></li>
			<li><a href="#">[#]</a></li>
			<li><a href="#">[#]</a></li>
			<li class="float-right">Copyright 2016</li>
		</ul>
	</div>
	<script src="assets/js/vendor/jquery.js"></script>
	<script src="assets/js/vendor/foundation.js"></script>
	<script>
		$(document).foundation();
	</script>
</body>
</html>
