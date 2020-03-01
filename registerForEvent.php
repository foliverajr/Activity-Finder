<?php
	include('configServ.php');
	session_start();
	if (isset($_SESSION['username'])) {
		$username = $_SESSION['username'];
		$user_check_query = "SELECT user_id FROM users WHERE username='$username' LIMIT 1";
		$result = mysqli_query($db, $user_check_query);
		$userInfo = mysqli_fetch_assoc($result);
		$userid = $userInfo['user_id'];
	}
	
	else if (isset($_SESSION['login_user'])){
		$username = $_SESSION['login_user'];
		$user_check_query = "SELECT user_id FROM users WHERE username='$username' LIMIT 1";
		$result = mysqli_query($db, $user_check_query);
		$userInfo = mysqli_fetch_assoc($result);
		$userid = $userInfo['user_id'];
	}
	else {
		$userid = 0;
	}
		
	if (isset($_POST['eventid'])) {
		$eventid = (int)$_POST['eventid'];
		$register_query = "INSERT INTO event_enrollment (user_id, event_id) VALUES ('$userid', '$eventid')";
		if (!mysqli_query($db,$register_query))
		{
			echo("Error description: " . mysqli_error($db));
		}
		else {
			echo "You have now been registered for this event.";
		}
	}

?>