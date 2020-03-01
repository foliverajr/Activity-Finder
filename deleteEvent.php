<?php
	include('configServ.php');
	include('getUserFromSession.php');
	
	if (isset($_POST['eventid'])) {
		$eventid = (int)$_POST['eventid'];
		$delete_str = "DELETE FROM markers WHERE id = $eventid";
		if (!mysqli_query($db,$delete_str))
		{
			echo("Error description: " . mysqli_error($db));
		}
		else {
			echo "This event has now been deleted.";
		}
	}
?>