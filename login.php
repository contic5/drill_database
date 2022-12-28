<html>
<head>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <link rel='stylesheet' href="material-components-web.min.css">
  <link rel='stylesheet' href="mystyle.css">
</head>
<body>
<?php
require("sessionstart.php");
if(isset($_POST['password']))
{
  $username=$_POST['username'];
  $password=$_POST['password'];
  $conn = mysqli_connect("localhost","cjcuser","computing","Exercises");
  $query=sprintf("SELECT * FROM Users WHERE Username='%s' AND Password='%s'",$username,$password);
  $result = mysqli_query($conn,$query) or die(mysqli_error($conn));
  $totalrows=mysqli_num_rows($result);
  if($totalrows==1)
  {
    $_SESSION['username']=$username;
    header("Location: index.php");
  }
}
?>
<h1>Drill Database</h1>
<p><a href="index.php">Home</a></p>
<form method='post'>
<p>Username:<input name='username'></p>
<p>Password:<input name='password'></p>
<p><button type='submit'>Login</button></p>
</form>
</body>
</html>
