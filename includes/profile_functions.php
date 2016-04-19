<?php
	function displayReviews($user)
	{
		if ($user->getType() == 1)
		{
			echo '<hr>
			<ul class="tabs" data-tabs id="example-tabs">
				<li class="tabs-title is-active"><a href="#panel1" aria-selected="true">Reviews</a></li>
				<li class="tabs-title"><a href="#panel2">Other Instructors</a></li>
			</ul>
			<div class="tabs-content" data-tabs-content="example-tabs">
						<div class="tabs-panel is-active" id="panel1">
				<h4>Reviews</h4>';
			foreach (getReviews($user->getUsername()) as $r)
			{
				echo '<div class="media-object stack-for-small">
						<div class="media-object-section">
							<h5>Reviewer: '.$r->getStudentUsername().'</h5>
							<p>Date: '.$r->getReviewDate().'<p>
							<p>Rating: '.$r->getRating().'</p>
							<p>'.$r->getReviewText().'</p>
						</div>
					</div>';
			}
			echo '</div>';
		}
	}

	function myReview($user)
	{
		if ($user->getType() != 1 || (isset($_SESSION["user_id"]) && $user->getID() == $_SESSION["user_id"]))
			return;
		//if ($user->getType() == 1 && $user->getID() != $_SESSION["user_id"])
		//{
			if (isset($_SESSION["username"]))
			{
				echo '<form class="form-inline" role="form" method="post">
						<label>
							<h3>My Review</h3>
							Rating:
							<select name="rating">
								<option value="1">1 (Lowest)</option>
								<option value="2">2</option>
								<option value="3">3</option>
								<option value="4">4</option>
								<option value="5">5 (Highest)</option>
							</select>
							Review:
							<textarea name="reviewText" placeholder="None"></textarea>
						</label>
						<button class="button" type="submit">Submit Review</button>
					</form>';
			}
		//}
	}

	function displayAppointments($user, $open)
	{
		if ($user->getType() == 1)
		{
			$openAppointments = getAppointments($user->getUsername(), $open);
			echo '<form role="form" method="post">
			<table class="table table-hover">
			<caption>OPEN APPOINTMENTS</caption>
				<thead>
				<tr>
					<th>Date</th>
					<th>Start Time</th>
					<th>End Time</th>
					<th>Instrument</th>
					<th>Price</th>
					<th>Location</th>
					<th>Book it!</th>
				</tr>
				</thead>
				<tbody>';
			if (!empty($openAppointments))
			{
				foreach ($openAppointments as $a)
				{
					echo '<tr>
							<td>'.$a->getDate().'</td>
							<td>'.$a->getStartTime().'</td>
							<td>'.$a->getEndTime().'</td>
							<td>'.$a->getInstrument().'</td>
							<td>$'.number_format($a->getPrice(), 2, '.', ',').' USD</td>
							<td>'.$a->getLocation().'</td>
							<td><input type="checkbox" name="checkAppointments[]" value="'.$a->getAppointmentID().'"></td>
						</tr>';
				}
				echo '</tbody>
					</table>';
				echo '<button class="button success large expanded" type="submit">Book Appointment</button>';
			}
			else
			{
				echo '<tr><td colspan="6">No results to display</td></tr></tbody></table>';
			}
			echo '</form>';
		}

	}

	function displayOptions($option, $currentItem)
	{
		foreach (getAllOptions($option) as $g)
		{
			if ($currentItem == $g["name"])
				echo '<option value="'.$g["id"].'" selected>'.$g["name"].'</option>';
			else
				echo '<option value="'.$g["id"].'">'.$g["name"].'</option>';
		}
	}
	function displayFormInstrument()
	{
		global $user;
		echo '<div id="instrumentDiv">';
		if ($user->getInstruments() != null)
		{
			foreach ($user->getInstruments() as $i)
			{
				echo '<p class="formItem"><select name="instrument[]">';
				displayOptions("instrument", $i);
				echo '</select> <a class="removeItem">Remove</a></p>';
			}
		}
		else
		{
			echo '<select name="instrument[]">';
			displayOptions("instrument", null);
			echo '</select>';
		}
		echo '<a id="addInstrument">Add Another Instrument</a>';
		echo '</div>';
	}

	function displayFormGenre()
	{
		global $user;
		echo '<div id="genreDiv">';
		if ($user->getGenres() != null)
		{
			foreach ($user->getGenres() as $i)
			{
				echo '<p clas="formItem"><select name="genre[]">';
				displayOptions("genre", $i);
				echo '</select> <a class="removeItem">Remove</a></p>';
			}
		}
		else
		{
			echo '<select name="genre[]">';
			displayOptions("genre", null);
			echo '</select>';
		}
		echo '<a id="addGenre">Add Another Genre</a>';
		echo '</div>';
	}

?>