<?php
	require_once("user_queries.php");
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Music Mentors</title>

	<!-- Bootstrap core CSS  -->
	<link href="bootstrap3_defaultTheme/dist/css/bootstrap.css" rel="stylesheet">

    <link href="//cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.2.8/theme-default.min.css"
    rel="stylesheet" type="text/css" />
	

</head>
<body>
	<div class="container">
		<div class="row">
			<div class="col-md-3"> <!--LEFT SIDE-->

			</div>
			<div class="col-md-6">
		 		<div id="login">
		 			<div class="page-header">
						<?php
							if (!isset($_GET['result']))
								echo "<h2>Register</h2>";
							else if (isset($_GET['result']) && $_GET['result'] == "success")
								echo "<h2>Success</h2>";
							else if (isset($_GET['result']) && $_GET['result'] == "failure")
								echo "<h2>Failure</h2>";
						?>
		    		</div>
					<?php
						if (!isset($_GET['result']))
						{
							if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['confirm_password']) && isset($_POST['email']))
							{
								if (!empty($_POST['username']) && !empty($_POST['password']) && !empty($_POST['confirm_password']) && !empty($_POST['email']) && $_POST['password'] == $_POST['confirm_password'] && !userExists($_POST['username']))
								{
									if (registerUser($_POST['username'], $_POST['password'], $_POST['email'], $_POST['user_type']))
										header("Location:	?result=success");
									else
										header("Location:	?result=failure");
								}
							}
							echo '<form id="registration" role="form" method="post">';
							if (!empty($_POST) && (!isset($_POST['username']) || empty($_POST['username'])))
							{
								echo '<div class="form-group has-error">';
								echo '<label for="username">Username</label>';
								echo '<input type="text" class="form-control" name="username" pattern="^[a-zA-Z0-9_-]{6,18}$" required="required" data-validation-help="Username must be between 6 and 18, and no special characters">';
								echo '<p class="help-block">Enter a username</p>';
								echo '</div>';
							}
							else if (!empty($_POST) && userExists($_POST['username']))
							{
								echo '<div class="form-group has-error">';
								echo '<label for="username">Username</label>';
								echo '<input type="text" class="form-control" name="username" value="'.$_POST['username'].'" pattern="^[a-zA-Z0-9_-]{6,18}$" required="required" data-validation-help="Username must be between 6 and 18, with no special characters">';
								echo '<p class="help-block">Username already exists</p>';
								echo '</div>';
							}

							else
							{
								echo '<div class="form-group">';
								echo '<label for="username">Username</label>';
								if (isset($_POST['username']))
									echo '<input type="text" class="form-control" name="username" value="'.$_POST['username'].'" pattern="^[a-z0-9_-]{6,18}$" required="required" data-validation-help="Username must be between 6 and 18, and no special characters">';
								else
									echo '<input type="text" class="form-control" name="username" pattern="^[a-zA-Z0-9_-]{6,18}$" required="required" data-validation-help="Username must be between 6 and 18, and no special characters">';
								echo '</div>';
							}
							if (!empty($_POST) && (!isset($_POST["password"]) || empty($_POST['password'])))
							{
								echo '<div class="form-group has-error">';
								echo '<label for="password">Password</label>';
								echo '<input type="password" class="form-control" name="password" data-validation="length" data-validation-length="min8">';
								echo '<p class="help-block">Enter a password</p>';
								echo '</div>';
							}
							else
							{
								echo '<div class="form-group">';
								echo '<label for="password">Password</label>';
								echo '<input type="password" class="form-control" name="password" data-validation="length" data-validation-length="min8">';
								echo '</div>';
							}
							if (!empty($_POST) && (!isset($_POST["confirm_password"]) || empty($_POST["confirm_password"])))
							{
								echo '<div class="form-group has-error">';
								echo '<label for="password">Confirm Password</label>';
								echo '<input type="password" class="form-control" name="confirm_password" data-validation="confirmation" data-validation-confirm="password" data-validation-error-msg="Password does not match original entry">';
								echo '<p class="help-block">Confirm your password</p>';
								echo '</div>';
							}
							else
							{
								echo '<div class="form-group">';
								echo '<label for="password">Confirm Password</label>';
								echo '<input type="password" class="form-control" name="confirm_password" data-validation="confirmation" data-validation-confirm="password" data-validation-error-msg="Password does not match original entry">';
								echo '</div>';
							}
							if (!empty($_POST) && (!isset($_POST['email']) || empty($_POST['email'])))
							{
								echo '<div class="form-group has-error">';
								echo '<label for="email">E-mail</label>';
								echo '<input type="email" class="form-control" name="email" data-validation="email">';
								echo '<p class="help-block">Enter a valid email</p>';
								echo '</div>';
							}
							else
							{
								echo '<div class="form-group">';
								echo '<label for="email">E-mail</label>';
								if (isset($_POST['email']))
								echo '<input type="text" class="form-control" name="email" value="'.$_POST['email'].'">';
								else
								echo '<input type="text" class="form-control" name="email" data-validation="email">';
								echo '</div>';
							}
							echo '<input type="radio" name="user_type" value="student" data-toggle="tooltip" title="You will sign up seeking music teachers" checked>&nbsp;Student</input> <br />';
							echo '<input type="radio" name="user_type" value="mentor" data-toggle="tooltip" title="You will sign up seeking interested students">&nbsp;Mentor</input> <br /><br />';
							echo '<button type="submit" class="btn btn-primary">Register</button>';
							echo '</form>';
						}
						else if (isset($_GET['result']) && $_GET['result']=="success")
						{
							header("refresh:5, url=index.php");
							echo "<p>Registration was a success!</p>";
							echo '<p>You will be redirected in 5 seconds or <a href="index.php">click here to go now</a>.';
						}
						else if (isset($_GET['result']) && $_GET['result']=="failure")
						{
							header("refresh:5, url=register.php");
							echo "<p>Registration failed unexpectedly</p>";
							echo '<p>You will be redirected to the registration page in 5 seconds or <a href="register.php">click here to go now</a>.';
						}

					?>
				</div>
	  		</div>
	  		<div class="col-md-3">
	  		</div>
       	</div>
    </div>  <!-- end container -->
    <!-- JavaScript  -->
	<script src="//code.jquery.com/jquery-2.2.1.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.2.8/jquery.form-validator.min.js"></script>
	<script type="text/javascript" src="assets/js/js-validation.js"></script>
</body>
</html>