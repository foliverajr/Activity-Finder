<?php
	include('configServ.php');
	include('getUserFromSession.php');
	
	if (isset($_POST['eventid'])) {
		$eventid = (int)$_POST['eventid'];
		$creatorId_str = "SELECT creator_id FROM markers where id = $eventid";
		$creatorId_query = mysqli_query($db, $creatorId_str);
		$creatorId = mysqli_fetch_array($creatorId_query);
		$getUserInfo_str = "SELECT username, profile_name, profile_location, profile_contact_info, description
				FROM users WHERE user_id = " . $creatorId['creator_id'] . "";
		$getUserInfo_query = mysqli_query($db, $getUserInfo_str);
		$results = mysqli_fetch_array($getUserInfo_query);
	
	echo "<div id='profileTitle' class='overall-container'>
			<div style='margin: 10px; text-align: center;' class='header-container'>
			 <label style='font-size: 28px; color: #783ac2;'><b>" . $results['username'] . "'s Profile</b></label>
			</div>";
			
	$getUserInterests_str = "SELECT interest FROM user_interests WHERE user_id = ".$creatorId['creator_id']."";
	$getUserInterests_query = mysqli_query($db, $getUserInterests_str);
	$rowCount = mysqli_num_rows($getUserInterests_query);
	$interests = "";
	
	if($rowCount != 0) {
		while ($interestResults = mysqli_fetch_array($getUserInterests_query)) {
			$interests .= ", ".$interestResults['interest']."";
		}
		$interests = substr($interests, 1);
	}
	
	echo "<p style='font-size: 16px; color: white; text-align: left; background-color: #612e9e; padding: 0.6em; border-radius: 10px; font-family: sans-serif;'>
		<b><span style='text-decoration: underline;'>Name</span><br />" . $results['profile_name'] . 
		"<br /><span style='text-decoration: underline;'>Location</span><br /> " . $results['profile_location'] . "
		<br /><span style='text-decoration: underline;'>About Me</span><br />" . $results['description'] . 
		"<br /><span style='text-decoration: underline;'>My Interests / Hobbies</span><br />" . $interests . "<br />
		<span style='text-decoration: underline;'>Contact Information</span><br />" . $results['profile_contact_info'] . "<br /></b></p>";
	}
?>