<?php
	include('configServ.php');
	include('geocode.php');
	include('getUserFromSession.php');
	
	if (isset($_POST['submitEvent'])) {
		$title = mysqli_real_escape_string($db, $_POST['title']);
		$desc = mysqli_real_escape_string($db, $_POST['description']);
		$address = mysqli_real_escape_string($db, $_POST['eventAddress']);
		$date = mysqli_real_escape_string($db, $_POST['date']);
		$startTime = mysqli_real_escape_string($db, $_POST['startTime']);
		$endTime = mysqli_real_escape_string($db, $_POST['endTime']);
		$tags = mysqli_real_escape_string($db, $_POST['tags']);
		
		$data_arr = geocode($address);
		if($data_arr) {
			$lat = $data_arr[0];
			$lng = $data_arr[1];
			$address = $data_arr[2];
		}
		
		$query = "INSERT INTO markers (name, address, lat, lng, description, date, start_time, end_time, tags, creator_id) 
  			VALUES('$title','$address','$lat','$lng', '$desc','$date','$startTime','$endTime','$tags','$userid')";
		mysqli_query($db, $query);
		
		header('Location: home.php'); //stop page from
		exit();						  //resubmitting form on page refresh.
	}
	
	if (isset($_POST['submitProfInfo'])) {
	if ($_POST['interests']) {
		$numFields = count($_POST['interests']);
		for ($i = 0; $i < $numFields; $i++) {
			$tempInterest = mysqli_real_escape_string($db, $_POST['interests'][$i]);
			$query = "INSERT INTO user_interests (user_id, interest) VALUES ($userid, '$tempInterest')";
			mysqli_query($db, $query);
		}
	}
		$name = mysqli_real_escape_string($db, $_POST['name']);
		$aboutMe = mysqli_real_escape_string($db, $_POST['description']);
		$location = mysqli_real_escape_string($db, $_POST['location']);
		$contactInfo = mysqli_real_escape_string($db, $_POST['contactInfo']);
		$data_arr = geocode($location);
		if($data_arr) {
			$location = $data_arr[2];
		}
		
		$query = "UPDATE users SET profile_name = '$name', profile_location = '$location', description = '$aboutMe', 
  			profile_contact_info = '$contactInfo' WHERE user_id = $userid";
		mysqli_query($db, $query);
	}
?>

<!DOCTYPE html >
  <head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
    <meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
    <title>Home - Activity Finder</title>
    <link rel="stylesheet" href="homeSS.css">
  </head>

