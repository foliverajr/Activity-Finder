<?php
	include('configServ.php');
	
	if(empty($_POST['searchTerm'])) {
		echo "<p style='font-family: sans-serif; font-size: 20px;'>Please enter a search term.</p>";
	}
	
	else {
	$searchTerm = mysqli_real_escape_string($db,$_POST['searchTerm']);
	
	$search_query_str = "SELECT * FROM markers WHERE name LIKE '%".$searchTerm."%' OR address LIKE '%".$searchTerm."%' 
		OR date LIKE '%".$searchTerm."%' OR start_time LIKE '%".$searchTerm."%' OR end_time LIKE '%".$searchTerm."%' 
		OR description LIKE '%".$searchTerm."%' OR tags LIKE '%".$searchTerm."%'";
		
	$search_query = mysqli_query($db, $search_query_str);
	$rowCount = mysqli_num_rows($search_query);
		
		while ($results = mysqli_fetch_array($search_query)) {
			echo "<p style='color: white; background-color: #612e9e; padding: 0.6em; border-radius: 10px; font-family: sans-serif;'><b>" . $results['name'] . "</b><br />
					" . $results['address'] . "<br /><b> Description: </b>" . $results['description'] . "<br /><b>
					Date: </b>" . $results['date'] . "<br /><b> Start Time: </b>" . $results['start_time'] . "<br />
					<b> End Time: </b>" . $results['end_time'] . "<br /><b> Tags: </b>" . $results['tags'] . "<br />
					<button type='button' class='button' name='regEventBtn' id=". $results['id'] . " 
					style='float: center; width: 12%; font-size: 1vw;'>Register</button>";
		}
		
		if($rowCount == 0) {
			echo "<p style='font-family: sans-serif; font-size: 20px;'> No events matching search terms found. </p>";
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
			url: 'registerForEvent.php',
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