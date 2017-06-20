<?php
	session_start();
	if(!isset($_SESSION['user_id']) && !isset($_SESSION['username'])) header('Location: index.php');	
	else $loggedIn = true;
	$meetUps = array();
	$yourMeetUps = array();
	$userLocation = array();
	$meetUpPreferences = array();
	$con = mysqli_connect("localhost","root","","hackathon") or die('error establishing connection');
	function getMeetUpsLocation()
	{
		global $con,$userLocation,$meetUps;
		$userLocationQuery = "SELECT lid AS location_id,lname AS location_name FROM users INNER JOIN locations ON users.location = locations.lid WHERE uid = ".$_SESSION['user_id'];		
		$userLocationResult = mysqli_query($con,$userLocationQuery) or die('error executing query');
		if(mysqli_affected_rows($con)!=1) { echo 'Error Fetching Meet Ups'; exit; }
		$userLocationRow = mysqli_fetch_assoc($userLocationResult);
		$userLocation['lid'] = $userLocationRow['location_id'];
		$userLocation['lname'] = $userLocationRow['location_name'];	
		
		$getMeetUpsAroundUserLocationQuery = "SELECT * FROM meetups WHERE lid = ".$userLocation['lid'];		
		$getMeetUpsAroundUserLocationResult = mysqli_query($con,$getMeetUpsAroundUserLocationQuery) or die('Error Retrieving Meet Up Details');
		while($getMeetUpsAroundUserLocationRow = mysqli_fetch_assoc($getMeetUpsAroundUserLocationResult))
		{
			$meetUps[] = $getMeetUpsAroundUserLocationRow;
		}
	}
	function getYourMeetUps()
	{
		global $con,$yourMeetUps;
		$yourMeetUpsQuery = 
		"
			SELECT meetups.mid,meetups.mname,meetups.mdescription FROM meetups INNER JOIN attendees ON meetups.mid = attendees.mid WHERE attendees.uid = ".$_SESSION['user_id']."
		";
		$yourMeetUpsResult = mysqli_query($con,$yourMeetUpsQuery) or die('error fetching user\'s meetups');;
		while($yourMeetUpsRow = mysqli_fetch_assoc($yourMeetUpsResult)){
			$yourMeetUps[] = $yourMeetUpsRow;
		}
	}
	function getMeetUpsPreferences()
	{
		global $con,$meetUpPreferences,$yourMeetUps;
		$getMeetUpPreferencesQuery = 
		"
			SELECT meetups.mid,meetups.mname,interests.uid,interests.cid FROM meetups INNER JOIN interests ON meetups.cid = interests.cid
			WHERE interests.uid =".$_SESSION['user_id'];"
		";
		$getMeetUpPreferencesResult = mysqli_query($con,$getMeetUpPreferencesQuery) or die('error fetching preferences');
		while($getMeetUpPreferencesRow = mysqli_fetch_assoc($getMeetUpPreferencesResult))		
			$meetUpPreferences[] = $getMeetUpPreferencesRow;
		$meetUpPreferences = array_udiff($meetUpPreferences,$yourMeetUps,'compareMeetUpIDs');
	}
	function compareMeetUpIDs($val1,$val2)
	{
		return strcmp($val1['mid'],$val2['mid']);
	}
	getYourMeetUps();	
	getMeetUpsLocation();
	getMeetUpsPreferences();
?>
<!DOCTYPE html>
<head>
<title>Meet Up</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<link href="layout/styles/layout.css" rel="stylesheet" type="text/css" media="all">
<link href="layout/styles/jquery.timepicker.css" rel="stylesheet" type="text/css" media="all">
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<style type="text/css">
h3
{
	display: block;			
	text-align: center;
}
table
{
	width: 60%;
	margin-left: auto;
	margin-right: auto;	
}
table td 
{
	border-width: 1px;
}
table tr td:nth-child(1)
{
	text-align: center;
}
form 
{
	width: 60%;
	margin-left: auto;
	margin-right: auto;		
}
#timeselection *
{
	display: inline;
}
      /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
      #map {
        height: 300px;
        width: 100%;
      }
      /* Optional: Makes the sample page fill the window. */
#description {
        font-family: Roboto;
        font-size: 15px;
        font-weight: 300;
      }

      #infowindow-content .title {
        font-weight: bold;
      }

      #infowindow-content {
        display: none;
      }

      #map #infowindow-content {
        display: inline;
      }

