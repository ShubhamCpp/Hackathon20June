<?php
	session_start();
	if(isset($_SESSION['user_id']) && isset($_SESSION['username'])) header('Location: around_you.php');	
?>
<!DOCTYPE html>
<html lang="">
<!-- To declare your language - read more here: https://www.w3.org/International/questions/qa-html-language-declarations -->
<head>
<title>Meet Up</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<link href="layout/styles/layout.css" rel="stylesheet" type="text/css" media="all">
</head>
<body id="top">
<!-- ################################################################################################ -->
<!-- ################################################################################################ -->
<!-- ################################################################################################ -->
<div class="wrapper row1">
  <header id="header" class="hoc clear"> 
    <!-- ################################################################################################ -->
    <div id="logo" class="fl_left">
      <h1><a href="index.html">Meet Up - Events, People, Life</a></h1>
    </div>
    <nav id="mainav" class="fl_right">
      <ul class="clear">
        <li class="active"><a href="index.html">Home</a></li>
        <li><a class="active" href="#">About</a></li>                
        <li><a href="login.php">Login</a></li>
        <li><a href="registration.php">Register</a></li>
		
      </ul>
    </nav>
    <!-- ################################################################################################ -->
  </header>
</div>
<!-- ################################################################################################ -->
<!-- ################################################################################################ -->
<!-- ################################################################################################ -->
<div class="bgded overlay" style="background-image:url('images/demo/backgrounds/Tech Event.jpg');">
  <div id="pageintro" class="hoc clear"> 
    <!-- ################################################################################################ -->
    <div class="flexslider basicslider">
      <ul class="slides">
        <li>
          <article>
            <h3 class="heading">Meet Up</h3>
            <h3 class="heading2">Meet Your City. Meet Your Life.</h3>
          </article>
        </li>
        <li>
          <article>
            <h3 class="heading">Today's Most Popular</h3>
            <h3 class="heading2">Find out what People are upto Today</h3>
          </article>
        </li>
        <li>
          <article>
            <h3 class="heading">Find People</h3>
            <h3 class="heading2">We can help you find Friends with Similar Interests.</h3>
          </article>
        </li>
      </ul>
    </div>
    <!-- ################################################################################################ -->
  </div>
</div>
<!-- ################################################################################################ -->
<!-- ################################################################################################ -->
<!-- ################################################################################################ -->
<!-- <div class="wrapper bgded overlay light" style="background-color:white;">
  <section class="hoc container clear"> 
    <!-- ################################################################################################ 
    <div class="sectiontitle">
      <h3 class="heading">Meet Up Event Picks</h3>
      <p>Choose from a genre of Events around you.</p>
    </div>
    <ul class="nospace group services">
      <li class="one_third first">
        <article><a href="#"><i class="icon fa fa-plane"></i></a>
          <h6 class="heading">Outdoors</h6>
          <p>Treks, Cave Explorations, Kayaking, Water Sports,  Camping &amp Adventure Activities&hellip;</p>
        </article>
      </li>
      <li class="one_third">
        <article><a href="#"><i class="icon fa fa-youtube-play"></i></a>
          <h6 class="heading">Movies</h6>
          <p>English, Hindi, Regional&hellip;</p>
        </article>
      </li>
      <li class="one_third">
        <article><a href="#"><i class="icon fa fa-glass"></i></a>
          <h6 class="heading">Parties and Nightlife</h6>
          <p>Bollywood Night, Friday Night Party, DJs, Lounges&hellip;</p>
        </article>
      </li>
      <li class="one_third first">
        <article><a href="#"><i class="icon fa fa-headphones"></i></a>
          <h6 class="heading">Live Shows</h6>
          <p>DJs, EDM, Music Shows, Live Stage Concerts&hellip;</p>
        </article>
      </li>
      <li class="one_third">
        <article><a href="pages/Technology.html"><i class="icon fa fa-laptop"></i></a>
          <h6 class="heading">Technology</h6>
          <p>Tech Meetups, Hackathons, Workshops and more&hellip;</p>
        </article>
      </li>
      <li class="one_third">
        <article><a href="#"><i class="icon fa fa-graduation-cap"></i></a>
          <h6 class="heading">Classes and Workshops</h6>
          <p>Art, Culture, Science, Technology, Music and more&hellip;</p>
        </article>
      </li>
    </ul>
    <!-- ################################################################################################ 
    <div class="clear"></div>
  </section>
</div> -->
<div class="wrapper row3">
  <main class="hoc container clear"> 
    <!-- main body -->
    <!-- ################################################################################################ -->
    <div class="content"> 
      <!-- ################################################################################################ -->
      <div id="gallery">
        <figure>
          <header class="heading">Technology Meetups</header>
          <br><br>
          <ul class="nospace clear">
            <li class="one_third first"><a href="login.php"><img src="images/demo/Technology Themes/Machine Learning.jpg" alt="">Machine Learning</a></li>
            <li class="one_third"><a href="login.php"><img src="images/demo/Technology Themes/AI.png" alt="">Artificial Intelligence</a></li>
            <li class="one_third"><a href="login.php"><img src="images/demo/Technology Themes/Big Data.png" alt="">Big Data</a></li>
            <li class="one_third first"><a href="login.php"><img src="images/demo/Technology Themes/PHP2.jpg" alt="">PHP &amp MySQL</a></li>
            <li class="one_third"><a href="login.php"><img src="images/demo/Technology Themes/Security.jpg" alt="">Dev Ops</a></li>
            <li class="one_third"><a href="login.php"><img src="images/demo/Technology Themes/Algorithm.jpg" alt="">Algorithms</a></li>
          </ul>
          <!-- <figcaption>Optional Meetups Description Goes Here</figcaption> -->
        </figure>
      </div>
      <!-- ################################################################################################ -->
      <!-- ################################################################################################ -->
    </div>
    <!-- ################################################################################################ -->
    <!-- / main body -->
    <div class="clear"></div>
  </main>
</div>
<!-- ################################################################################################ -->
<!-- ################################################################################################ -->
<!-- ################################################################################################ -->
<div class="wrapper bgded overlay" style="background-image:url('images/demo/backgrounds/City6.jpg');">
  <article class="hoc container center"> 
    <!-- ################################################################################################ -->
    <div class="sectiontitle">
      <h3 class="heading">Meet Your City. Meet Your Life.</h3>
      <br>
      <p>Who are you ? What's going to make you smile ? What's going to make you thrive ? Whoever you're, you're going to become, we've got an experience for you. Seize what the city has to offer. Get ready for Meet Up.</p> <br>
      <p>In mere seconds you can scan a world of things to do, see , taste & feel. Explore yourself. Create some lasting bonds. Make new friends. Make spectacular family memories. We have something for everybody!</p>
    </div>
    <!-- <footer><a class="btn" href="#">Explore Now</a></footer> -->
    <!-- ################################################################################################ -->
  </article>
</div>
<!-- ################################################################################################ -->
<!-- ################################################################################################ -->
<!-- ################################################################################################ -->
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
<script src="layout/scripts/jquery.backtotop.js"></script>
<script src="layout/scripts/jquery.mobilemenu.js"></script>
<script src="layout/scripts/jquery.flexslider-min.js"></script>
</body>
</html>