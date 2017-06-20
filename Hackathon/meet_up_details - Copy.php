<?php	
	session_start();
	if(!isset($_SESSION['user_id']) || !isset($_SESSION['username'])) header('Location: index.php');
	else $loggedIn = true;
	// mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
	$con = mysqli_connect("localhost","root","","hackathon") or die('error establishing connection');
	$meetUpDetails = array();
	$attendeeIDs = array();
	$attendeeNames = array();
	$attendeesString = "";
	$joined = false;
	
	$latitude = "-25.363";
	$longitude = "131.044";
	
	
	function getMeetUpDetails($meetupid)
	{
		global $con,$meetUpDetails;
		$meetUpDetailsQuery = 
		"
			SELECT meetups.mid,meetups.mname,meetups.mdescription,meetups.date,meetups.from_time,meetups.from_period,meetups.to_time,meetups.to_period,meetups.landmark,locations.lid,locations.lname,users.uid,users.uname FROM meetups 
			INNER JOIN locations ON meetups.lid=locations.lid
			INNER JOIN users ON meetups.uid=users.uid
			WHERE meetups.mid = $meetupid
		";		
		$meetUpDetailsResult = mysqli_query($con,$meetUpDetailsQuery) or die('error retrieving meet up details for this meetup');
		$meetUpDetailsRow = mysqli_fetch_assoc($meetUpDetailsResult);
		$meetUpDetails = $meetUpDetailsRow;		
	}
	function fetchAttendees($meetupid)
	{
		global $con,$attendeeIDs,$attendeeNames,$attendeesString;
		$fetchAttendeesQuery = 
		"
			SELECT users.uid,users.uname FROM attendees INNER JOIN users ON attendees.uid = users.uid WHERE attendees.mid = $meetupid;
		";
		$fetchAttendeesResult = mysqli_query($con,$fetchAttendeesQuery) or die('error retrieving attendees for this meetup');		
		while($fetchAttendeesRow = mysqli_fetch_array($fetchAttendeesResult))
		{
			$attendeeIDs[] = $fetchAttendeesRow[0];
			$attendeeNames[] = $fetchAttendeesRow[1];
		}			
		if(empty($attendeeIDs))$attendeesString = "";
		else
		{
			foreach($attendeeNames as $attenderID)
				$attendeesString .= $attenderID.",";
		}	
		$attendeesString = rtrim($attendeesString,",");
	}
	function determineDisplay()
	{
		global $attendeeIDs,$joined;
		if(in_array($_SESSION['user_id'],$attendeeIDs))
			$joined=true;	
	}
	$meetupid = $_GET['meetupid'];
	getMeetUpDetails($meetupid);
	fetchAttendees($meetupid);
	determineDisplay();		
?>
<!DOCTYPE html>
<head>
<title>Meet Up</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<link href="layout/styles/layout.css" rel="stylesheet" type="text/css" media="all">
<style>
#map {
  height: 300px;
  width: 80%;
 }
 </style>
</head>
<body id="top">
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
  </header>
</div>

<div class="bgded overlay" style="background-image:url('images/demo/backgrounds/Tech_Event2.jpg');">
  <div id="pageintro" class="hoc clear">     
    <div class="flexslider basicslider">
      <ul class="slides">
        <li>
          <article>
            <h3 class="heading"><?php echo $meetUpDetails['mname']; ?></h3>
            <h3 class="heading2"><?php echo $meetUpDetails['mdescription']; ?></h3>
            <footer>
			<?php 
				if($joined) 
				{
					echo '<span class="btn">JOINED</span>'; 					
				}
				else 
					echo '<form method="POST" action="join.php">
								<input type="submit" name="join" class="btn" value="JOIN US" />';
			?>
								<input type="hidden" name="mid" value="<?php echo $meetupid; ?>" />
								<input type="hidden" name="uid" value="<?php echo $_SESSION['user_id']; ?>" />
			<?php
				echo '</form>';
			?>
			</footer>
          </article>
        </li>
      </ul>
    </div>
    <!-- ################################################################################################ -->
  </div>
