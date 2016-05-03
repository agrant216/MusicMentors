<?php
	require_once("sql/queries.php");
	require_once("includes/authorize.php");

	function displayForm($error)
	{
		echo '<h3 class="text-danger">'.$error.'</h3>';
		echo '<form id="login" role="form" method="post">';
		if ($_SERVER["REQUEST_METHOD"] == "POST" && empty($_POST['username']))
		{
			echo '<div class="form-group has-error">';
			echo '<label for="username">Username</label>';
			echo '<input type="text" class="form-control" name="username" pattern="^[a-zA-Z0-9_-]{6,18}$" required="required" data-validation-help="Username must be between 6 and 18, and no special characters" data-validation-error-msg="Username must be between 6 and 18, and no special characters">';
			echo '<p class="help-block">Enter a username</p>';
			echo '</div>';
		}
		else
		{
			echo '<div class="form-group">';
			echo '<label for="username">Username</label>';
			if (isset($_POST['username']))
				echo '<input type="text" class="form-control" name="username" pattern="^[a-zA-Z0-9_-]{6,18}$" required="required" data-validation-help="Username must be between 6 and 18, and no special characters" value="'.$_POST['username'].'" data-validation-error-msg="Username must be between 6 and 18, and no special characters">';
			else
				echo '<input type="text" class="form-control" name="username" pattern="^[a-zA-Z0-9_-]{6,18}$" required="required" data-validation-help="Username must be between 6 and 18, and no special characters" data-validation-error-msg="Username must be between 6 and 18, and no special characters">';
			echo '</div>';
		}
		if ($_SERVER["REQUEST_METHOD"] == "POST" && empty($_POST["password"]))
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
		echo '<input type="checkbox" name="remember"> Keep Me Signed In (30 Days)<br>';
		echo '<button type="submit" class="button primary large">Login</button>';
		echo '<a href="register.php" class="button alert large">Register</a>';
		echo '</form>';
	}
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Music Mentors</title>

	<link rel="stylesheet" href="assets/css/foundation.min.css">
	<link rel="stylesheet" href="assets/css/userprofile.css">
	<!-- Bootstrap core CSS  -->
	<link rel="stylesheet" href="assets/js/vendor/form-validator/theme-default.min.css">
</head>
<body>
	<?php include("includes/mm_header.inc.php");?>
	<div class="row">
		<div class="medium-6 large-12 columns">
			<div class="page-header">
               <h2>Login</h2>
            </div>
			<?php displayForm($error);?>
		</div>
	</div>
	<?php include("includes/mm_footer.inc.php"); ?>

 <!-- JavaScript  -->
 	<script src="assets/js/vendor/jquery.js"></script>
	<script src="assets/js/vendor/foundation.js"></script>
 	<script src="assets/js/vendor/form-validator/jquery.form-validator.min.js"></script>
	<script type="text/javascript" src="assets/js/js-validation.js"></script>
	<script>
		$(document).foundation();
	</script>
</body>
</html>