<html>
  <body>
	<div id="floating-panel">
      <input id="address" placeholder="Enter a Location Here" type="textbox">
      <input id="submit" type="button" value="Go">
    </div>
	
    <div id="map"></div>
    <script>
        function initMap() {
        var map = new google.maps.Map(document.getElementById('map'), {
          center: new google.maps.LatLng(40.3307, -74.1210),
          zoom: 12
        });
        var infoWindow = new google.maps.InfoWindow({
          maxWidth: 280
		});

          downloadUrl('getMarkerXML.php', function(data) {
            var xml = data.responseXML;
            var markers = xml.documentElement.getElementsByTagName('marker');
            Array.prototype.forEach.call(markers, function(markerElem) {
              var id = markerElem.getAttribute('id');
              var name = markerElem.getAttribute('name');
              var address = markerElem.getAttribute('address');
			  var desc = markerElem.getAttribute('description');
			  var date = markerElem.getAttribute('date');
			  var startTime = markerElem.getAttribute('start_time');
			  var endTime = markerElem.getAttribute('end_time');
			  var tags = markerElem.getAttribute('tags');
              var type = markerElem.getAttribute('type');
              var point = new google.maps.LatLng(
                  parseFloat(markerElem.getAttribute('lat')),
                  parseFloat(markerElem.getAttribute('lng')));

              var infowincontent = document.createElement('div');
			  
              var strong = document.createElement('strong');
			  strong.setAttribute('style', 'font-weight: 500; font-size: 18px;');
              strong.textContent = name
              infowincontent.appendChild(strong);
              infowincontent.appendChild(document.createElement('br'));

              var text = document.createElement('text');
			  text.setAttribute('style', 'font-size: 16px;');
              text.textContent = address;
              infowincontent.appendChild(text);
			  infowincontent.appendChild(document.createElement('br'));
			  
			  var descTxtB = document.createElement('descTxtB');
			  descTxtB.setAttribute('style', 'font-weight: 410;');
              descTxtB.textContent = "Description: "
			  infowincontent.appendChild(descTxtB);
			  var descTxt = document.createElement('descTxt');
			  descTxt.setAttribute('style', 'font-size: 16px;');
              descTxt.textContent = desc;
              infowincontent.appendChild(descTxt);
			  infowincontent.appendChild(document.createElement('br'));
			  infowincontent.appendChild(document.createElement('br'));
			  
			  var dateTxtB = document.createElement('dateTxtB');
			  dateTxtB.setAttribute('style', 'font-weight: 410;');
              dateTxtB.textContent = "Date: "
              infowincontent.appendChild(dateTxtB);
			  var dateTxt = document.createElement('dateTxt');
              dateTxt.textContent = date;
              infowincontent.appendChild(dateTxt);
			  infowincontent.appendChild(document.createElement('br'));
			  
			  var startTimeTxtHeader = document.createElement('startTimeTxtHeader');
			  startTimeTxtHeader.setAttribute('style', 'font-weight: 410;');
              startTimeTxtHeader.textContent = "Start Time: "
              infowincontent.appendChild(startTimeTxtHeader);
			  var startTimeTxt = document.createElement('startTimeTxt');
              startTimeTxt.textContent = startTime;
              infowincontent.appendChild(startTimeTxt);
			  infowincontent.appendChild(document.createElement('br'));
			  
			  var endTimeTxtHeader = document.createElement('endTimeTxtHeader');
			  endTimeTxtHeader.setAttribute('style', 'font-weight: 410;');
              endTimeTxtHeader.textContent = "End Time: ";
              infowincontent.appendChild(endTimeTxtHeader);
			  var endTimeTxt = document.createElement('endTimeTxt');
              endTimeTxt.textContent = endTime;
              infowincontent.appendChild(endTimeTxt);
			  infowincontent.appendChild(document.createElement('br'));
			  
			  var tagsHeader = document.createElement('tagsHeader');
			  tagsHeader.setAttribute('style', 'font-weight: 410;');
              tagsHeader.textContent = "Tags: ";
              infowincontent.appendChild(tagsHeader);
			  var tagsTxt = document.createElement('tagsTxt');
              tagsTxt.textContent = tags;
              infowincontent.appendChild(tagsTxt);
			  infowincontent.appendChild(document.createElement('br'));
			  
			 var regEvButton = document.createElement("button");
			  regEvButton.id = id;
			  regEvButton.innerHTML = "Register";
			  regEvButton.setAttribute('style', 'padding: 6px 6px; width: 100%; font-size: 15px;');
			  infowincontent.appendChild(regEvButton);
			  
              var marker = new google.maps.Marker({
                map: map,
                position: point
              });
              marker.addListener('click', function() {
				$(document).ready(function(){
					$('#'+id).click( function() {
						var eventid = this.id;
						$.ajax({
							type: 'POST',
							url: 'registerForEvent.php',
							data: {
							eventid: eventid
						},
						success: function(data) {
							alert(data);
							$('#'+id).attr('disabled','disabled')
						}
						});
					return false;
				});});
                infoWindow.setContent(infowincontent);
                infoWindow.open(map, marker);
              });
            });
          });
		  
		  var geocoder = new google.maps.Geocoder();

			document.getElementById('submit').addEventListener('click', function() {
				geocodeAddress(geocoder, map);
			});
			
        }

      function downloadUrl(url, callback) {
        var request = window.ActiveXObject ?
            new ActiveXObject('Microsoft.XMLHTTP') :
            new XMLHttpRequest;

        request.onreadystatechange = function() {
          if (request.readyState == 4) {
            request.onreadystatechange = doNothing;
            callback(request, request.status);
          }
        };

        request.open('GET', url, true);
        request.send(null);
      }

      function doNothing() {}
	  
	  function geocodeAddress(geocoder, resultsMap) {
        var address = document.getElementById('address').value;
        geocoder.geocode({'address': address}, function(results, status) {
          if (status === 'OK') {
            resultsMap.setCenter(results[0].geometry.location);
			zoom: 25;
          } else {
            alert('Please enter a valid location.');
          }
        });
	   }
    </script>
	
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=API_KEY_HERE&callback=initMap">
    </script>
	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script>
	jQuery(document).ready(function(){

	jQuery('.searchForm').submit( function() {

		$.ajax({
			url     : $(this).attr('action'),
			type    : $(this).attr('method'),
			data    : $(this).serialize(),

			success : function( data ) {
                    setTimeout(function() {
                     $('#results').html(data);  
                     }, 1000);

            },
        
		error   : function(){
            alert('Something went wrong.');
        }
    });
		return false;
	});});
	</script>
	
	<script>
	$(document).ready(function(){
	var interestCounter = 2;
		$("#myEventsLink").click(function(){
			$("#myCreatedEvents").load('getMyCreatedEvents.php');
			$("#myRegEvents").load('getMyRegisteredEvents.php');
		});
		
		$("#myProfileLink").click(function(){
				$("#myProfileInfo").load('getMyProfile.php');
		});
		
		$("#RecommendedLink").click(function(){
			$("#RecommendedEvents").load('getRecommendedEvents.php');
		});
		
		$("#addNewField").click(function() {
			$("#interestsContainer").append($('<input id="num'+ interestCounter +'" style="width: 30%" type="text" name="interests[]"><br>'));
			interestCounter++;
		});
	});
	</script>
	
	<script>
		function openNav(navScreen) {
			document.getElementById(navScreen).style.width = "100%";
		}

		function closeNav(navScreen) {
			document.getElementById(navScreen).style.width = "0%";
		}
	</script>
	
	<div id="sidebar">
            <a href="#" id="myProfileLink" onclick="openNav('myProfile'); return false;">My Profile</a>
            <a href="#" id="myEventsLink" onclick="openNav('myEvents'); return false;">My Events</a>
            <a href="#" onclick="openNav('searchEvents'); return false;">Search</a>
            <a href="#" id="RecommendedLink" onclick="openNav('Recommended'); return false;">Recommended</a>
            <a href="logout.php">Logout</a>
            <div id="newEvent">
                <a href="#" onclick="openNav('createEvent'); return false;">Create an Event</a>
            </div>
			<img src="images/logoSmall.jpg" id="logoSmall">
	</div>
	
	</div>
	
	<div id="createEvent" class="overlay">
	<a href="#" class="closebtn" onclick="closeNav('createEvent'); return false;">&times;</a>
	
	<form method="post" action="">
		<div class="overall-container">
			 <div style="margin: 10px; text-align: center;" class="header-container">
			 <label style="font-size: 28px; color: #783ac2;"><b>Create an Event</b></label>
			 </div>
                <label for="title"><b>Title</b></label>
                <input type="text" name="title" required><br>
             
                <label for="description"><b>Description</b></label>
                <input type="text" name="description" required><br>
             
                <label for="eventAddress"><b>Address</b></label>
                <input id="eventAddress" type="text" name="eventAddress" required><br>
				
				<label for="date"><b>Date of Event (YYYY-MM-DD)</b></label>
                <input type="text" name="date" required><br>
				
				<label for="startTime"><b>Start Time</b></label>
                <input type="text" name="startTime" required><br>
				
				<label for="endTime"><b>End Time</b></label>
                <input type="text" name="endTime" required><br>
				
                <label for="tags"><b>Tags</b></label>
                <input type="text" name="tags" required><br>
			 
             <div style="display: flex; justify-content: center;">
			 <input type="submit" class="button" id ="submitEvent" name="submitEvent" value="Submit">
			 </div>
		</div>
	</form>
	</div>
	
	<div id="searchEvents" class="overlay">
	<a href="#" class="closebtn" onclick="closeNav('searchEvents'); return false;">&times;</a>
	
	<form method="post" action="searchResults.php" class="searchForm">
		<div id="searchBar" class="overall-container">
			
			<input type="submit" value="Search" style="float: right" />
			<div style="overflow: hidden; padding-right: .5em;">
				<input type="text" name="searchTerm" placeholder="Enter a keyword, date, time, etc." style="width: 92%" />
			</div>
			
			<div id="results"></div>
		</div>
	</form>
	</div>
	
	<div id="myEvents" class="overlay">
	<a href="#" class="closebtn" onclick="closeNav('myEvents'); return false;">&times;</a>
		<div style="padding: 1rem;" id="myCreatedEvents"></div>
		<div id="myRegEvents"></div>
	</div>
	
	<div id="myProfile" class="overlay">
	<a href="#" class="closebtn" onclick="closeNav('myProfile'); return false;">&times;</a>
		<div id="myProfileInfo"></div>
		<div id="suggestedUsers"></div>
	</div>
	
	<div id="editProfile" class="overlay">
	<a href="#" class="closebtn" onclick="closeNav('editProfile'); return false;">&times;</a>
		<form method="post" action="">
		<div class="overall-container">
			 <div style="margin: 10px; text-align: center;" class="header-container">
			 <label style="font-size: 28px; color: #783ac2;"><b>Edit Profile</b></label>
			 </div>
                <label for="Name"><b>Name</b></label>
                <input type="text" name="name"><br>
				
                <label for="location"><b>Location</b></label>
                <input id="location" type="text" name="location" required><br>
				
				<label for="aboutMe"><b>About Me</b></label>
                <input type="text" name="description"><br>
				
				<label for="contactInfo"><b>Contact Information</b></label>
                <input type="text" name="contactInfo"><br>
				
				<label for="interests"><b>Your Interests</b></label>
				<input type="button" style="font-size: 1vw; width: 22%" class="button" id ="addNewField" name="addNewField" value="Add an Interest"> 
				<div id="interestsContainer">
                <input id="num1" style="width: 30%" type="text" name="interests[]"><br>
				</div>
             <div style="display: flex; justify-content: center;">
			 <input type="submit" class="button" id ="submitProfInfo" name="submitProfInfo" value="Submit">
			 </div>
		</div>
		</form>
	</div>
	
	<div id="Recommended" class="overlay">
	<a href="#" class="closebtn" onclick="closeNav('Recommended'); return false;">&times;</a>
		<div id="RecommendedEvents"></div>
	</div>
	
	<div id="Attendees" class="overlay">
	<a href="#" class="closebtn" onclick="closeNav('Attendees'); return false;">&times;</a>
		<div id="AttendeesList"></div>
	</div>
	
	<div id="otherUserProfile" class="overlay">
	<a href="#" class="closebtn" onclick="closeNav('otherUserProfile'); return false;">&times;</a>
		<div id="userProfile"></div>
	</div>
  </body>
</html>
