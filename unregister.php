<?php
	include('configServ.php');
	include('getUserFromSession.php');
	
	if (isset($_POST['eventid'])) {
		$eventid = (int)$_POST['eventid'];
		$unregister_query = "DELETE FROM event_enrollment WHERE event_id = $eventid AND user_id = $userid";
		if (!mysqli_query($db,$unregister_query))
		{
			echo("Error description: " . mysqli_error($db));
		}
		else {
			echo "You have now been unregistered for this event.";
		}
	}
?>