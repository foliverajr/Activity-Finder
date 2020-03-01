<?php
	include('configServ.php');
	include('getUserFromSession.php');
	
	echo "<div id='RecEventsTitle' class='overall-container'>
			<div style='margin: 10px; text-align: center;' class='header-container'>
			 <label style='font-size: 28px; color: #783ac2;'><b>Recommended Events</b></label>
			</div>";
			
	$getUserInterests_str = "SELECT interest FROM user_interests WHERE user_id = $userid";
	$userInterests_query = mysqli_query($db, $getUserInterests_str);
	$rowCount = mysqli_num_rows($userInterests_query);
	
	if($rowCount == 0) {
			echo "<p style='font-family: sans-serif; font-size: 20px;'>You have not added any interests yet.</p>";
	}
	else {
	
		while ($userInterests = mysqli_fetch_array($userInterests_query)) {
			$recEvents_str = "SELECT id, name, address, description, date, start_time, end_time, tags
						FROM markers WHERE tags LIKE '%".$userInterests['interest']."%'";
			$recEvents_query = mysqli_query($db, $recEvents_str);
			$rowCount = mysqli_num_rows($recEvents_query);
		
			if ($rowCount == 0) {
			echo "<p style='font-family: sans-serif; font-size: 20px;'>No events matching ".$userInterests['interest']." exists.</p>";
			}
			else {
				while ($recEvents_results = mysqli_fetch_array($recEvents_query)) {
					echo "<p style='color: white; background-color: #612e9e; padding: 0.6em; border-radius: 10px; font-family: sans-serif;'><b>" . $recEvents_results['name'] . "</b><br />
					" . $recEvents_results['address'] . "<br /><b> Description: </b>" . $recEvents_results['description'] . "<br /><b>
					Date: </b>" . $recEvents_results['date'] . "<br /><b> Start Time: </b>" . $recEvents_results['start_time'] . "<br />
					<b> End Time: </b>" . $recEvents_results['end_time'] . "<br /><b> Tags: </b>" . $recEvents_results['tags'] . "<br />
					<button type='button' class='button' name='regEventBtn' id=". $recEvents_results['id'] . " 
					style='float: center; width: 12%; font-size: 1vw;'>Register</button>";
				}
			}
		}
	}
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script>
    $(document).ready(function(){
	$('button').click( function() {
		var eventid = this.id;
		$.ajax({
			type: 'POST',
			url: 'regEvent.php',
			data: {
				eventid: eventid
			},
			success: function(data) {
				alert(data);
				$('#'+eventid).attr('disabled','disabled')
			}
		});
		return false;
	});});
</script>