<?php
	session_start();
	if(isset($_SESSION['uname']) && isset($_SESSION['user_id'])) header('Location: around_you.php');
	$uname;$password;$email;$location;
	$con = mysqli_connect("localhost","root","","hackathon") or die('error establishing connection');
	function insertUserDetails()
	{
		global $uname,$password,$email,$location,$con;
		$insertUserDetailsQuery = "INSERT INTO users(uname,password,email,location) VALUES('$uname',sha1('$password'),'$email','$location')";
		$insertAffectedRows = mysqli_query($con,$insertUserDetailsQuery);// or die('Error Registering User');
		if($insertAffectedRows == 1)
		{
			$getInsertedUserIDQuery = "SELECT uid AS userid FROM users ORDER BY uid DESC LIMIT 1";
			$getInsertedUserIDResult = mysqli_query($con,$getInsertedUserIDQuery) or die('Error Fetching Inserted User Details');
			$getInsertedUserIDRow = mysqli_fetch_assoc($getInsertedUserIDResult);
			$_SESSION['user_id'] = $getInsertedUserIDRow['userid'];
			$_SESSION['username'] = $uname;
			header('Location: interests.php');
		}
		else
		{
			echo "<script>alert('A user with same username exists.try different one.')</script>";
		}
	}	
	if(isset($_POST['register']))
	{
		global $uname,$password,$email,$location;
		$uname = $_POST['uname'];
		$password = $_POST['password'];
		$email = $_POST['email'];
		$location = $_POST['location'];
		
		if(empty($uname) || empty($password) || empty($email) || empty($location))
		{
			echo "<script>alert('empty credentials');</script>";			
		}
		else insertUserDetails();
	}
?>

<!DOCTYPE html>
<html lang="">
<head>
<title>Meet Up</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<link href="layout/styles/layout.css" rel="stylesheet" type="text/css" media="all">
<script type="text/javascript"><!--
function checkPasswordMatch() {
    var password = $("#NewPassword").val();
    var confirmPassword = $("#ConfirmPassword").val();

    if (password != confirmPassword)
        $("#checkPasswordsMatch").html("Passwords do not match!");
    else
        $("#checkPasswordsMatch").html("Passwords match.");
}
//--></script>
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
        <h2>Registration</h2>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
          <div class="one_half first">
            <label for="name">Name <span>*</span></label>
            <input type="text" name="uname" id="name" value="" size="22" autofocus required>
          </div>
          <div class="one_half">
            <label for="email">E-Mail <span>*</span></label>
            <input type="email" name="email" id="email" value="" size="22" required>
          </div>
          <div class="one_half first">
            <label for="NewPassword">Password <span>*</span></label>
            <input type="password" name="password" id="NewPassword" value="" size="22" required>
          </div>
          <div class="one_half">
            <label for="ConfirmPassword">Re-enter Password <span>*</span></label>
            <input type="password" name="ConfirmPassword" id="ConfirmPassword" value="" size="22" onChange="checkPasswordMatch();" required>
          </div>
          <div class="block clear">
            <label for="location">Location </label>
            <select type="text" name="location" id="location" value="Bangalore">
                      <option value="1">Hyderabad</option>
                      <option value="2">Bangalore</option>
                      <option value="3">Mumbai</option>
                      <option value="4">Delhi</option>                     
            </select>
          </div>
          <div class="block clear" id="checkPasswordsMatch">

          </div>
          <br><br>
          <div>
            <input type="submit" name="register" value="Submit Form">
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