<?php
	require_once("sql/queries.php");
	session_start();
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
	<link rel="stylesheet" href="http://dhbhdrzi4tiry.cloudfront.net/cdn/sites/foundation.min.css">
	<link rel="stylesheet" href="assets/css/userprofile.css">
</head>
<body>
	<?php include("includes/mm_header.inc.php"); ?>
	<div class="row">
		<div class="medium-6 large-12 columns">
			<div class="page-header">
               <h2>Welcome</h2>
            </div>
            	<?php
					if (isset($_SESSION["username"]))
						echo '<h1>Hello, '.$_SESSION["username"].'</h1>';
					else
						header("Location:	login.php");
					echo "<ul>";
					$users = getUserNames();
					//echo print_r($users);
					foreach ($users as $key => $value) {
						echo '<li><a href="userPage.php?user='.$value["username"].'">'.$value["username"].'</a></li>';
					}
				?>

			</ul>
		</div>
	</div>
	<script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
	<script src="http://dhbhdrzi4tiry.cloudfront.net/cdn/sites/foundation.js"></script>
	<script>
		$(document).foundation();
	</script>
</body>
</html>
