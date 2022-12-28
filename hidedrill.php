<?php
if(isset($_REQUEST['drillid']))
{
  $drillid=$_REQUEST["drillid"];
  print('Drill deleted');
  $conn = mysqli_connect("localhost","cjcuser","computing","Exercises");
  $query=sprintf("UPDATE Drills SET Hidden=1 WHERE ID='%s'",$drillid);
  $result = mysqli_query($conn,$query) or die(mysqli_error($conn));
}
?>