.pac-card {
        margin: 10px 10px 0 0;
        border-radius: 2px 0 0 2px;
        box-sizing: border-box;
        -moz-box-sizing: border-box;
        outline: none;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
        background-color: #fff;
        font-family: Roboto;
      }

      #pac-container {
        padding-bottom: 12px;
        margin-right: 12px;
      }

      .pac-controls {
        display: inline-block;
        padding: 5px 11px;
      }

      .pac-controls label {
        font-family: Roboto;
        font-size: 13px;
        font-weight: 300;
      }

      #pac-input {
        background-color: #fff;
        font-family: Roboto;
        font-size: 15px;
        font-weight: 300;
        margin-left: 12px;
        padding: 0 11px 0 13px;
        text-overflow: ellipsis;
        width: 400px;
      }

      #pac-input:focus {
        border-color: #4d90fe;
      }

      #title {
        color: #fff;
        background-color: #4d90fe;
        font-size: 25px;
        font-weight: 500;
        padding: 6px 12px;
      }
 </style>
 <script>
 	var rad = function(x) {
  	return x * Math.PI / 180;
	};

	var getDistance = function(p1, p2) {
  	var R = 6378137; // Earth’s mean radius in meter
  	var dLat = rad(p2.lat() - p1.lat());
  	var dLong = rad(p2.lng() - p1.lng());
  	var a = Math.sin(dLat / 2) * Math.sin(dLat / 2) +
    	Math.cos(rad(p1.lat())) * Math.cos(rad(p2.lat())) *
    	Math.sin(dLong / 2) * Math.sin(dLong / 2);
  	var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
  	var d = R * c;
  	return d; // returns the distance in meter
	};
 </script>
</head>
<body id="top" onload="getLocation()">
<!-- Header Starts Here -->
<div class="wrapper row1">
  <header id="header" class="hoc clear">     
    <div id="logo" class="fl_left">
      <h1><a href="index.php">Meet Up - Events, People, Life</a></h1>
    </div>
    <nav id="mainav" class="fl_right">
      <ul class="clear">
        <li class="active"><a href="index.php">Home</a></li>
        <li><a class="active" href="#">About</a></li>        
        <li><a class="active" href="people.php">People</a></li>
        <li><a href="around_you.php"><?php if($loggedIn) echo $_SESSION['username']; ?></a></li>
        <?php if($loggedIn) echo '<li><a href="logout.php">logout</a></li>'; ?>
		<?php if($loggedIn) echo '<li><a href="share.php">share deals</a></li>'; ?>
		<?php if($loggedIn) echo '<li><a href="messages.php">messages</a></li>'; ?>
      </ul>
    </nav>
    <!-- ################################################################################################ -->
  </header>
</div>
<!-- Beginning of the Content Page -->
<div class="wrapper bgded overlay light" style="background-color:white;">
  <section class="hoc container clear">
    <h3>Meet Ups You are part Of</h3>
	<table>
	<?php
		if(empty($yourMeetUps))
		{ 
			echo 
			"
				<tr>
					<td>None</td>				
				</tr>
			";
		}
		else
		{
			foreach($yourMeetUps as $yourMeetUpDetails)
			echo 
				"<tr>
					<td><a href='meet_up_details.php?meetupid=".$yourMeetUpDetails['mid']."'>".$yourMeetUpDetails['mname']."</a></td>				
				</tr>";	
		}
	?>
	</table>
    <h3>Meet Ups Around Your Location ( <?php echo $userLocation['lname']; ?> )</h3>
	<table>
	<?php
		if(empty($meetUps))
		{ 
			echo 
			"
				<tr>
					<td>None</td>				
				</tr>
			";
		}
		else
		{
			foreach($meetUps as $meetUpDetails)
			echo 
				"<tr>
					<td><a href='meet_up_details.php?meetupid=".$meetUpDetails['mid']."'>".$meetUpDetails['mname']."</a></td>
					<td>".$meetUpDetails['latitude'].",".$meetUpDetails['longitude']."</td>			
				</tr>";	
		}
	?>
	</table>
	<h3>Meet Ups According to Your preferences</h3>
	<table>
	<?php
		if(empty($meetUpPreferences))
		{ 
			echo 
			"
				<tr>
					<td>None</td>				
				</tr>
			";
		}
		else
		{
			foreach($meetUpPreferences as $meetUpDetails)
			echo 
				"<tr>
					<td><a href='meet_up_details.php?meetupid=".$meetUpDetails['mid']."'>".$meetUpDetails['mname']."</a></td>
					
				</tr>";
		}
	?>
	<tr>
	</tr>
	</table>
	
	
	<h3 style="margin-top: 50px;">Create a new meet up</h3>
	<form method="POST" action="create_meet_up.php">
	Name:<input type="text" name="title" required/><br />
	Description:<textarea name="description" rows="10" cols="60" required></textarea><br />
	Category:<select name="category" />
				<option value="1">PHP and MySQL</option>
				<option value="2">Machine Learning</option>
				<option value="3">Artificial Intellegence</option>
				<option value="4">Algorithms</option>
				<option value="5">Data Science</option>
				<option value="6">Dev Ops</option>
			 </select><br />
	Date:<input type="text" name="date" id="date"  required/><br />
	Time:<p id="timeselection"><input type="text" name="from" id="from_time"  required/>
	<select name="from_period">
		<option value="AM">AM</option>
		<option value="PM">PM</option>
	</select>
	<input type="text" name="to" id="to_time"  required/>
	<select name="to_period">
		<option value="AM">AM</option>
		<option value="PM">PM</option>
	</select></p>
	City:<select name="location" />
				<option value="1">Hyderabad</option>
				<option value="2">Bangalore</option>
				<option value="3">Mumbai</option>
				<option value="4">Delhi</option>
			 </select><br />
	Location:<input type="text" name="landmark" id="landmark" required><br />
	Latitude:<input type="text" name="lat" id="lat" required><br />
	Longitude:<input type="text" name="long" id="long" required><br />