</div>
<!-- Beginning of the Content Page -->
<div class="wrapper bgded overlay light" style="background-color:white;">
  <section class="hoc container clear">    
    <div class="sectiontitle">
      <h3 class="heading" style="font-size:40px"><?php echo $meetUpDetails['mname']; ?></h3>
    </div>
    <!-- This contains Time, Location on one half and People Attending on the other -->
    <!-- Time, Location on the left -->
    <div class="one_half first">
      <h6 class="heading">Time , Location , Organizer Information</h6>
      <ul class="nospace btmspace-30 linklist contact">
        <li style="font-size:15px"><i class="fa fa-calendar" style="font-size:15px"></i>
          <?php echo date('F j, Y',strtotime($meetUpDetails['date'])); 
		  echo '&nbsp;'.date('H:i',strtotime($meetUpDetails['from_time'])); 
		  echo '&nbsp;'.$meetUpDetails['from_period']; 
		  echo '&nbsp;'.date('H:i',strtotime($meetUpDetails['to_time'])); 
		  echo '&nbsp;'.$meetUpDetails['to_period']; ?>
        </li>
        <li style="font-size:15px"><i class="fa fa-map-marker" style="font-size:15px"></i>
          <?php echo $meetUpDetails['landmark'].','.$meetUpDetails['lname']; ?>
        </li>
		<li style="font-size:15px"><i class="fa fa-male" style="font-size:15px"></i>
          <?php echo $meetUpDetails['uname']; ?>
        </li>
      </ul>
	  <h6>Tweet</h6>
	  <?php 
		echo '<div style="margin-bottom: 10px;"><a href="https://twitter.com/share" class="twitter-share-button" data-size="large" data-text="'.strip_tags($meetUpDetails['mdescription']).'" data-via="narendra_vnr" data-hashtags="meetup" data-lang="en" data-show-count="false">Tweet</a></div><script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>';
	   ?>
    </div>
    <!-- People Attending on the right -->
    <div class="one_half" style="border: 1px solid black; padding: 10px; width: 200px;">
      <h6 class="heading">People Attending</h6>
      <ul class="nospace linklist" style="text-align: center;"">
	  <?php
		if(!empty($attendeeNames))
		{
			foreach($attendeeNames as $attendeeName)
			echo 
			"
				<li>
					<i class=''>".$attendeeName."</i>
					
				</li>
			";
		}
		else
		{
			echo 'None';
		}
	  ?>
        <!-- <li><i class=""></i>
          Rohan
        </li>
        <li><i class=""></i>
          Shetty
        </li>
        <li><i class=""></i>
          Sherry
        </li>
        <li><i class=""></i>
          Rob
        </li>
        <li><i class=""></i>
          Marilyn
        </li> -->
      </ul>
    </div>
    <!-- Map title -->
    <div><br><br><br><br><br><br>
      <h6 class="heading" style="clear: left;">Find the Event on Map</h6>
    </div>
    <!-- Google Maps API -->
    <div id="map"></div>
    <script>
      function initMap() {
		var latitude = document.getElementById("lat").value;
		var longitude = document.getElementById("lon").value;
        var uluru = {lat: <?php echo $latitude; ?>, lng: <?php echo $latitude; ?>};
        var map = new google.maps.Map(document.getElementById('map'), {
          zoom: 4,
          center: uluru
        });
        var marker = new google.maps.Marker({
          position: uluru,
          map: map
        });
      }
    </script>
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBk9_psu_rF5vJPhAOa4bdUc2F--qgvK1c&callback=initMap">
    </script>
	<input type="hidden" id="lat" name="lat" value="-25.363" />
	<input type="hidden" id="lon" name="lon" value="131.044" />
    <!-- Google Maps API ends here -->
    <!-- Section explaining About The Event -->	
    <div class="block clear">
        <div><br></div>
      <h6 class="heading">About the Event</h6>
      <ul class="nospace linklist">
        <li>
          <p class="nospace"><?php echo $meetUpDetails['mdescription']; ?></p>
        </li>
      </ul>
    </div>    
    <div class="clear"></div>
  </section>
</div>
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
<div class="wrapper row5">
  <div id="copyright" class="hoc clear">     
    <p class="fl_left">Copyright &copy; 2017 - All Rights Reserved - <a href="#">Meet Up, Inc.</a></p>    
  </div>
</div>
<a id="backtotop" href="#top"><i class="fa fa-chevron-up"></i></a>
<!-- JAVASCRIPTS -->
<script src="layout/scripts/jquery.min.js"></script>
<script src="layout/scripts/jquery.backtotop.js"></script>
<script src="layout/scripts/jquery.mobilemenu.js"></script>
<script src="layout/scripts/jquery.flexslider-min.js"></script>
</body>
</html>