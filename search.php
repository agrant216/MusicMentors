<?php
	require_once("sql/queries.php");
	session_start();

	if ($_SERVER["REQUEST_METHOD"] == "POST")
		$users = searchMentor("%".$_POST["search_option_name"]."%", $_POST["search_option_genre"], $_POST["search_option_instrument"], $_POST["sort_option"], $_POST["sort_option_2"]);
	else
		$users = searchMentor("%", "*", "*", 1, 1);

	function outputRow($name, $genre, $instrument)
	{
		echo '<tr>
				<td><a href="userPage.php?user='.$name.'">'.$name.'</a></td>
				<td>';
		foreach($genre as $g)
		{
			echo "$g<br />";
		}
		echo '</td><td>';
		foreach($instrument as $i)
		{
			echo "$i<br />";
		}
		echo '</td></tr>';
	}

	function displaySearchOptions($option)
	{
		if ($_POST["search_option_".$option] == "")
			echo '<option value="*" selected>Any '.$option.'</option>';
		else
			echo '<option value="*">Any '.$option.'</option>';
		foreach (getAllOptions($option) as $g)
		{
			if ($_POST["search_option_".$option] == $g["id"])
				echo '<option value="'.$g["id"].'" selected>'.$g["name"].'</option>';
			else
				echo '<option value="'.$g["id"].'">'.$g["name"].'</option>';
		}
	}
	function displaySortOptions()
	{
		echo 'Sort By
				<select name="sort_option">';
		if ($_POST["sort_option"] == 1)
			echo '<option value="1" selected>Username</option>';
		else
			echo '<option value="1">Username</option>';
		if ($_POST["sort_option"] == 2)
			echo '<option value="2" selected>Instrument</option>';
		else
			echo '<option value="2">Instrument</option>';
		if ($_POST["sort_option"] == 3)
			echo '<option value="3" selected>Genre</option>';
		else
			echo '<option value="3">Genre</option>';
		echo '</select>
				<select class="form-control" name="sort_option_2">';
		if ($_POST["sort_option_2"] == 1)
			echo '<option value="1" selected>Ascending</option>';
		else
			echo '<option value="1">Ascending</option>';
		if ($_POST["sort_option_2"] == 2)
			echo '<option value="2" selected>Descending</option>';
		else
			echo '<option value="2">Descending</option>';
		echo '</select>';
	}

	function sortUsers(&$users)
	{
		if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST["sort_option_2"] == 1)
		{
			switch($_POST["sort_option"])
			{
				case 1:
					uasort($users, "name_sort_asc");
					break;
				case 2:
					uasort($users, "inst_sort_asc");
					break;
				case 3:
					uasort($users, "gen_sort_asc");
					break;

			}
		}
		else if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST["sort_option_2"] == 2)
		{
			switch($_POST["sort_option"])
			{
				case 1:
					uasort($users, "name_sort_desc");
					break;
				case 2:
					uasort($users, "inst_sort_desc");
					break;
				case 3:
					uasort($users, "gen_sort_desc");
					break;

			}
		}
	}
	function name_sort_asc($a, $b) { return $a->getUsername() > $b->getUsername(); }
	function inst_sort_asc($a, $b) { return $a->getInstruments() > $b->getInstruments(); }
	function gen_sort_asc($a, $b) { return $a->getGenres() > $b->getGenres(); }
	function name_sort_desc($a, $b) { return $a->getUsername() < $b->getUsername(); }
	function inst_sort_desc($a, $b) { return $a->getInstruments() < $b->getInstruments(); }
	function gen_sort_desc($a, $b) { return $a->getGenres() < $b->getGenres(); }
?>
<!DOCTYPE html>
<html lang="en">
	<head>
    	<meta charset="utf-8">
    	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    	<title>Mentor Search</title>
    	<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    	<!--[if lt IE 9]>
    	  <script src="../../assets/js/html5shiv.js"></script>
    	  <script src="../../assets/js/respond.min.js"></script>
    	<![endif]-->
	<link rel="stylesheet" href="assets/css/foundation.min.css">
	<link rel="stylesheet" href="assets/css/userprofile.css">
    </head>

	<body>
	<?php include("includes/mm_header.inc.php"); ?>
		<div class="row">
			<div class="medium-6 large-12 columns">
				<div class="page-header">
				   <h2>Mentor Search</h2>
				</div>
				Search By
					<form role="search" method="post">
							<div class="small-6 large-6 columns">
								<select name="search_option_genre">
									<?php displaySearchOptions("genre"); ?>
								</select>
								<select name="search_option_instrument">
									<?php displaySearchOptions("instrument"); ?>
								</select>
								<input type="text" placeholder="Search username" name="search_option_name">
							</div>
							<div class="small-6 large-6 columns">
								<?php displaySortOptions(); ?>
							</div>
							<div class= "medium-12 columns">
									<button class="button primary expanded" type="submit">Search</button>
							</div>
					</form>
				<div class="small-12">
					<table class="table">
						<tr>
							<th>Username</th>
							<th>Genres</th>
							<th>Instruments</th>
						</tr>
						<?php
							sortUsers($users);
							foreach($users as $u)
							{
								outputRow($u->getUsername(), $u->getGenres(), $u->getInstruments());
							}
						?>
					</table>
				</div>
				<!--</div>-->
			</div> <!--End Columns-->
		</div> <!--End Row-->
		<?php include("includes/mm_footer.inc.php"); ?>
	<script src="assets/js/vendor/jquery.js"></script>
	<script src="assets/js/vendor/foundation.js"></script>
	<script>
			$(document).foundation();
	</script>
	</body>
</html>