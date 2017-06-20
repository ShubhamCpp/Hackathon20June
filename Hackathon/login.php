<?php
session_start();
	if(isset($_SESSION['user_id']) && isset($_SESSION['username'])) header('Location: around_you.php');
	if(isset($_POST['submit']))
	{		
		$uname = $_POST['uname'];
		$pass = $_POST['pass'];
		if(empty($uname) || empty($pass)) 
		{ 
			echo "<script>alert('Empty Field/s');</script>"; 
		}
		$loc = 'around_you.php';
		$con = mysqli_connect("localhost","root","","hackathon") or die('error');
		$query = "select uid,password from users where uname = '".($uname)."'";		
		$res = mysqli_query($con,$query) or die('error');		
		if(mysqli_num_rows($res)==1)
		{			
			$row = mysqli_fetch_array($res);			
			if($row['password']==sha1($pass))
			{
				$_SESSION['user_id'] = $row['uid'];
				$_SESSION['username'] = $uname;
				header('Location:'.$loc);
			}
			else echo "<script>alert('Wrong Password');</script>";
		}
		else 
		{ 
			echo "<script>alert('Username Not Found');</script>";
		}				
	}	
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
        <li class="active"><a href="index.php">Home</a></li>
        <li><a class="active" href="#">About</a></li>        
        <li><a class="active" href="#">People</a></li>
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
<div class="bgded overlay" style="background-image:url('images/demo/backgrounds/Tech Meetup.png');">
  <div id="breadcrumb" class="hoc clear"> 
  </div>
</div>
<!-- ################################################################################################ -->
<!-- ################################################################################################ -->
<!-- ################################################################################################ -->
<div class="wrapper row3">
  <main class="hoc container clear"> 
    <!-- main body -->
    <!-- ################################################################################################ -->
    <div class="content"> 
      <!-- ################################################################################################ -->
      <div id="comments">
        <h2>Login</h2>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
          <div class="one_half first">
            <label for="name">Username <span>*</span></label>
            <input type="text" name="uname" id="name" value="" size="22" autofocus required>
          </div>          
          <div class="one_half first">
            <label for="NewPassword">Password <span>*</span></label>
            <input type="password" name="pass" id="NewPassword" value="" size="22" required>
          </div>               
          <div class="block clear" id="checkPasswordsMatch">

          </div>
          <br>
          <div>
            <input type="submit" name="submit" value="LOGIN">
            &nbsp;
          </div>
        </form>
      </div>
      <!-- ################################################################################################ -->
    </div>
    <!-- ################################################################################################ -->
    <!--  main body -->
    <div class="clear"></div>
  </main>
</div>

<div class="wrapper row5">
  <div id="copyright" class="hoc clear"> 
    <!-- ################################################################################################ -->
    <p class="fl_left">Copyright &copy; 2017 - All Rights Reserved - <a href="#">Meet Up By Honeywell, Inc.</a></p>
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