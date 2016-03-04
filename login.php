<?php
	require_once("user_queries.php");

	if (isset($_POST["username"]) && isset($_POST["password"]))
	{
		if (attemptLogin($_POST["username"], $_POST["password"]))
		{
			session_start();
			$_SESSION["username"] = $_POST["username"];
			header("Location:	index.php");
			exit();
		}
	}
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Music Mentors</title>

	<!-- Bootstrap core CSS  -->
	<link href="bootstrap3_defaultTheme/dist/css/bootstrap.css" rel="stylesheet">
</head>
<body>
	<div class="container">
		<div class="row">
			<div class="col-md-3"> <!-- LEFT SIDE -->

			</div>
			<div class="col-md-6">
		 		<div id="login">
		 			<div class="page-header">
						<h2>Login</h2>
		    		</div>
					<?php
						echo '<form role="form" method="post">';
						if (!empty($_POST) && !isset($_POST['username']))
						{
							echo '<div class="form-group has-error">';
							echo '<label for="username">Username</label>';
							echo '<input type="text" class="form-control" name="username">';
							echo '<p class="help-block">Enter a username</p>';
							echo '</div>';
						}
						else
						{
							echo '<div class="form-group">';
							echo '<label for="username">Username</label>';
							if (isset($_POST['username']))
								echo '<input type="text" class="form-control" name="username" value="'.$_POST['username'].'">';
							else
								echo '<input type="text" class="form-control" name="username">';
							echo '</div>';
						}
						if (!empty($_POST) && !isset($_POST["password"]))
						{
							echo '<div class="form-group has-error">';
							echo '<label for="password">Password</label>';
							echo '<input type="password" class="form-control" name="password">';
							echo '<p class="help-block">Enter a password</p>';
							echo '</div>';
						}
						else
						{
							echo '<div class="form-group">';
							echo '<label for="password">Password</label>';
							echo '<input type="password" class="form-control" name="password">';
							echo '</div>';
						}
						echo '<button type="submit" class="btn btn-primary">Login</button>';
						echo '<a href="register.php" class="btn btn-warning">Register</a>';
						echo '</form>';
					?>
				</div>
	  		</div>
	  		<div class="col-md-3"> <!--RIGHT SIDE-->
	  		</div>
       	</div>
    </div>  <!-- end container -->
</body>
</html>