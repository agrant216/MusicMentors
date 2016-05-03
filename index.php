<?php
	require_once("sql/queries.php");
	if (isset($_COOKIE["auth"]))
		{
			$sess = checkToken($_COOKIE["auth"]);
			if (isset($sess))
			{
				session_id($sess);
				session_start();
			}
			else
				header("Location: logout.php");
	}
	else{
 		session_start();
		//queryMarkers();
	}
?>

<!doctype html>
<html class="no-js" lang="en" dir="ltr">
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
	<link rel="stylesheet" href="assets/css/homeScreen.css">
</head>
<body>
	<?php include("includes/mm_header.inc.php");?>
	<div class="orbit" role="region" aria-label="Favorite Space Pictures" data-orbit>
	  <ul class="orbit-container">
	    <button class="orbit-previous"><span class="show-for-sr">Previous Slide</span>&#9664;&#xFE0E;</button>
	    <button class="orbit-next"><span class="show-for-sr">Next Slide</span>&#9654;&#xFE0E;</button>
	    <li class="is-active orbit-slide">
	      <img class="orbit-image" src="assets/images/0.jpg" alt="Welcome">
	      <div class="slide-text">
		    <h1 class="text"><?php
					if (isset($_SESSION["username"]))
						echo 'Hello, '.$_SESSION["username"];
					else
						echo 'Hello, please <a href="login.php">log in</a> or <a href="register.php">register a new account!</a>';?></h1>
		    <h3 class="text">Welcome to Music Mentors, the #1 site in music networking!</h3>
		  </div>
	      <figcaption class="orbit-caption">Welcome to Music Mentors!</figcaption>
	    </li><!-- 
	    <li class="orbit-slide">
	      <img class="orbit-image" src="http://placehold.it/1000x300/A92B48/fff" alt="Space">
	      <figcaption class="orbit-caption">Lets Rocket!</figcaption>
	    </li>
	    <li class="orbit-slide">
	      <img class="orbit-image" src="assets/img/orbit/03.jpg" alt="Space">
	      <figcaption class="orbit-caption">Encapsulating</figcaption>
	    </li>
	  </ul>
	  <nav class="orbit-bullets">
	    <button class="is-active" data-slide="0"><span class="show-for-sr">First slide details.</span><span class="show-for-sr">Current Slide</span></button>
	    <button data-slide="1"><span class="show-for-sr">Second slide details.</span></button>
	    <button data-slide="2"><span class="show-for-sr">Third slide details.</span></button>
	  </nav> -->
	</div>
      
	<div class="row">
		<div class="medium-6 large-12 columns">
            	<?php
					if (isset($_SESSION["username"]))
						echo '<h1>Hello, '.$_SESSION["username"].'</h1>';
					else
						echo '<h1>Hello, please <a href="login.php">log in</a> or <a href="register.php">register a new account!</a></h1>';
					echo "<ul>";
					$users = getUserNames();
					foreach ($users as $key => $value) {
						echo '<li><a href="userPage.php?user='.$value["username"].'">'.$value["username"].'</a></li>';
					}
				?>

			</ul>
		</div>
	</div>
	<?php include("includes/mm_footer.inc.php");?>
	<script src="assets/js/vendor/jquery.js"></script>
	<script src="assets/js/vendor/foundation.js"></script>
	<script src="assets/js/homeScreen.js"></script>
	<script>
		$(document).foundation();
	</script>
</body>
</html>
