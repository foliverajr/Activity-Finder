<?php
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
?>