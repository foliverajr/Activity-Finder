<?php
	include('configServ.php');
	include('getUserFromSession.php');
	
	$getUserInfo_str = "SELECT username, profile_name, profile_location, profile_contact_info, description
				FROM users WHERE user_id = $userid";
	$getUserInfo_query = mysqli_query($db, $getUserInfo_str);
	$getUserInterests_str = "SELECT interest FROM user_interests WHERE user_id = $userid";
	$getUserInterests_query = mysqli_query($db, $getUserInterests_str);
	$rowCount = mysqli_num_rows($getUserInterests_query);
	$interests = "";
	
	if($rowCount != 0) {
		$results = mysqli_fetch_array($getUserInterests_query);
		while ($results = mysqli_fetch_array($getUserInterests_query)) {
			$interests .= ", ".$results['interest']."";
		}
		$interests = substr($interests, 1);
	}
	
	echo "<div id='profileTitle' class='overall-container'>
			<div style='margin: 10px; text-align: center;' class='header-container'>
			 <label style='font-size: 28px; color: #783ac2;'><b>My Profile</b></label>
			</div>";
	while ($results = mysqli_fetch_array($getUserInfo_query)) {
		echo "<p style='font-size: 16px; color: white; text-align: left; background-color: #612e9e; padding: 0.6em; border-radius: 10px; font-family: sans-serif;'><b>
		<span style='font-size: 38px'>" . $results['username'] . "</b></span><br /><span style='font-size:20px'><b>Name</b></span><br />" . $results['profile_name'] . 
		"<br /><span style='font-size:20px'><b>Location</b></span><br /> " . $results['profile_location'] . "
		<br /><span style='font-size:20px'><b>About Me</b></span><br />" . $results['description'] . 
		"<br /><span style='font-size:22px'><b>My Interests / Hobbies</b></span><br />" . $interests . "<br />
		<span style='font-size:22px'><b>Contact Information</b></span><br />" . $results['profile_contact_info'] . "<br /></p>";
	}
	
	echo "<button type='button' id='editProfBtn' class='button' style='float: center; width: 12%; font-size: 1vw;'>Edit</button>";
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script>
    $(document).ready(function(){
	$('#editProfBtn').click( function() {
		closeNav('myProfile');
		openNav('editProfile');
	});});
</script>