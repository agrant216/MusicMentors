<?php
	require_once("sql/queries.php");
	require_once("includes/profile_functions.php");
	session_start();

	if(isset($_SESSION["username"])){
		$username=$_SESSION["username"];
		$user = getAllInfo($username);
	}
	else
		header("Location: login.php");

	if ($_SERVER["REQUEST_METHOD"] == "POST")
	{
		print_r($_POST);
		print_r($_FILES);
		if ($_FILES["imageFile"]["error"] == 0)
			submitChanges($_SESSION["user_id"], $_POST["biography"], $_POST["instrument"], $_POST["genre"], $_FILES["imageFile"]);
		else
			submitChanges($_SESSION["user_id"], $_POST["biography"], $_POST["instrument"], $_POST["genre"], null);

		header("Location: ".$_SERVER["PHP_SELF"]);
		//USER ID, BIOGRAPHY, INSTRUMENT ARRAY, GENRE ARRAY, PROFILE IMAGE FILE
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
	<link rel="stylesheet" href="http://dhbhdrzi4tiry.cloudfront.net/cdn/sites/foundation.min.css">
	<link rel="stylesheet" href="assets/css/userprofile.css">
	<script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
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
			<form id="imageUpload" name="imageUpload" enctype="multipart/form-data" method="post">
				<input id="imageFile" name="imageFile" type="file">
				<input id="max_file_size" type="hidden" name="MAX_FILE_SIZE" value="1048576">
			<div>
				<h5><em><u>Instruments</u></em>:</h5><?php displayFormInstrument();?><br/>
			</div>
			<div>
				<h5><em><u>Genres</u></em>:</h5><?php displayFormGenre(); ?><br/>
			</div>
		</div>
		<div class="medium-6 large-8 columns">
			<h3>About Me</h3>
			<?php
				echo '<textarea name="biography" form="imageUpload" rows="4">'.$user->getBiography().'</textarea>';
				echo '<h5 class="bg-primary">Email: '.$user->getEmail().'</h5>';
			?>
			<div class="small secondary expanded button-group">
				<a class="button">Facebook</a>
				<a class="button">Twitter</a>
				<a class="button">LinkedIn</a>
			</div>
		</div>
			<button class="button" type="submit">SAVE CHANGES</button>
		</form>
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
	<script src="assets/js/edit_profile.js">

	<script src="http://dhbhdrzi4tiry.cloudfront.net/cdn/sites/foundation.js"></script>
	<script>
		$(document).foundation();
	</script>
</body>
</html>
