<?php
include_once("sql/user_queries.php");
session_start();
$error="";
if (isset($_SESSION["user_id"])) {
	$id=$_SESSION["user_id"];
}
else
header("Location: login.php");
if (isset($_GET["mode"])) {
	if (isset($_POST["input"])) {
		$error = updateInfo($id,$_POST["input"],$_GET["mode"]);
	}
}
if(isset($_POST["delete"])){
	deleteUser($_SESSION["user_id"]);
	session_destroy();
	header("Location: login.php");
}
?>

	<!DOCTYPE html>
	<html class="no-js" lang="en">
	<head>
		<meta charset="utf-8"/>
		<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
		<title>Music Mentors</title>
		<link rel="stylesheet" href="assets/css/foundation.min.css">
		<link rel="stylesheet" href="assets/css/userprofile.css">
		<link rel="stylesheet" href="assets/js/vendor/form-validator/theme-default.min.css">
	</head>
	<body>

		<?php include("includes/mm_header.inc.php");?>

		<br>
		<div class="row columns">
			<nav aria-label="You are here:" role="navigation">
				<ul class="breadcrumbs">
					<li><a href="index.php">Home</a></li>
					<li>
						<a href="userPage.php?user=<?php echo $_SESSION['username'];?>"><?php if (isset($_SESSION["username"])) echo $_SESSION["username"]; ?></a>
					</li>
					<li>
						<span class="show-for-sr">Current: </span>Edit Account
					</li>
				</ul>
			</nav>
		</div>
		<div class="column row">
			<h3>Edit Info</h3>
			<hr>
			<h4 style="color: #FF0000"><?php echo $error;?></h4>
			<ul class="tabs" data-tabs id="example-tabs">
				<li class="tabs-title is-active"><a href="#panel1" aria-selected="true">Account Information</a></li>

				<li class="tabs-title"><a href="#panel2">Profile Information</a></li>
				<li class="tabs-title"><a href="#panel3">Advanced</a></li>

			</ul>
			<div class="tabs-content" data-tabs-content="example-tabs">
				<div class="tabs-panel is-active" id="panel1">
					<ul class="accordion" data-accordion data-allow-all-closed="true">
						<li class="accordion-item" data-accordion-item>
							<a href="#" class="accordion-title">Username</a>
							<div class="accordion-content" data-tab-content>
								<form class="changeInfo" action="<?php echo 'edit-info.php?mode=username'; ?>" method="POST">
									<label>New Username
										<input type="text" class="form-control" name="input" pattern="^[a-zA-Z0-9_-]{6,18}$" data-validation-help="Username must be between 6 and 18, and no special characters" data-validation-error-msg="Username must be between 6 and 18, and no special characters">
									</label>
									<button type="submit" class="success button">Change</button>
								</form>
							</div>
						</li>
						<li class="accordion-item" data-accordion-item>
							<a href="#" class="accordion-title">Password</a>
							<div class="accordion-content" data-tab-content>
								<form class="changeInfo" action="<?php echo 'edit-info.php?mode=password'; ?>" method="POST">
									<label>New Password
										<input type="password" class="form-control" name="password" data-validation="length" data-validation-length="min8">
									</label>
									<label>Confirm Password
										<input type="password" class="form-control" name="input" data-validation="confirmation" data-validation-confirm="password" data-validation-error-msg="Password does not match original entry">
									</label>
									<button type="submit" class="success button">Change</button>
								</form>
							</div>
						</li>
						<li class="accordion-item" data-accordion-item>
							<a href="#" class="accordion-title">Email</a>
							<div class="accordion-content" data-tab-content>
								<form class="changeInfo" action="<?php echo 'edit-info.php?mode=email'; ?>" method="POST">
									<label>New Email
										<input type="email" class="form-control" name="email" data-validation="email" data-validation-help="Email must be of the form: email@domain.com">
									</label>
									<label>Confirm Email
										<input type="email" class="form-control" name="input" data-validation="confirmation" data-validation-confirm="email" data-validation-error-msg="Email entries do not match">
										<button type="submit" class="success button">Change</button>
									</form>
								</div>
							</li>
						</ul>

					</div>
					<div class="tabs-panel" id="panel2">
						<ul class="accordion" data-accordion data-allow-all-closed="true">
							<li class="accordion-item" data-accordion-item>
								<a href="#" class="accordion-title">Full Name</a>
								<div class="accordion-content" data-tab-content>
									<form action="POST">
										<label>New Username
											<input type="text" placeholder="">
										</label>
										<button type="submit" class="success button">Change</button>
									</form>
								</div>
							</li>
							<li class="accordion-item" data-accordion-item>
								<a href="#" class="accordion-title">About Me</a>
								<div class="accordion-content" data-tab-content>
									<form action="POST">
										<label>New Username
											<input type="text" placeholder="">
										</label>
										<button type="submit" class="success button">Change</button>
									</form>
								</div>
							</li>
							<li class="accordion-item" data-accordion-item>
								<a href="#" class="accordion-title">Address</a>
								<div class="accordion-content" data-tab-content>
									<form action="POST">
										<label>New Username
											<input type="text" placeholder="">
										</label>
										<button type="submit" class="success button">Change</button>
									</form>
								</div>
							</li>
							<li class="accordion-item" data-accordion-item>
								<a href="#" class="accordion-title">Contact</a>
								<div class="accordion-content" data-tab-content>
									<form action="POST">
										<label>New Username
											<input type="text" placeholder="">
										</label>
										<button type="submit" class="success button">Change</button>
									</form>
								</div>
							</li>
						</ul>
					</div>
					<div class="tabs-panel" id="panel3">
						<ul class="accordion" data-accordion data-allow-all-closed="true">
							<li class="accordion-item" data-accordion-item>
								<a href="#" class="accordion-title">Delete Account</a>
								<div class="accordion-content" data-tab-content>
									<div class="changeInfo">
										<label><strong>This Cannot be Undone!</strong>
											<!-- <input type="text" class="form-control" name="input" pattern="^[a-zA-Z0-9_-]{6,18}$" data-validation-help="Username must be between 6 and 18, and no special characters" data-validation-error-msg="Username must be between 6 and 18, and no special characters"> -->
										</label>
										<br>
										<button data-open="deleteAccount" class="alert button">Delete</button>
									</div>
								</div>
							</li>
							</ul>
					</div>
				</div>
			</div>
			<div class="reveal" id="deleteAccount" data-reveal>
			  <h1>Are You Sure?</h1>
			  <p class="lead">If you delete your account all of your information will be removed from our systems, and cannot be retrieved. Is this okay?</p>
				<div class="row">
					<form action="edit-info.php" method="POST">
						<button class="alert button" aria-label="Confirm Delete" name="delete">Confirm Delete</button>
					</form>
					<button class="button" data-close aria-label="Cancel Delete" type="button">Cancel</button>
				</div>
			  <button class="close-button" data-close aria-label="Close modal" type="button">
			    <span aria-hidden="true">&times;</span>
			  </button>
			</div>
			<?php include("includes/mm_footer.inc.php");?>
			<script src="assets/js/vendor/jquery.js"></script>
			<script src="assets/js/vendor/form-validator/jquery.form-validator.min.js"></script>
			<script type="text/javascript" src="assets/js/js-validation2.js"></script>
			<script src="assets/js/vendor/foundation.js"></script>
			<script>
				$(document).foundation();
			</script>
		</body>
	</html>