<div class="pac-card" id="pac-card">
      <div id="pac-container">
        <input id="pac-input" type="text"
            placeholder="Enter a location">
      </div>
    </div>
    <div id="map"></div>
    <div id="infowindow-content">
      <img src="" width="16" height="16" id="place-icon">
      <span id="place-name"  class="title"></span><br>
      <span id="place-address"></span>
    </div>

    <script>
      // This example requires the Places library. Include the libraries=places
      // parameter when you first load the API. For example:
      // <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places">

      function initMap() {
        var map = new google.maps.Map(document.getElementById('map'), {
          center: {lat: -33.8688, lng: 151.2195},
          zoom: 13
        });
        var card = document.getElementById('pac-card');
        var input = document.getElementById('pac-input');
        var types = document.getElementById('type-selector');
        var strictBounds = document.getElementById('strict-bounds-selector');

        map.controls[google.maps.ControlPosition.TOP_RIGHT].push(card);

        var autocomplete = new google.maps.places.Autocomplete(input);

        // Bind the map's bounds (viewport) property to the autocomplete object,
        // so that the autocomplete requests use the current map bounds for the
        // bounds option in the request.
        autocomplete.bindTo('bounds', map);

        var infowindow = new google.maps.InfoWindow();
        var infowindowContent = document.getElementById('infowindow-content');
        infowindow.setContent(infowindowContent);
        var marker = new google.maps.Marker({
          map: map,
          anchorPoint: new google.maps.Point(0, -29)
        });

        autocomplete.addListener('place_changed', function() {
          infowindow.close();
          marker.setVisible(false);
          var place = autocomplete.getPlace();
          if (!place.geometry) {
            // User entered the name of a Place that was not suggested and
            // pressed the Enter key, or the Place Details request failed.
            window.alert("No details available for input: '" + place.name + "'");
            return;
          }


          var lat = place.geometry.location.lat();
          var long = place.geometry.location.lng();
          var address_place = place.formatted_address;


          document.getElementById("landmark").value = address_place;
          document.getElementById("lat").value = lat;
          document.getElementById("long").value = long;


          // If the place has a geometry, then present it on a map.
          if (place.geometry.viewport) {
            map.fitBounds(place.geometry.viewport);
          } else {
            map.setCenter(place.geometry.location);
            map.setZoom(17);  // Why 17? Because it looks good.
          }
          marker.setPosition(place.geometry.location);
          marker.setVisible(true);

          var address = '';
          if (place.address_components) {
            address = [
              (place.address_components[0] && place.address_components[0].short_name || ''),
              (place.address_components[1] && place.address_components[1].short_name || ''),
              (place.address_components[2] && place.address_components[2].short_name || '')
            ].join(' ');
          }

          infowindowContent.children['place-icon'].src = place.icon;
          infowindowContent.children['place-name'].textContent = place.name;
          infowindowContent.children['place-address'].textContent = address;
          infowindow.open(map, marker);
        });

        // Sets a listener on a radio button to change the filter type on Places
        // Autocomplete.
        function setupClickListener(id, types) {
          var radioButton = document.getElementById(id);
          radioButton.addEventListener('click', function() {
            autocomplete.setTypes(types);
          });
        }

        setupClickListener('changetype-all', []);
        setupClickListener('changetype-address', ['address']);
        setupClickListener('changetype-establishment', ['establishment']);
        setupClickListener('changetype-geocode', ['geocode']);

        document.getElementById('use-strict-bounds')
            .addEventListener('click', function() {
              console.log('Checkbox clicked! New state=' + this.checked);
              autocomplete.setOptions({strictBounds: this.checked});
            });
      }
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBk9_psu_rF5vJPhAOa4bdUc2F--qgvK1c&libraries=places&callback=initMap"
        async defer></script>
    <br><br>
	<input type="submit" name="createmeetup" value="CREATE MEET UP" class="btn" />
	</form>

	<p id="demo"></p>

	 <script>
