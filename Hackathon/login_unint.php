<?php
session_start();
if(isset($_SESSION['user_id']) && isset($_SESSION['username'])) header('Location: around_you.php');
$uname = $_POST['uname'];
$pass = $_POST['pass'];

if(empty($uname) || empty($pass)) header('Location:index.php');
$loc = 'around_you.php';
$con = mysqli_connect("localhost","root","","hackathon") or die('error');
$query = "select uid,password from users where uname = '".($uname)."'";
echo $query;
$res = mysqli_query($con,$query) or die('error');
if(mysqli_num_rows($res)==1)$row = mysqli_fetch_array($res);
else ?><script>alert('messed up');</script>
<?php
if($row['password']==sha1($pass))
{
	$_SESSION['user_id'] = $row['uid'];
	$_SESSION['username'] = $uname;
	header('Location:'.$loc);
}
else header('Location:index.php');
?>