<?php
	session_start();
	if(!isset($_SESSION['user_id']) && !isset($_SESSION['username'])) header('Location: index.php');	
	else $loggedIn = true;	
	$userID = $_SESSION['user_id'];
	$con = mysqli_connect("localhost","root","","hackathon") or die('error establishing connection');
	$similarInterestsPeople = array();
	$curUserInterests = "";
	function similarInterests()
	{
		global $con,$similarInterestsPeople,$curUserInterests,$userID;		
		$curUserInterestsQuery = 
			"
				SELECT interests.cid FROM interests WHERE interests.uid = $userID
			";		
		$curUserInterestsResult = mysqli_query($con,$curUserInterestsQuery) or die('error retrieving current user interests');
		while($curUserInterestsRow = mysqli_fetch_assoc($curUserInterestsResult))
		{
			$curUserInterests .= $curUserInterestsRow['cid'].',';			
		}
		$curUserInterests = rtrim($curUserInterests,",");	
		
		$similarInterestsQuery = 
		"
			SELECT users.uid,users.uname 
			FROM users WHERE users.uid = (SELECT DISTINCT(interests.uid) FROM interests WHERE interests.uid != $userID AND interests.cid IN ($curUserInterests))
		";
		$similarInterestsResult = mysqli_query($con,$similarInterestsQuery) or die('error retrieving people with similar interests');
		while($similarInterestsRow = mysqli_fetch_assoc($similarInterestsResult))
			$similarInterestsPeople[] = $similarInterestsRow;		
	}
	similarInterests();
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
table {
	width: 60%;
	text-align: center;
	margin-left: auto;
	margin-right: auto;
}
#peopleheading {
	width: 35%;
	margin-left: auto;
	margin-right: auto;
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
      <h1><a href="index.html">Meet Up - Events, People, Life</a></h1>
    </div>
    <nav id="mainav" class="fl_right">
      <ul class="clear">
        <li class="active"><a href="index.html">Home</a></li>
        <li><a class="active" href="#">About</a></li>        
        <li><a class="active" href="people.php">People</a></li>
        <li><a href="around_you.php"><?php if($loggedIn) echo $_SESSION['username']; ?></a></li>
        <?php if($loggedIn) echo '<li><a href="logout.php">logout</a></li>'; ?>
      </ul>
    </nav>
    <!-- ################################################################################################ -->
  </header>
</div>
<!-- Beginning of the Content Page -->
<div class="wrapper bgded overlay light" style="background-color:white;">
  <section class="hoc container clear">
    <h3 id="peopleheading">People with similar interests</h3>
	<table>
	<tr>
		<th>ID</th>
		<th>Name</th>
	</tr>
	<?php
		if(empty($similarInterestsPeople))
		{
			echo "No people with similar Interest";
		}
		else
		{
			foreach($similarInterestsPeople as $similarPerson)
				echo 
				"<tr>
					<td>".$similarPerson['uid']."</td>				
					<td>".$similarPerson['uname']."</td>				
				</tr>";	
		}
	?>
	</table>
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