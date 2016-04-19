<div class="top-bar">
	<div class="row">
		<div class="top-bar-left">
			<ul class="dropdown menu" data-dropdown-menu>
				<li class="menu-text">Music Mentors</li>
				<li class="has-submenu">
					<a href="#">Profile</a>
					<ul class="submenu menu vertical" data-submenu>
						<li><a href=<?php if (isset($_SESSION["username"])) echo '"userPage.php?user='.$_SESSION["username"].'"'; else echo '"login.php"'; ?>" >View My Profile</a></li>
						<li><a href="userPage-edit.php">Edit My Profile</a></li>
						<li><a href="edit-info.php">Edit My Account Settings</a></li>
					</ul>
				</li>
				<li class="has-submenu">
					<a href="#">Appointments</a>
					<ul class="submenu menu verticual" data-submenu>
						<li><a href="appointments.php">View My Appointments</a></li>
						<?php if(isset($_SESSION["user_type"]) && $_SESSION["user_type"] == 1) echo '<li><a href="addAppointment.php">Add Appointment</a></li>';?>
					</ul>
				</li>
				<li> <a href="search.php">Mentor Search</a> </li>
			</ul>
		</div>
		<div class="top-bar-right">
			<ul class="menu">
				<?php
					if (isset($_SESSION["username"]))
					{
						echo '<li>Welcome, '.$_SESSION["username"].'&nbsp;</li>';
						echo '<li><a href="logout.php" class="button">Log Out</a></li>';
					}
					else
					{
						echo '<li>You are not logged in!&nbsp;</li>';
						echo '<li><a href="login.php" class="button">Login/Register</a></li>';
					}
				?>
			</ul>
		</div>
	</div>
</div>