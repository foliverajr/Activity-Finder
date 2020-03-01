<?php
	include('configServ.php');
	include('getUserFromSession.php');
	echo "<div id='AttendeesTitle' class='overall-container'>
			<div style='margin: 10px; text-align: center;' class='header-container'>
			 <label style='font-size: 28px; color: #783ac2;'><b>Registered Attendees</b></label>
			</div>";
			
	if (isset($_POST['eventid'])) {
		$eventid = (int)$_POST['eventid'];
		$attendees_str = "SELECT username, contact_name, profile_location FROM users WHERE user_id IN 
			(SELECT user_id FROM event_enrollment WHERE event_id = $eventid)";
		$attendees_query = mysqli_query($db, $attendees_str);
		$numAttendees = 0;
		$test = 'myProfile';
		if(!mysqli_num_rows($attendees_query)) {
			echo "<p style='font-family: sans-serif; font-size: 20px;'>No users have registered for this event yet.</p>";
		}
		else {
		while ($results = mysqli_fetch_array($attendees_query)) {
			echo "<li onclick='openNav($test);' style='text-align: center; font-family: 
			sans-serif; font-size: 26px;'>" . $results['username'] . "</li>";
			++$numAttendees;
		}
		
		echo "<p style='font-family: sans-serif; font-size: 20px;'>Number of registered users: $numAttendees</p>";
		}
	}
?>