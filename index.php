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
	<!-- Custom styles for this template -->
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
	    </li>
	</div>
      
	<div id="main" class="row">
		<div class="medium-12 large-7 columns" id="users">
		<h3>User Directory</h3>
		<hr>
			<table>
            	<?php
					$users = getUserNames();
					foreach ($users as $key => $value) {
						echo '<tr><td><a href="userPage.php?user='.$value["username"].'">'.$value["username"].'</a></td></tr>';
					}
				?>

			</table>
		</div>
		<div class="medium-12 large-5 columns">
			<h3>Upcoming Lessons</h3>
			<hr>
			<div class="row">
			<?php $appts = getAppointments($_SESSION["username"],1); //echo print_r($appts);?>
			  <div id="events" class="small-9 columns small-centered">
			  <?php foreach ($appts as $key => $value){ $mentor = getUsername($value->getMentorID()); $date=$value->getDate();
			  	echo '
			    <article class="event">

			        <div class="event-date">
			          <p class="event-month">'.substr($date,5,2).'</p>
			          <p class="event-day">'.substr($date,8,2).'</p>
			        </div>

			        <div class="event-desc">
			          <h4 class="event-desc-header">'.$value->getInstrument().' Lesson with '.$mentor.'</h4>
			          <p class="event-desc-detail"><span class="event-desc-time">'.$value->getStartTime().' - '.$value->getEndTime().'</span></p>
			          <p class="event-desc-detail">'.$value->getLocation().'</p>
			        </div>

			      </article>

			      <hr>
					';}?>
				  </div>
				</div>
      
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
