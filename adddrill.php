<?php
if(isset($_REQUEST['drillname']))
{
  $drillname=$_REQUEST["drillname"];
  $difficulty=$_REQUEST['difficulty'];
  $category=$_REQUEST['category'];
  $difficultyid=0;
  if($difficulty=='Easy')
  {
    $difficultyid=0;
  }
  if($difficulty=='Medium')
  {
    $difficultyid=1;
  }
  if($difficulty=='Hard')
  {
    $difficultyid=2;
  }

  print('Added '.$drillname." | ".$category." | ".$difficulty);
  $resulttext='';
  $conn = mysqli_connect("localhost","cjcuser","computing","Exercises");
  $query=sprintf("INSERT INTO Drills(Name,Difficulty,Category,Hidden,DifficultyID)
  VALUES('%s','%s','%s','%s','%s')",
  $drillname,$difficulty,$category,0,$difficultyid);
  $result = mysqli_query($conn,$query) or die(mysqli_error($conn));
}
?>
