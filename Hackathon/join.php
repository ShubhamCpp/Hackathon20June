<?php
	$meetUpID;$userID;
	$con = mysqli_connect("localhost","root","","hackathon") or die('error establishing connection');
	if(isset($_POST['join']))
	{
		global $meetUpID,$userID;
		$meetUpID = $_POST['mid'];
		$userID = $_POST['uid'];		
		joinUserToMeetUp();
	}
	function joinUserToMeetUp()
	{
		global $con,$meetUpID,$userID;		
		$joinUserToMeetUpQuery = 
		"
			INSERT INTO attendees VALUES($meetUpID,$userID);
		";		
		$joinUserToMeetUpResult = mysqli_query($con,$joinUserToMeetUpQuery) or die('Error Joining user to meetup');
		if(mysqli_affected_rows($con) == 1){ 
			echo 'welcome aboard...Redirecting you to meetup page';
			$location = "meet_up_details.php?meetupid=".$meetUpID;			
			header("Refresh: 3;url=$location");
		}		
	}
?>