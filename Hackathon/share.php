<?php
	session_start();
	if(!isset($_SESSION['user_id']) && !isset($_SESSION['username'])) header('Location: index.php');	
	else $loggedIn = true;	
	$con = mysqli_connect("localhost","root","","hackathon") or die('error establishing connection');
	$yourMeetUps = array();
	$meetUpID;$dealName;$dealDescription;$usersOfThisMeetUp;
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
	getYourMeetUps();
	if(isset($_POST['share']))
	{
		global $usersOfThisMeetUp,$meetUpID,$dealName,$dealDescription,$con;
		$meetUpID = $_POST['meetupid'];
		$dealName = $_POST['dname'];
		$dealDescription = $_POST['ddescription'];
		$shareDealQuery =  
		"
			INSERT INTO deals VALUES(NULL,'$dealName','$dealDescription',".$_SESSION['user_id'].",$meetUpID)
		";
		/* echo $shareDealQuery; */
		$shareDealResult = mysqli_query($con,$shareDealQuery);// or die('Error Sharing Deal');
		if(mysqli_affected_rows($con)==1)
		{
			echo "<script>alert('deal shared with members of meetup');</script>";
			
			/* 1.Get all users of this meetup */
			$getUsersOfThisMeetUpQuery = 
			"
				SELECT uid FROM `attendees` WHERE mid=$meetUpID
			";
			$getUsersOfThisMeetUpResult = mysqli_query($con,$getUsersOfThisMeetUpQuery) or die('Error Retrieving users of meet up');
			while($getUsersOfThisMeetUpRow = mysqli_fetch_assoc($getUsersOfThisMeetUpResult))
				$usersOfThisMeetUp[] = $getUsersOfThisMeetUpRow['uid'];
			
			
			/* 1b. get recently created deal */
			
			$recentlyCreatedDealIDQuery =
			"
				SELECT did FROM deals ORDER BY did DESC LIMIT 1;
			";
			$recentlyCreatedDealIDResult = mysqli_query($con,$recentlyCreatedDealIDQuery) or die('Error retrieving recently added deal');
			
			$recentlyCreatedDealIDRow = mysqli_fetch_assoc($recentlyCreatedDealIDResult);
			$recentDealID = $recentlyCreatedDealIDRow['did'];			
			
			/* 2. Insert Deal Details into Messages */
			$insertDealsIntoMessagesQuery =
			"
				INSERT INTO messages VALUES
			";
			foreach($usersOfThisMeetUp as $user)
			{
				if($user != $_SESSION['user_id'])
					$insertDealsIntoMessagesQuery .= "(NULL,$user,$recentDealID,'$dealName','$dealDescription',".$_SESSION['user_id'].",'".$_SESSION['username']."'),";
			}
			$insertDealsIntoMessagesQuery = rtrim($insertDealsIntoMessagesQuery,",");
			$insertDealsIntoMessagesResult = mysqli_query($con,$insertDealsIntoMessagesQuery) or die('Error inserting into messages table');
			if($insertDealsIntoMessagesResult){
				echo "<script>alert('Messages regarding deal shared with members');</script>";
			}			
			else {
				echo "<script>alert('error sharing Messages regarding deal with members of meetup');</script>";
			}
			//header('Location: around_you.php');
		}
		else
		{
			echo "<script>alert('error sharing deal with members of meetup');</script>";
		}
	}
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
</style>
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
        <li><a href="index.php">Home</a></li>
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
	<form name="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
		Select Group To Share Deal<select name="meetupid" />
			<?php
				foreach($yourMeetUps as $meetUp)
				{
			?>
				<option value="<?php echo $meetUp['mid']; ?>"><?php echo $meetUp['mname']; ?></option>
			<?php
				}					
			?>
		</select><br />
		Enter Deal Name:
		<input type="text" name="dname" required/><br />
		Enter Deal Description:
		<textarea name="ddescription" rows="10" cols="60" required></textarea><br />
		<input type="submit" class="btn" name="share" value="SHARE DEAL" />
	</form>
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