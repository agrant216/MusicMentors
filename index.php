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
	else
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
	<link rel="stylesheet" href="assets/css/foundation.min.css">
	<link rel="stylesheet" href="assets/css/userprofile.css">
</head>
<body>
	<?php include("includes/mm_header.inc.php");?>
	<div class="row">
		<div class="medium-6 large-12 columns">
			<div class="page-header">
               <h2>Welcome to Music Mentors</h2>
            </div>
            	<?php
					if (isset($_SESSION["username"]))
						echo '<h1>Hello, '.$_SESSION["username"].'</h1>';
					else
						echo '<h1>Hello, please <a href="login.php">log in</a> or <a href="register.php">register a new account!</a></h1>';
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
	<?php include("includes/mm_footer.inc.php");?>
	<script src="assets/js/vendor/jquery.js"></script>
	<script src="assets/js/vendor/foundation.js"></script>
	<script>
		$(document).foundation();
	</script>
</body>
</html>
