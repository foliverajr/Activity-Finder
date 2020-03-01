<?php
	include('configServ.php');
	include('getUserFromSession.php');
	echo "<div id='regEventsTitle' class='overall-container'>
			<div style='margin: 10px; text-align: center;' class='header-container'>
			 <label style='font-size: 28px; color: #612e9e;'><b>Events I'm Attending</b></label>
			</div>";

	$getUsrEvents_str = "SELECT id, name, address, description, date, start_time, end_time, tags FROM markers 
						WHERE id IN (SELECT event_id FROM event_enrollment WHERE user_id = $userid)";
	$getUsrEvents_query = mysqli_query($db, $getUsrEvents_str);
	$rowCount = mysqli_num_rows($getUsrEvents_query);

	while ($results = mysqli_fetch_array($getUsrEvents_query)) {
		echo "<p style='color: white; background-color: #612e9e; padding: 0.6em; border-radius: 10px; font-family: sans-serif;'><b>" . $results['name'] . "</b><br />
					" . $results['address'] . "<br /><b> Description: </b>" . $results['description'] . "<br /><b>
					Date: </b>" . $results['date'] . "<br /><b> Start Time: </b>" . $results['start_time'] . "<br />
					<b> End Time: </b>" . $results['end_time'] . "<br /><b> Tags: </b>" . $results['tags'] . "<br />
					<button class='unRegBtn' style='float: center; width: 16%; font-size: 1vw;' id='" . $results['id'] . "'>Unregister</button>
					<button class='viewCreatorBtn' style='white-space:nowrap; float: center; width: 28%; font-size: 1vw;' id='view" . $results['id'] . "'>View Creator's Profile</button>";
	}
		
		if($rowCount == 0) {
			echo "<p style='font-family: sans-serif; font-size: 20px;'>You are not registered for any events.</p>";
		}
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script>
    $(document).ready(function(){
	$('.unRegBtn').click( function() {
		var eventid = this.id;
		$.ajax({
			type: 'POST',
			url: 'unregister.php',
			data: {
				eventid: eventid
			},
			success: function(data) {
				alert(data);
				$('#'+eventid).attr('disabled','disabled')
			}
		});
		return false;
	});
	$('.viewCreatorBtn').click( function() {
		var fullBtnId = this.id;
		var eventid = fullBtnId.split("view");
		eventid = eventid[1];
		$.ajax({
			type: 'POST',
			url: 'getProfile.php',
			data: {
				eventid: eventid
			},
			success: function(data) {
				$("#userProfile").html(data);
				openNav("otherUserProfile");
			}
		});
		return false;
	});});
</script>