var x = document.getElementById("demo");
function getLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition);
    } else {
        x.innerHTML = "Geolocation is not supported by this browser.";
    }
}
function showPosition(position) {

	//d = getDistance(position.coords, LatLng(17.4946, 78.3922));

    x.innerHTML = "Latitude: " + position.coords.latitude + 
    "<br>Longitude: " + position.coords.longitude +
    "<br>Distance: "; 

}
</script>

	</section>
</div>
<!-- ################################################################################################ -->
<!-- ################################################################################################ -->
<!-- ################################################################################################ -->
<!-- Content Ends Here -->
<!-- Footer Starts Here -->
<div class="wrapper row4">
  <footer id="footer" class="hoc clear"> 
    <!-- ################################################################################################ -->
    <div class="one_third first" style="margin-left: 15%;">
      <h6 class="heading">Cities</h6>
      <ul class="nospace btmspace-30 linklist contact">
        <li><i class="fa fa-map-marker"></i>
          Hyderabad
        </li>
        <li><i class="fa fa-map-marker"></i>
          Bangalore
        </li>
        <li><i class="fa fa-map-marker"></i>
          Mumbai
        </li>
        <li><i class="fa fa-map-marker"></i>
          Delhi
        </li>
      </ul>
     <!--  <ul class="faico clear">
        <li><a class="faicon-facebook" href="#"><i class="fa fa-facebook"></i></a></li>
        <li><a class="faicon-twitter" href="#"><i class="fa fa-twitter"></i></a></li>
        <li><a class="faicon-dribble" href="#"><i class="fa fa-dribbble"></i></a></li>
        <li><a class="faicon-linkedin" href="#"><i class="fa fa-linkedin"></i></a></li>
        <li><a class="faicon-google-plus" href="#"><i class="fa fa-google-plus"></i></a></li>
        <li><a class="faicon-vk" href="#"><i class="fa fa-vk"></i></a></li>
      </ul> -->
    </div>    
    <div class="one_third"  style="margin-left: 15%;">
      <h6 class="heading">OUR NEWSLETTER</h6>
      <p class="nospace btmspace-30">Get weekly updates of great events in your city.</p>
      <form method="post" action="#">
        <fieldset>
          <legend>Newsletter:</legend>
          <input class="btmspace-15" type="text" value="" placeholder="Name">
          <input class="btmspace-15" type="text" value="" placeholder="Email">
          <button type="submit" value="submit">Subscribe</button>
        </fieldset>
      </form>
    </div>
    <!-- ################################################################################################ -->
  </footer>
</div>
<!-- ################################################################################################ -->
<!-- ################################################################################################ -->
<!-- ################################################################################################ -->
<div class="wrapper row5">
  <div id="copyright" class="hoc clear"> 
    <!-- ################################################################################################ -->
    <p class="fl_left">Copyright &copy; 2017 - All Rights Reserved - <a href="#">Meet Up, Inc.</a></p>
    <!-- ################################################################################################ -->
  </div>
</div>
<!-- ################################################################################################ -->
<!-- ################################################################################################ -->
<!-- ################################################################################################ -->
<a id="backtotop" href="#top"><i class="fa fa-chevron-up"></i></a>
<!-- JAVASCRIPTS -->
<script src="layout/scripts/jquery.min.js"></script>
<script src="layout/scripts/jquery-ui.js"></script>
<script src="layout/scripts/jquery.backtotop.js"></script>
<script src="layout/scripts/jquery.mobilemenu.js"></script>
<script src="layout/scripts/jquery.flexslider-min.js"></script>
<script src="layout/scripts/jquery.timepicker.min.js"></script>
<!-- <script src="https://code.jquery.com/jquery-1.12.4.js"></script> -->
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script type="text/javascript">
	$(function(){
		$("#date").datepicker({dateFormat: 'yy/mm/dd'});
		$('#from_time').timepicker({ 'timeFormat': 'h:i:s' });
		$('#to_time').timepicker({ 'timeFormat': 'h:i:s' });
	});
</script>
</body>
</html>