<?php 
	session_start();
	if(!isset($_SESSION['user_id']) && !isset($_SESSION['username'])) header('Location: index.php');	
	else $loggedIn = true;
	$name;$description;$category;$date;$from_time;$from_period;$to_time;$to_period;$location;$landmark;$lat;$long;
	$uid = $_SESSION['user_id'];
	$con = mysqli_connect("localhost","root","","hackathon") or die('error establishing connection');
	function createMeetUp()
	{
		global $name,$description,$category,$date,$from_time,$from_period,$to_time,$to_period,$location,$landmark,$con,$uid,$lat,$long;
		$name  = $_POST['title'];
		$description = $_POST['description'];
		$description = nl2br($description);
		$category = $_POST['category'];
		$date = $_POST['date'];
		$from_time = $_POST['from'];
		$from_period = $_POST['from_period'];
		$to_time = $_POST['to'];
		$to_period = $_POST['to_period'];
		$location = $_POST['location'];
		$landmark = $_POST['landmark'];
		$lat = $_POST['lat'];
		$long = $_POST['long'];
		$createMeetUpQuery = "INSERT INTO meetups VALUES(null,'$name','$description','$date','$from_time','$from_period','$to_time','$to_period',$category,$location,'$landmark',$uid, $lat, $long)";
		$createMeetUpResult = mysqli_query($con,$createMeetUpQuery) or die('Error Creating MeetUp');
		if(mysqli_affected_rows($con)==1)
		{
			echo 'Successfully created a MeetUp';
			header('Refresh: 3;url=around_you.php');
		}
		else
		{
			echo 'Failed to create a MeetUp';
			header('Refresh: 3;url=around_you.php');
		}
	}
	if(isset($_POST['createmeetup']))
	{
		createMeetUp();
	}
?>