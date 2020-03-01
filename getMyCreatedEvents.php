<?php
	include('configServ.php');
	include('getUserFromSession.php');
	$getUsrEvents_str = "SELECT * FROM markers WHERE creator_id = '$userid'";
	$getUsrEvents_query = mysqli_query($db, $getUsrEvents_str);
	$rowCount = mysqli_num_rows($getUsrEvents_query);
	
	echo "<div id='createdEventsTitle' class='overall-container'>
			<div style='margin: 10px; text-align: center;' class='header-container'>
			 <label style='font-size: 28px; color: #783ac2;'><b>My Created Events</b></label>
			</div>";
			
	while ($results = mysqli_fetch_array($getUsrEvents_query)) {
		echo "<p style='color: white; background-color: #612e9e; border:3px; padding: 0.6em; border-radius: 10px; font-family: sans-serif;'><b>" . $results['name'] . "</b><br />
					" . $results['address'] . "<br /><b> Description: </b>" . $results['description'] . "<br /><b>
					Date: </b>" . $results['date'] . "<br /><b> Start Time: </b>" . $results['start_time'] . "<br />
					<b> End Time: </b>" . $results['end_time'] . "<br /><b> Tags: </b>" . $results['tags'] . "<br />
					<button class='deleteBtn' style='float: center; width: 12%; font-size: 1vw;' id='delete" . $results['id'] . "'>Delete</button>
					<button class='viewAttendeesBtn' style='white-space:nowrap; float: center; width: 22%; font-size: 1vw;'
					id='view" . $results['id'] . "'>View Attendees</button></p>";
		}
		
		if($rowCount == 0) {
			echo "<p style='font-family: sans-serif; font-size: 20px;'>You have not created any events.</p>";
		}
?>

<script>
    $(document).ready(function(){
	$('.deleteBtn').click( function() {
		var fullBtnId = this.id;
		var eventid = fullBtnId.split("delete");
		eventid = eventid[1];
		$.ajax({
			type: 'POST',
			url: 'deleteEvent.php',
			data: {
				eventid: eventid
			},
			success: function(data) {
				alert(data);
				initMap();
			}
		});
		return false;
	});
	
	$('.viewAttendeesBtn').click( function() {
		var fullBtnId = this.id;
		var eventid = fullBtnId.split("view");
		eventid = eventid[1];
		$.ajax({
			type: 'POST',
			url: 'viewAttendees.php',
			data: {
				eventid: eventid
			},
			success: function(data) {
				$("#AttendeesList").html(data);
				openNav("Attendees");
			}
		});
		return false;
	});});
</script>