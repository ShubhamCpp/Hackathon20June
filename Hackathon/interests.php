<?php
	session_start();
	if(!isset($_SESSION['user_id']) && !isset($_SESSION['username'])) header('Location: index.php');	
	else $loggedIn = true;	
	$preferences;$valuesForInterests;
	mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
	$con = mysqli_connect("localhost","root","","hackathon") or die('error establishing connection');
	$categoryDetails = array();
	function getCategoryDetails()
	{
		global $con,$categoryDetails;
		$categoryDetailsQuery = "SELECT * FROM categories";
		$categoryDetailsResult = mysqli_query($con,$categoryDetailsQuery);
		if(mysqli_num_rows($categoryDetailsResult)>0)
		{
			while($categoryDetailsRow = mysqli_fetch_assoc($categoryDetailsResult))
				$categoryDetails[] = $categoryDetailsRow;			
		}
	}	
	if(isset($_POST['interests']))
	{
		global $preferences,$valuesForInterests;		
		$preferences = $_POST['interest'];
		$addUserInterestsQuery = "INSERT INTO interests VALUES";
		foreach($preferences as $categoryID)
			$valuesForInterests .= "(NULL,".$_SESSION['user_id'].",".$categoryID."),";
		$addUserInterestsQuery = rtrim($addUserInterestsQuery.$valuesForInterests,",");
		$addUserInterestsResult = mysqli_query($con,$addUserInterestsQuery);		
		if(mysqli_affected_rows($con)==count($preferences))
		{
			header('Location: around_you.php');
		}
		else
		{
			echo "<script>alert('Could not add user preferences');</script>";
		}
	}
	getCategoryDetails();
?>
<!DOCTYPE html>
<head>
<title>Meet Up</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<link href="layout/styles/layout.css" rel="stylesheet" type="text/css" media="all">
<link href="layout/styles/jquery.timepicker.css" rel="stylesheet" type="text/css" media="all">
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<style>
#map {
  height: 300px;
  width: 80%;
 }
input[type="checkbox"]{
	display: inline;
}
.cbtext {
 padding-left: 15px;
 font-size: 15px;
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
        <li><a class="active" href="#">People</a></li>
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
  <h4>Select your preferences</h4>
  <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
  <fieldset>
    <legend>Interests</legend>
	<?php
		foreach($categoryDetails as $category)
		{
	?>
		<input type="checkbox" name="interest[]" value="<?php echo $category['cid']; ?>"><span class="cbtext"><?php echo $category['cname']; ?></span><br>
	<?php
		}
	?>    
  	<br><br> 
	<input type="submit" class="btn" value="submit" name="interests">
	<input type="reset" class="btn" value="reset">
	</fieldset>
	</form>
  </section>
</div>
<!-- Content Ends Here -->
<!-- Footer Starts Here -->
<div class="wrapper row4">
  <footer id="footer" class="hoc clear"> 
    <!-- ################################################################################################ -->
    <div class="one_third first">
      <h6 class="heading">Cities</h6>
      <ul class="nospace btmspace-30 linklist contact">
        <li><i class="fa fa-map-marker"></i>
          Bangalore, Hyderabad
        </li>
        <li><i class="fa fa-map-marker"></i>
          Chennai, Delhi
        </li>
        <li><i class="fa fa-map-marker"></i>
          Mumbai, Pune
        </li>
        <li><i class="fa fa-map-marker"></i>
          Kolkata, Goa
        </li>
      </ul>
      <ul class="faico clear">
        <li><a class="faicon-facebook" href="#"><i class="fa fa-facebook"></i></a></li>
        <li><a class="faicon-twitter" href="#"><i class="fa fa-twitter"></i></a></li>
        <li><a class="faicon-dribble" href="#"><i class="fa fa-dribbble"></i></a></li>
        <li><a class="faicon-linkedin" href="#"><i class="fa fa-linkedin"></i></a></li>
        <li><a class="faicon-google-plus" href="#"><i class="fa fa-google-plus"></i></a></li>
        <li><a class="faicon-vk" href="#"><i class="fa fa-vk"></i></a></li>
      </ul>
    </div>
    <div class="one_third">
      <h6 class="heading">In The News</h6>
      <ul class="nospace linklist">
        <li>
          <article>
            <h2 class="nospace font-x1"><a href="#">Meet Up expands to 4 more Cities.</a></h2>
            <time class="font-xs block btmspace-10" datetime="2045-04-06">Friday, 6<sup>th</sup> April 2017</time>
            <p class="nospace">Meet Up expands to 4 new cities - Pune, Mumbai, Kolkata and Goa. [&hellip;]</p>
          </article>
        </li>
        <li>
          <article>
            <h2 class="nospace font-x1"><a href="#">Meet Up reaches 50,000+ users.</a></h2>
            <time class="font-xs block btmspace-10" datetime="2045-04-05">Tuesday, 2<sup>th</sup> April 2017</time>
            <p class="nospace">Meet Up reaches a milestone - 50,000 users, and counting. [&hellip;]</p>
          </article>
        </li>
      </ul>
    </div>
    <div class="one_third">
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